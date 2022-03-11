<?php
namespace App\Controller;

use App\Entity\Trick;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="show_admin")
     */
    public function showAdmin(ManagerRegistry $doctrine)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $tricks = $doctrine
            ->getRepository(Trick::class)
            ->findBy(
                [],
                ['createdAt' => 'DESC'],
                3,
                0
            );


        return $this->render('@client/pages/admin.html.twig', [
            'tricks' => $tricks
        ]);
    }


}
