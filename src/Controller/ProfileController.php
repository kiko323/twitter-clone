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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ProfileController extends Controller {

  /**
   * @Route("/profile", name="profile")
   * @Security("has_role('ROLE_USER')")
   */
  public function indexAction (Request $req) {

    $pager = $this->paginate($req);
    # $username= $this->fetchUserOfPost($this->fetch());

    return $this->render('profile/index.html.twig', array(
      'posts' => $pager,
    ));

  }

  public function fetch () {

    $posts = $this->getDoctrine()->getRepository(Posts::class)->findby(array('userId' => $this->getUser()->getId()),
      array('id' => 'DESC'));

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

  /**
   * @Route("/profile/delete/{id}", name="delete-post-profile")
   */

  public function deleteFieldAction ($id) {
    $entityManager = $this->getDoctrine()->getManager();

    $post = $entityManager->getRepository(Posts::class)->find($id);

    $entityManager->remove($post);
    $entityManager->flush();

    return $this->redirectToRoute('profile');
  }
}
