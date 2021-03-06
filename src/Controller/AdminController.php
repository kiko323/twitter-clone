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
use Symfony\Component\Validator\Constraints\DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class AdminController extends AbstractController {

  /**
   * @Route("/admin", name="administrator")
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function indexAction (Connection $conn, Request $req) {

    $form = $this->insertPost($req); //show the Post form

    $pager = $this->paginate($req);

    return $this->render('admin/index.html.twig', array(
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

  public function insertPost ($request) {
    $post = new Posts();

    $form = $this->createForm(PostType::class, $post);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $entityManager = $this->getDoctrine()->getManager();
      $post->setPostsCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
      $entityManager->persist($post);
      $entityManager->flush();
    }
    return $form;
  }

  /**
   * @Route("/admin/delete/{id}", name="delete-post-admin")
   */

  public function deleteFieldAction ($id) {
    $entityManager = $this->getDoctrine()->getManager();

    $post = $entityManager->getRepository(Posts::class)->find($id);

    $entityManager->remove($post);
    $entityManager->flush();

    return $this->redirectToRoute('administrator');

  }

}