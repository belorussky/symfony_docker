<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Form\TodoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
//    /**
//     * @Route("/first", name="first")
//     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();

        $todo = new Todo();
        $todo->setStatus('nd Status')
            ->setPriority('Low')
            ->setName('nd')
            ->setDateCreation(new \DateTime());

        $em->persist($todo);
        $em->flush();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/FirstController.php',
        ]);
    }

    /**
     * @Route("/todo/{name}", name="todo")
     */
    public function todo(string $name, Request $request)
    {
        $form = $this->createForm(TodoType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $todoData = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($todoData);
            $em->flush();
        }
//        $form = $this->createFormBuilder()
//            ->add('username', EmailType::class)
//            ->add('password', PasswordType::class)
//            ->getForm();

        return $this->render('app/todo.html.twig', array(
            'name' => $name,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/todo/db/details", name="todo_details")
     */
    public function getDetails()
    {
        //$todo = $this->getDoctrine()->getRepository(Todo::class)->find(1);
        //$todos = $this->getDoctrine()->getRepository(Todo::class)->findAll();
//        $todo = $this->getDoctrine()->getRepository(Todo::class)->findBy(
//            [
//                'name' => 'Secondfsdf'
//            ]
//        );
        $todo = $this->getDoctrine()->getRepository(Todo::class)->findByName('New Name');

        if(!$todo) {
            throw $this->createNotFoundException(
                'Np record for the todo with the id: '. 10
            );
        }
//        foreach($todos as $todo) {
//            echo $todo->getName() . '</br>';
//        }
        return new Response('todo name: '. $todo->getName());
    }

    /**
     * @Route("/edit-todo/{id}", name="edit_todo")
     */
    public function editTodo(int $id, Request $request)
    {
        $todo = $this->getDoctrine()->getRepository(Todo::class)->find($id);
        $form = $this->createForm(TodoType::class);
        $form->setData($todo);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $todoData = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($todoData);
            $em->flush();
        }

        return $this->render('app/todo.html.twig', array(
            'name' => $todo->getName(),
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/updatetodo/{id}", name="update_todo")
     */
    public function updateTodo($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $todo = $entityManager->getRepository(Todo::class)->find($id);

        if(!$todo) {
            throw $this->createNotFoundException(
                'Np record for the todo with the id: '. $id
            );
        }
        //update fields
        $todo->setPriority('Medium')
            ->setName('Update ' . $todo->getName());

        $entityManager->flush();

        return new Response('todo name: '. $id);
    }

    /**
     * @Route("/deletetodo/{id}", name="delete_todo")
     */
    public function deleteTodo($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $todo = $entityManager->getRepository(Todo::class)->find($id);

        if(!$todo) {
            throw $this->createNotFoundException(
                'Np record for the todo with the id: '. $id
            );
        }
        $entityManager->remove($todo);
        $entityManager->flush();

        return new Response("Todo with $id is removed correctly!");
    }
}
