<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        //$error = new CustomUserMessageAuthenticationException('Email ou mot de passe incorrect');
        $lastUsername = $authenticationUtils->getLastUsername();
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);

    }

     /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): Response
    {
        throw new \Exception('This will never be reached as component security will manage the route');
    }
}
