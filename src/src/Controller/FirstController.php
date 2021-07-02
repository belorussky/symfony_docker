<?php

namespace App\Controller;

use App\CustomEvents\TodoEvent;
use App\Entity\Todo;
use App\Entity\User;
use App\Form\TodoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {

        $em = $this->getDoctrine()->getManager();

        $todos = $em->getRepository(Todo::class)->findAll();

        return $this->render('app/index.html.twig', [
            'todos' => $todos,
        ]);
    }

    /**
     * @Route("/add", name="add-todo")
     */
    public function todo(Request $request)
    {
        $form = $this->createForm(TodoType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            try {
                $todoData = $form->getData();
                $em = $this->getDoctrine()->getManager();

                $this->addFlash(
                    'notice',
                    'Your todo is record'
                );

                $em->persist($todoData);
                $em->flush();
            } catch (\Exception $exception) {

            }
        }


        return $this->render('app/todo.html.twig', array(
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
    public function editTodo(int $id, Request $request, EventDispatcherInterface $eventDispatcher)
    {
        $todo = $this->getDoctrine()->getRepository(Todo::class)->find($id);

        $todoEvent = new TodoEvent($todo);
        $eventDispatcher->dispatch(TodoEvent::NAME, $todoEvent);


        $form = $this->createForm(TodoType::class);
        $form->setData($todo);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $todoData = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $this->addFlash(
                'notice',
                'Your todo is record');
            $em->persist($todoData);
            $em->flush();
        }

        return $this->render('app/todo.html.twig', array(
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

        $this->addFlash(
            'notice',
            'Todo deleted correctly');

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/closeTodo/{id}", name="close_todo")
     */
    public function closeTodo($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $todo = $entityManager->getRepository(Todo::class)->find($id);

        if(!$todo) {
            throw $this->createNotFoundException(
                'Np record for the todo with the id: '. $id
            );
        }
        $todo->setStatus('done');
        $entityManager->flush();

        $this->addFlash(
            'notice',
            "Todo $id updated correctly");

        return $this->redirectToRoute('home');
    }
}
