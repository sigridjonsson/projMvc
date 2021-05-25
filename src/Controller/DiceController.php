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

        $session->set('bitcoins', $session->get('bitcoins') ?? 10);
        $session->set('bank', $session->get('bank') ?? 100);

        // $session->set('bitcoins', 10);
        // $session->set('bank', 100);

        $session->set('diceNr', $session->get('diceNr') ?? null);
        $session->set('class', $session->get('class') ?? null);
        $session->set('hist', "");

        if ($request->getMethod() == 'POST') {
            if ($request->get('diceChoice') == 'one') {
                $session->set('diceNr', 'one');
                $gamble = $request->request->get("money");
                $session->set('gamble', $gamble);
                return $this->redirectToRoute('playGame');
            } else if ($request->get('diceChoice') == 'two') {
                $session->set('diceNr', 'two');
                $gamble = $request->request->get("money");
                $session->set('gamble', $gamble);
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
            'bitcoins' => $session->get('bitcoins'),
            'bank' => $session->get('bank'),
            'diceNr' => $session->get('diceNr'),
            'class' => $session->get('class'),
        ]);
    }


    /**
     * @Route("/play", name="playGame")
    */
    public function playGame(SessionInterface $session, Request $request): Response
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
            // Remove gamble from old amount
            $newAmount = $session->get('bitcoins') - $session->get('gamble');
            $session->set('bitcoins', $newAmount);
            // Add gamble to bank
            $remove = $session->get('bank') + $session->get('gamble');
            $session->set('bank', $remove);
        } else if ($session->get('total') == 21) {
            $something = $session->get('win');
            $session->set('win', $something += 1);
            // Add gamble to old amount
            $newAmount = $session->get('bitcoins') + $session->get('gamble');
            $session->set('bitcoins', $newAmount);
            // Remove gamble from bank
            $remove = $session->get('bank') - $session->get('gamble');
            $session->set('bank', $remove);
        }



        $hist = implode(", ", $res);
        $hist .= " ," . $session->get('hist');
        // $test = strrev($hist);
        $session->set('hist', $hist);
        // $allHist = "";
        // $this->testidk .= $hist;

        return $this->render('diceGame.html.twig', [
            'total' => $session->get('total'),
            'class' => $session->get('class'),
            'list' => $session->get('hist'),
        ]);
    }

    /**
     * @Route("/res", name="resGame")
    */
    public function resGame(SessionInterface $session): Response
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

        $message = "";

        if ($session->get('total') == 21) {
            $something = $session->get('win');
            $session->set('win', $something += 1);
            // Add gamble to old amount
            $newAmount = $session->get('bitcoins') + $session->get('gamble');
            $session->set('bitcoins', $newAmount);
            // Remove gamble from bank
            $remove = $session->get('bank') - $session->get('gamble');
            $session->set('bank', $remove);
            $message = 'Du vann!';
        } else if ($session->get('total') > 21) {
            $something = $session->get('winComp');
            $session->set('winComp', $something += 1);
            // Remove gamble from old amount
            $newAmount = $session->get('bitcoins') - $session->get('gamble');
            $session->set('bitcoins', $newAmount);
            // Add gamble to bank
            $remove = $session->get('bank') + $session->get('gamble');
            $session->set('bank', $remove);
            $message = 'Datorn vann!';
        } else if ($diff > $diffComp) {
            $something = $session->get('winComp');
            $session->set('winComp', $something += 1);
            // Remove gamble from old amount
            $newAmount = $session->get('bitcoins') - $session->get('gamble');
            $session->set('bitcoins', $newAmount);
            // Add gamble to bank
            $remove = $session->get('bank') + $session->get('gamble');
            $session->set('bank', $remove);
            $message = 'Datorn vann!';
        } else if ($diff < $diffComp) {
            $something = $session->get('win');
            $session->set('win', $something += 1);
            // Add gamble to old amount
            $newAmount = $session->get('bitcoins') + $session->get('gamble');
            $session->set('bitcoins', $newAmount);
            // Remove gamble from bank
            $remove = $session->get('bank') - $session->get('gamble');
            $session->set('bank', $remove);
            $message = 'Du vann!';
        } else if ($diff == $diffComp) {
            $something = $session->get('winComp');
            $session->set('winComp', $something += 1);
            // Remove gamble from old amount
            $newAmount = $session->get('bitcoins') - $session->get('gamble');
            $session->set('bitcoins', $newAmount);
            // Add gamble to bank
            $remove = $session->get('bank') + $session->get('gamble');
            $session->set('bank', $remove);
            $message = 'Oavgjort!';
        }

        $fix = substr($session->get('hist'), 0, -2);
        $histogram = strrev($fix);

        return $this->render('diceGameRes.html.twig', [
            'total' => $session->get('total'),
            'totalComp' => $session->get('totalComp'),
            'message' => $message,
            'histogram' => $histogram
        ]);
    }
}
