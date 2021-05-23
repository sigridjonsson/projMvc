<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 */
class HighscoreController extends AbstractController
{
    /**
     * @Route("/highscore")
    */
    public function highscore()
    {
        require_once "../bin/bootstrap.php";

        $highscoreRepository = $entityManager->getRepository('\App\Entity\Highscore');
        $highscore = $highscoreRepository->findBy([], ['score' => 'DESC']);

        return $this->render('highscore.html.twig', [
            'info' => "Highscore",
            'highscore' => $highscore,
            'rank' => 1
        ]);
    }
}
