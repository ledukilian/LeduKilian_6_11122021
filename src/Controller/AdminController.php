<?php
namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
                ['createdAt' => 'DESC']
            );

        return $this->render('@client/pages/admin.html.twig', [
            'tricks' => $tricks
        ]);
    }

    /**
     * @Route("/admin/commentaire/{comment_id}/changer-statut/", name="change_commentStatus")
     */
    public function changeCommentStatus(ManagerRegistry $doctrine, int $comment_id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $repository = $doctrine->getRepository(Comment::class);
        $repository->toggleCommentStatus($comment_id);

        $this->addFlash('success', 'Le statut du commentaire a bien été mis à jour !');

        return $this->redirectToRoute('show_admin');
    }


}
