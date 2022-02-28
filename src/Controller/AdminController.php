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
    public function showAdmin()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('@client/pages/admin.html.twig', []);
    }


}
