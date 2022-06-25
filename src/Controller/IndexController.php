<?php
namespace App\Controller;

use App\Entity\Trick;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="show_index")
     */
    public function showIndex(ManagerRegistry $doctrine)
    {
        $tricks = $doctrine
            ->getRepository(Trick::class)
            ->findBy(
            [],
            ['createdAt' => 'DESC'],
            8,
            0
        );

        $count = $doctrine
            ->getRepository(Trick::class)
            ->findBy(
                [],
                ['createdAt' => 'DESC'],
                8,
                8
            );

        return $this->render('@client/pages/index.html.twig', [
            'tricks' => $tricks,
            'remain_tricks' => sizeof($count)>0
        ]);
    }




}
