<?php

namespace App\Controller;

use App\Entity\Camera;
use App\Form\CameraType;
use App\Repository\CameraRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/camera")
 */
class CameraController extends AbstractController
{
    /**
     * @Route("/", name="app_camera_index", methods={"GET"})
     */
    public function index(CameraRepository $cameraRepository): Response
    {
        return $this->render('camera/index.html.twig', [
            'cameras' => $cameraRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_camera_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CameraRepository $cameraRepository): Response
    {
        $camera = new Camera();
        $form = $this->createForm(CameraType::class, $camera);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cameraRepository->add($camera, true);

            return $this->redirectToRoute('app_camera_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('camera/new.html.twig', [
            'camera' => $camera,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/camera/{id}", name="app_camera_show", methods={"GET"})
     */
    public function show(Camera $camera): Response
    {
        return $this->render('camera/show.html.twig', [
            'camera' => $camera,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_camera_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Camera $camera, CameraRepository $cameraRepository): Response
    {
        $form = $this->createForm(CameraType::class, $camera);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cameraRepository->add($camera, true);

            return $this->redirectToRoute('app_camera_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('camera/edit.html.twig', [
            'camera' => $camera,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_camera_delete", methods={"POST"})
     */
    public function delete(Request $request, Camera $camera, CameraRepository $cameraRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $camera->getId(), $request->request->get('_token'))) {
            $cameraRepository->remove($camera, true);
        }

        return $this->redirectToRoute('app_camera_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/camera/capture", name="app_camera_capture", methods={"GET", "POST"})
     */
    public function capture(): Response
    {
        return $this->render('camera/capture.html.twig');
    }
}
