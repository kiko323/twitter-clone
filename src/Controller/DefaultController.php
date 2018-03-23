<?php
namespace App\Controller;

use App\Form\PostType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Posts;


class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Connection $conn, Request $req){


        $form= $this->prepareForm($req, $conn); //show the Post form
        $posts = $this->fetch(); //fetching all posts

            return $this->render('default/index.html.twig', array(
                'posts' =>$posts,
                'post_form'=> $form->createView()
            ));


    }

    public function fetch()
    {
        $posts=$this->getDoctrine()->getRepository(Posts::class)->findby(array(), array('id' => 'DESC'));

        //$posts=$connection->fetchAll('SELECT * FROM posts ORDER BY id DESC');
        return $posts;
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











}

