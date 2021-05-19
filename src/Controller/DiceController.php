<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Dice\Dice;
use App\Dice\GraphicalDice;

class DiceController extends AbstractController
{
    /**
     * @Route("/dice21", name="dice21")
    */
    public function welcome(SessionInterface $session, Request $request): Response
    {
        $session->set('total', 0);
        $session->set('win', $session->get('win') ?? 0);
        $session->set('winComp', $session->get('winComp') ?? 0);
        $session->set('diceNr', $session->get('diceNr') ?? null);
        $session->set('class', $session->get('class') ?? null);

        if ($request->getMethod() == 'POST') {
            if ($request->get('diceChoice') == 'one') {
                $session->set('diceNr', 'one');
                return $this->redirectToRoute('playGame');
            } else if ($request->get('diceChoice') == 'two') {
                $session->set('diceNr', 'two');
                return $this->redirectToRoute('playGame');
            } else if ($request->get('zero') == 'Nollställ') {
                $session->set('win', 0);
                $session->set('winComp', 0);
                return $this->redirectToRoute('dice21');
            }
        }
        return $this->render('dice.html.twig', [
            'total' => $session->get('total'),
            'win' => $session->get('win'),
            'winComp' => $session->get('winComp'),
            'diceNr' => $session->get('diceNr'),
            'class' => $session->get('class'),
        ]);
    }


    /**
     * @Route("/play", name="playGame")
    */
    public function playGame(SessionInterface $session, Request $request)
    {

        if ($request->getMethod() == 'POST') {
            if ($request->get('btn') == 'Stanna!') {
                return $this->redirectToRoute('resGame');
            } else if ($request->get('btn') == "Slå igen!") {
                return $this->redirectToRoute('playGame');
            }
        }
        $diceGraph = new GraphicalDice();
        $res = [];
        $class = [];

        if ($session->get('diceNr') == "one") {
            for ($i = 0; $i < 1; $i++) {
                $res[] = $diceGraph->roll();
                $class[] = $diceGraph->graphic();
            }
            $something = $session->get('total');
            $session->set('total', $something += $diceGraph->getLastRoll());
        } else if ($session->get('diceNr') == "two") {
            for ($i = 0; $i < 2; $i++) {
                $res[] = $diceGraph->roll();
                $class[] = $diceGraph->graphic();
            }
            $something = $session->get('total');
            $session->set('total', $something += array_sum($res));
        }

        $session->set('class', $class);

        if ($session->get('total') > 21) {
            $something = $session->get('winComp');
            $session->set('winComp', $something += 1);
        } else if ($session->get('total') == 21) {
            $something = $session->get('win');
            $session->set('win', $something += 1);
        }

        return $this->render('diceGame.html.twig', [
            'total' => $session->get('total'),
            'class' => $session->get('class'),
        ]);
    }

    /**
     * @Route("/res", name="resGame")
    */
    public function resGame(SessionInterface $session)
    {
        $session->set('totalComp', 0);

        $diceComp = new Dice();
        while ($session->get('totalComp') <= 21) {
            $diceComp->roll();
            $something = $session->get('totalComp');
            $session->set('totalComp', $something += $diceComp->getLastRoll());
        }
        $diff = 21 - $session->get('total');
        $diffComp = $session->get('totalComp') - 21;


        if ($session->get('total') == 21) {
            $something = $session->get('win');
            $session->set('win', $something += 1);
            $message = 'Du vann!';
        } else if ($session->get('total') > 21) {
            $something = $session->get('winComp');
            $session->set('winComp', $something += 1);
            $message = 'Datorn vann!';
        } else if ($diff > $diffComp) {
            $something = $session->get('winComp');
            $session->set('winComp', $something += 1);
            $message = 'Datorn vann!';
        } else if ($diff < $diffComp) {
            $something = $session->get('win');
            $session->set('win', $something += 1);
            $message = 'Du vann!';
        } else if ($diff == $diffComp) {
            $something = $session->get('winComp');
            $session->set('winComp', $something += 1);
            $message = 'Oavgjort!';
        }

        return $this->render('diceGameRes.html.twig', [
            'total' => $session->get('total'),
            'totalComp' => $session->get('totalComp'),
            'message' => $message,
        ]);
    }
}
