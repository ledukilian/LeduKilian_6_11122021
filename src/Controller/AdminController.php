<?php
namespace App\Controller;

use App\Entity\Comment;
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
        /* Deny access unless admin */
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        /* Get all last tricks */
        $tricks = $doctrine
            ->getRepository(Trick::class)
            ->findBy(
                [],
                ['createdAt' => 'DESC']
            );

        /* Render the admin panel */
        return $this->render('@client/pages/admin.html.twig', [
            'tricks' => $tricks
        ]);
    }

    /**
     * @Route("/admin/commentaire/{comment_id}/changer-statut/", name="change_commentStatus")
     */
    public function changeCommentStatus(ManagerRegistry $doctrine, int $comment_id)
    {
        /* Deny access unless admin */
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        /* Get repository and change comment status with his id */
        $repository = $doctrine->getRepository(Comment::class);
        $repository->toggleCommentStatus($comment_id);

        /* Add flash message and redirect to admin panel */
        $this->addFlash('success', 'Le statut du commentaire a bien été mis à jour !');
        return $this->redirectToRoute('show_admin');
    }


}
