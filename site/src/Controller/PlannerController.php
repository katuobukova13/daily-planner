<?php

namespace App\Controller;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PlannerController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EntityManagerInterface $entityManager): \Symfony\Component\HttpFoundation\Response
    {
        $repository = $entityManager->getRepository(Task::class);
        $tasks = $repository->findByUserId($this->getUser());

        return $this->render('planner/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }
}