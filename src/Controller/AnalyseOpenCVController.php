<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class AnalyseOpenCVController extends AbstractController
{
    
    public function runPythonScript(): Response
    {
        $process = new Process(['python', 'public/python/script.py']);
        $process->run();

        // Vérifie si l'exécution du script a échoué
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // Récupère la sortie du script
        $output = $process->getOutput();

        // Utilisez la sortie comme vous le souhaitez dans votre application Symfony
        return new Response($output);
    }
}
