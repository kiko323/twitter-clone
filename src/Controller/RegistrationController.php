<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\RegisterType;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class RegistrationController extends Controller {

  /**
   * @Route("/register", name="registration")
   */
  public function registerAction (Request $req, UserPasswordEncoderInterface $passwordEncoder) {
    if ($this->getUser()) {
      return $this->redirectToRoute("home");
    }

    $user = new User();
    $form = $this->createForm(RegisterType::class, $user);

    $form->handleRequest($req);

    if ($form->isSubmitted() && $form->isValid()) {
      $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
      $user->setPassword($password);

      $em = $this->getDoctrine()->getManager();
      $em->persist($user);
      $em->flush();

      //tu ce biti slanje maila....

      //flashmessage o uspjesnosti
      $this->redirectToRoute('home');
    }

    return $this->render('registration/index.html.twig',
      array('regForm' => $form->createView())
    );
  }
}
