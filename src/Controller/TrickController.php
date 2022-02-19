<?php
namespace App\Controller;

use App\Entity\Trick;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    /**
     * @Route("/trick/{slug}", name="show_trick")
     */
    public function showTrick(ManagerRegistry $doctrine, String $slug)
    {
        $trick = $doctrine->getRepository(Trick::class)->findBy(['slug' => $slug]);

        if (!$trick) {
            throw $this->createNotFoundException(
                'Aucun trick pour l\'identifiant '.$slug
            );
        }

        return $this->render('@client/pages/trick.html.twig', [
            'trick' => $trick
        ]);
    }

    /**
     * @Route("/tricks", name="show_tricks")
     */
    public function showTricks()
    {
        return $this->render('@client/pages/trick.html.twig', []);
    }






}
