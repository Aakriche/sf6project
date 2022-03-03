<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ToDoController extends AbstractController
{
    #[Route('/todo', name: 'todo')]
    public function index(Request $request): Response
    {
        $session = $request->getSession();

        if (!$session->has('todos')){
            $todos =[
                'achat' => 'acheter clé usb',
                'cours' => 'Finaliser mon cours',
                'correction' => 'corriger les examens'
            ];
            $session->set('todos', $todos);
            $this->addFlash('info, "la liste des todos est initialisée');
        }

        return $this->render('todo/index.html.twig');
    }

    #[Route('/todo/add/{name}/{content}', 'todo.add')]
    public function addTodo (Request $request, $name, $content): RedirectResponse {
        $session = $request->getSession();
        if ($session->has('todos')) {
            $todos = $session->get('todos');
            if(isset($todos[$name])){
                $this->addFlash('error', "Le todo $name est déjà dans la liste");
            } else {

                $todos[$name] = $content;
                $this->addFlash('success', " $name est ajouté");
                $session->set('todos', $todos);
            }

        } else {

            $this->addFlash('error', "La liste des todos n'est pas initlaisée pour le moment");
        }
        return $this->redirectToRoute('todo');
    }

    #[Route('/todo/update/{name}/{content}', 'todo.update')]
    public function updateTodo (Request $request, $name, $content): RedirectResponse {
        $session = $request->getSession();
        if ($session->has('todos')) {
            $todos = $session->get('todos');
            if(isset($todos[$name])){

                $todos[$name] = $content;
                $session->set('todos', $todos);
                $this->addFlash('success', "Le todo $name est modifié");
            } else {

                $this->addFlash('error', " $name n'existe pas");
                $session->set('todos', $todos);
            }

        } else {

            $this->addFlash('error', "La liste des todos n'est pas initlaisée pour le moment");
        }
        return $this->redirectToRoute('todo');
    }

    #[Route('/todo/delete/{name}', 'todo.delete')]
    public function deleteTodo (Request $request, $name): RedirectResponse {
        $session = $request->getSession();
        if ($session->has('todos')) {
            $todos = $session->get('todos');
            if(isset($todos[$name])){

                unset($todos[$name]);
                $session->set('todos', $todos);
                $this->addFlash('success', "Le todo $name est supprimé");
            } else {

                $this->addFlash('error', " $name n'existe pas");
                $session->set('todos', $todos);
            }

        } else {

            $this->addFlash('error', "La liste des todos n'est pas initlaisée pour le moment");
        }
        return $this->redirectToRoute('todo');
    }

    #[Route('/todo/reset', 'todo.reset')]
    public function resetTodo (Request $request): RedirectResponse {
        $session = $request->getSession();
        if ($session->has('todos')) {
            $todos = [];
            $session->set('todos', $todos);
            $this->addFlash('sucess', "Liste réinitialisée ");

        } else {

            $this->addFlash('error', "La liste des todos n'est pas initlaisée pour le moment");
        }
        return $this->redirectToRoute('todo');
    }

}
