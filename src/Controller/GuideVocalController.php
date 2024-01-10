<?php

namespace App\Controller;

use App\Entity\GuideVocal;
use App\Form\GuideVocalType;
use App\Repository\GuideVocalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/guide/vocal")
 */
class GuideVocalController extends AbstractController
{
    /**
     * @Route("/", name="app_guide_vocal_index", methods={"GET"})
     */
    public function index(GuideVocalRepository $guideVocalRepository): Response
    {
        return $this->render('guide_vocal/index.html.twig', [
            'guide_vocals' => $guideVocalRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_guide_vocal_new", methods={"GET", "POST"})
     */
    public function new(Request $request, GuideVocalRepository $guideVocalRepository): Response
    {
        $guideVocal = new GuideVocal();
        $form = $this->createForm(GuideVocalType::class, $guideVocal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $guideVocalRepository->add($guideVocal, true);

            return $this->redirectToRoute('app_guide_vocal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('guide_vocal/new.html.twig', [
            'guide_vocal' => $guideVocal,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_guide_vocal_show", methods={"GET"})
     */
    public function show(GuideVocal $guideVocal): Response
    {
        return $this->render('guide_vocal/show.html.twig', [
            'guide_vocal' => $guideVocal,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_guide_vocal_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, GuideVocal $guideVocal, GuideVocalRepository $guideVocalRepository): Response
    {
        $form = $this->createForm(GuideVocalType::class, $guideVocal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $guideVocalRepository->add($guideVocal, true);

            return $this->redirectToRoute('app_guide_vocal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('guide_vocal/edit.html.twig', [
            'guide_vocal' => $guideVocal,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_guide_vocal_delete", methods={"POST"})
     */
    public function delete(Request $request, GuideVocal $guideVocal, GuideVocalRepository $guideVocalRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$guideVocal->getId(), $request->request->get('_token'))) {
            $guideVocalRepository->remove($guideVocal, true);
        }

        return $this->redirectToRoute('app_guide_vocal_index', [], Response::HTTP_SEE_OTHER);
    }
}
