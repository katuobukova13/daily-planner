<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PlannerController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('planner/index.html.twig');
    }
}