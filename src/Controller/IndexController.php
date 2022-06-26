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
        /* Get the 8 last tricks */
        $tricks = $doctrine
            ->getRepository(Trick::class)
            ->findBy(
            [],
            ['createdAt' => 'DESC'],
            8,
            0
        );

        /* Get the 8 next tricks */
        $count = $doctrine
            ->getRepository(Trick::class)
            ->findBy(
                [],
                ['createdAt' => 'DESC'],
                8,
                8
            );

        /* Return response with 'remain_tricks' as a boolean type */
        return $this->render('@client/pages/index.html.twig', [
            'tricks' => $tricks,
            'remain_tricks' => sizeof($count)>0
        ]);
    }




}
