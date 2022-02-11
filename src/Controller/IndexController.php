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
        $repository = $doctrine->getRepository(Trick::class);
        $tricks = $repository->findBy(
            [],
            ['created_at' => 'DESC'],
            8,
            0
        );
        return $this->render('@client/pages/index.html.twig', [
            'tricks' => $tricks
        ]);
    }
    /**
     * @Route("/trick", name="show_trick")
     */
    public function showTrick()
    {
        return $this->render('@client/pages/trick.html.twig', []);
    }
    /**
     * @Route("/admin", name="show_admin")
     */
    public function showAdmin()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('@client/pages/admin.html.twig', []);
    }
}
