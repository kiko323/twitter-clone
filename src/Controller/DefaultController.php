<?php
namespace App\Controller;

use App\Form\PostType;
use Doctrine\DBAL\Types\TextType;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Posts;
use Pagerfanta\Adapter\DoctrineORMAdapter;


class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     *
     */
    public function index(Connection $conn, Request $req){


       // die( print ($pagenum));

        $form= $this->prepareForm($req, $conn); //show the Post form
        $posts = $this->fetch(); //fetching all posts

        $pager=$this->paginate($req);

            return $this->render('default/index.html.twig', array(
               'posts' =>$pager,
                'post_form'=> $form->createView()
            ));


    }


    public function fetch()
    {

        $posts=$this->getDoctrine()->getRepository(Posts::class)->findby(array(), array('id' => 'DESC'));

       return $posts;

    }

    /**
     *
     */

    public function paginate($req)
    {
        $pagenum=$req->query->getInt('page',1);

        $posts= $this->fetch();

        $adapter= new ArrayAdapter($posts);
        $pagerfanta=new Pagerfanta($adapter);

        $pagerfanta->setMaxPerPage(5);
        $pagerfanta->setCurrentPage($pagenum);  //ovdje ubaciti koji je page

        return $pagerfanta;
    }


    public function prepareForm($request, $conn)
    {
        $form = $this->createForm(PostType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $postFormData=$form->getData(); //moooozda ce trebati return $this->redirectToRoute('/');

            $this->insertFields($postFormData['email'], $postFormData['message']);

            dump($postFormData);
        }


        return $form;
    }

    public function insertFields($email, $message)
    {
       $entityManager = $this->getDoctrine()->getManager();

       $post= new Posts();

       $post->setPostsEmail($email);
       $post->setPostsMsg($message);


       $entityManager->persist($post);

       $entityManager->flush();


        //$conn->query("INSERT INTO posts (posts_email, posts_msg) VALUES ('$email','$message')");
    }


    /**
     * @Route("/delete/{id}", name="delete-post")
     */

    public function deleteField($id)
    {
        $entityManager = $this->getDoctrine()->getManager();


        $post = $entityManager->getRepository(Posts::class)->find($id);


        $entityManager->remove($post);
        $entityManager->flush();

        return $this->redirectToRoute('home');

    }











}

