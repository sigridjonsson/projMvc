<?php

namespace App\Controller;

use App\Entity\Histogram;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 */
class HistogramController extends AbstractController
{
    /**
     * @Route("/histogram")
    */
    public function histogram()
    {
        require_once "../bin/bootstrap.php";

        $histogramRepository = $entityManager->getRepository('\App\Entity\Histogram');
        $histogram = $histogramRepository->findBy([], ['date' => 'DESC']);

        return $this->render('histogram.html.twig', [
            'info' => "Histogram",
            'histogram' => $histogram,
        ]);
    }
}
