<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Entity\User;
use App\Form\CommentFormType;
use App\Form\TrickMediaType;
use App\Form\TrickType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;


class TrickController extends AbstractController
{
    /**
     * @Route("/trick/ajouter/", name="add_trick")
     */
    public function createTrick() {
        $trick = new Trick();

        $trickForm = $this->createForm(TrickType::class, $trick);

        return $this->renderForm('@client/pages/addTrick.html.twig', [
            'addTrickForm' => $trickForm
        ]);
    }


    /**
     * @Route("/trick/{slug}", name="show_trick")
     */
    public function showTrick(Trick $trick, ManagerRegistry $doctrine, Request $request)
    {
        $comment = new Comment();

        $form = $this->createForm(CommentFormType::class, $comment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setStatus(false);
            $comment->setUser($this->getUser());
            $comment->setTrick($trick);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
            $this->addFlash('success', 'Votre commentaire a été pris en compte, il sera traité et mis en ligne dans les plus brefs délais');
            return $this->redirectToRoute('show_trick', ['slug' => $trick->getSlug()]);
        }

        $comments = $doctrine
            ->getRepository(Comment::class)
            ->findBy(
                [
                    'trick' => $trick->getId(),
                    'status' => true
                ],
                [
                    'createdAt' => 'DESC'
                ],
                10
            );

        $count = $doctrine
            ->getRepository(Comment::class)
            ->count($trick->getId());

        return $this->render('@client/pages/trick.html.twig', [
            'trick' => $trick,
            'comments' => $comments,
            'remain_comments' => ($count > 10),
            'commentForm' => $form->createView()
        ]);
    }



}
