<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use App\Security\TaskVoter;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends AbstractController
{
    /**
     * @Route("/tasks", name="task_list")
     */
    public function listAction(TaskRepository $task)
    {
        return $this->render('task/list.html.twig', ['tasks' => $task->findAll()]);
    }

    /**
     * @Route("/tasks/create", name="task_create")
     */
    public function createAction(Request $request, ManagerRegistry $doctrine)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $task->setUser($this->getUser());
            $manager->persist($task);
            $manager->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function editAction(Task $task, Request $request, ManagerRegistry $doctrine)
    {
        $this->denyAccessUnlessGranted(TaskVoter::MANAGE, $task);
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(Task $task, ManagerRegistry $doctrine)
    {
        $this->denyAccessUnlessGranted(TaskVoter::MANAGE, $task);
        $task->toggle(!$task->isDone());
        $manager = $doctrine->getManager();
        $manager->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(Task $task, ManagerRegistry $doctrine)
    {
        $this->denyAccessUnlessGranted(TaskVoter::MANAGE, $task);
        $manager = $doctrine->getManager();
        $manager->remove($task);
        $manager->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
