<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/first', name: 'app_first')]
    public function index(): Response
    {

        return $this->render('first/index.html.twig', [
            'controller_name' => 'FirstController',
        ]);
    }

    #[Route('/sayHello', name: 'say_hello')]
    public function sayHello(): Response
    {
        $rand = rand(0, 4);
        echo $rand;
        if ($rand == 2) {
            return $this->redirectToRoute('app_first');
        }
            return $this->forward('App\\Controller\FirstController::index');

    }

    #[Route('/sayHello/{name}/{firstname}', name: 'say_hello')]
    public function sayHelloToSomeone($name, $firstname): Response
    {

        return $this->render('first/index.html.twig', [
            'name' => $name,
            'firstname' => $firstname
        ]);

    }

}
