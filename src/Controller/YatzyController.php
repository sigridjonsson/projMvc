<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Dice\GraphicalDice;
use App\Entity\Highscore;
use App\Entity\Histogram;

class YatzyController extends AbstractController
{
    /**
     * @Route("/yatzy", name="yatzy")
    */
    public function welcome(SessionInterface $session, Request $request): Response
    {
        $session->set('rounds', 0);
        $session->set('section', 1);
        $session->set('scoreYatzy', 0);

        $session->set('dice1', true);
        $session->set('dice2', true);
        $session->set('dice3', true);
        $session->set('dice4', true);
        $session->set('dice5', true);

        if ($request->getMethod() == 'POST') {
            $userName = $request->request->get("usr");
            $session->set('userName', $userName);
            return $this->redirectToRoute('playYatzy');
        }


        return $this->render('yatzy.html.twig', [
            'info' => 'YATZY'
        ]);
    }


    /**
     * @Route("/playYatzy", name="playYatzy")
    */
    public function playGame(SessionInterface $session, Request $request)
    {
        if ($request->get('diceOne')) {
            $session->set('dice1', false);
        }
        if ($request->get('diceTwo')) {
            $session->set('dice2', false);
        }
        if ($request->get('diceThree')) {
            $session->set('dice3', false);
        }
        if ($request->get('diceFour')) {
            $session->set('dice4', false);
        }
        if ($request->get('diceFive')) {
            $session->set('dice5', false);
        }

        if ($request->get('btn') == 'Slå igen!') {
            return $this->redirectToRoute('playYatzy');
        } else if ($request->get('btn') == "Resultat!") {
            return $this->redirectToRoute('resYatzy');
        }

        $something = $session->get('rounds');
        $session->set('rounds', $something += 1);

        $diceGraph = new GraphicalDice();

        $result = [];


        if ($session->get('dice1')) {
            $displayDice = $diceGraph->roll();
            $result[] = $displayDice;
            $session->set('dice1Val', $diceGraph->graphic());
        }
        if ($session->get('dice2')) {
            $displayDice = $diceGraph->roll();
            $result[] = $displayDice;
            $session->set('dice2Val', $diceGraph->graphic());
        }
        if ($session->get('dice3')) {
            $displayDice = $diceGraph->roll();
            $result[] = $displayDice;
            $session->set('dice3Val', $diceGraph->graphic());
        }
        if ($session->get('dice4')) {
            $displayDice = $diceGraph->roll();
            $result[] = $displayDice;
            $session->set('dice4Val', $diceGraph->graphic());
        }
        if ($session->get('dice5')) {
            $displayDice = $diceGraph->roll();
            $result[] = $displayDice;
            $session->set('dice5Val', $diceGraph->graphic());
        }


        $listOfDices = [];
        array_push($listOfDices, $session->get('dice1Val'), $session->get('dice2Val'), $session->get('dice3Val'), $session->get('dice4Val'), $session->get('dice5Val'));

        $session->set('dice1', true);
        $session->set('dice2', true);
        $session->set('dice3', true);
        $session->set('dice4', true);
        $session->set('dice5', true);

        if ($session->get('rounds') == 4) {
            $session->set('rounds', 1);
            $something = $session->get('section');
            $session->set('section', $something += 1);
        } else if ($session->get('rounds') == 3) {
            $dices = [];
            foreach ($listOfDices as $value) {
                $dices[] = intval(substr($value, -1, 1));
            }

            foreach ($dices as $value) {
                if ($value == $session->get('section')) {
                    $something = $session->get('scoreYatzy');
                    $session->set('scoreYatzy', $something += $value);
                }
            }
        }

        return $this->render('yatzyGame.html.twig', [
            'section' => $session->get('section'),
            'rounds' => $session->get('rounds'),
            'scoreYatzy' => $session->get('scoreYatzy'),
            'listOfDices' => $listOfDices,
            'userName' => $session->get('userName'),
        ]);
    }




    /**
     * @Route("/resYatzy", name="resYatzy")
    */
    public function resGame(SessionInterface $session)
    {
        require_once "../bin/bootstrap.php";

        $message = "";

        if ($session->get('scoreYatzy') >= 63) {
            $score = $session->get('scoreYatzy');
            $session->set('scoreYatzy', $score + 50);
            $message = "Grattis! Du samlade ihop 63 poäng eller mer
            och har därför gjort dig förtjänt av bonusen på 50 poäng.";
        } else if ($session->get('scoreYatzy') < 63) {
            $message = "Grattis!";
        }

        if ($session->get('scoreYatzy') >= 50) {
            $highscore = new Highscore();
            $highscore->setScore($session->get('scoreYatzy'));
            $highscore->setDate();
            $highscore->setUserName($session->get('userName'));

            $entityManager->persist($highscore);
            $entityManager->flush();
        }

        $histClass = new Histogram();
        $histClass->setDices("");
        $histClass->setScore($session->get('scoreYatzy'));
        $histClass->setDate();
        $histClass->setGame("Yatzy");

        $entityManager->persist($histClass);
        $entityManager->flush();

        return $this->render('yatzyGameRes.html.twig', [
            'scoreYatzy' => $session->get('scoreYatzy'),
            'message' => $message,
        ]);
    }
}
