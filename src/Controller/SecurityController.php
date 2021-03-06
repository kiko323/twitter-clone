<?php

namespace App\Controller;

use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends Controller {

  /**
   * @Route ("/login", name="login")
   */
  public function loginAction (AuthenticationUtils $authenticationUtils) {
    $error = $authenticationUtils->getLastAuthenticationError();
    $lastUsername = $authenticationUtils->getLastUsername();

    if ($error) {
      $this->addFlash(
        'error',
        $error->getMessage()
      );
    }

    return $this->render('security/login.html.twig', array(
      'last_username' => $lastUsername,
      'error' => $error
    ));
  }
}
