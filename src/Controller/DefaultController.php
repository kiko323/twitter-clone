<?php

namespace App\Controller;

use App\Entity\User;
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
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Core\Role\Role;


class DefaultController extends AbstractController {

  /**
   * @Route("/", name="home")
   *
   */
  public function indexAction (Request $req) {

    if ($this->getUser()) {
      if ($this->getUser()->getRoles() == array('0' => 'ROLE_ADMIN')) {
        return $this->redirectToRoute("administrator");
      } else {
      }
    }
    $form = $this->insertPost($req); //show the Post form
    $pager = $this->paginate($req);
    # $username= $this->fetchUserOfPost($this->fetch());

    return $this->render('default/index.html.twig', array(
      'posts' => $pager,
      'post_form' => $form->createView()
    ));


  }

  public function fetch () {

    $posts = $this->getDoctrine()->getRepository(Posts::class)->findby(array(), array('id' => 'DESC'));
    return $posts;
  }

  public function paginate ($req) {
    $pagenum = $req->query->getInt('page', 1);

    $posts = $this->fetch();

    $adapter = new ArrayAdapter($posts);
    $pagerfanta = new Pagerfanta($adapter);

    $pagerfanta->setMaxPerPage(5);
    $pagerfanta->setCurrentPage($pagenum);

    return $pagerfanta;
  }

  public function fetchActiveUser () {

    if ($this->getUser()) {

      $userid = $this->getUser()->getId();
      $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(array(
        'id' => $userid
      ));

      return $user;
    }

  }

  public function insertPost ($request) {
    $post = new Posts();
    $user = $this->fetchActiveUser();

    $form = $this->createForm(PostType::class, $post);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $entityManager = $this->getDoctrine()->getManager();
      $post->setPostsCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
      $post->setUserId($user);

      $entityManager->persist($post);

      $entityManager->flush();
    }
    return $form;
  }

}

