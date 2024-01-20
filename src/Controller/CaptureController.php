<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CaptureController extends AbstractController
{
    /**
     * @Route("/capture", name="app_capture")
     */
    public function index(): Response
    {
        // return $this->render('capture/index.html.twig', [
        //     'controller_name' => 'CaptureController',
        // ]);
        return $this->render('capture/capture.html.twig');
    }
}
