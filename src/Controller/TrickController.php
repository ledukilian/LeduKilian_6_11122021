<?php
namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Entity\User;
use App\Form\CommentFormType;
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
     * @Route("/trick/{slug}", name="show_trick")
     */
    public function showTrick(Trick $trick, ManagerRegistry $doctrine, Request $request)
    {
        $comments = $doctrine
            ->getRepository(Comment::class)
            ->findBy(
                [
                    'trick' => $trick->getId()
                ],
                [
                    'createdAt' => 'DESC'
                ],
                5
            );

        $count = $doctrine
            ->getRepository(Comment::class)
            ->count($trick->getId());

        $form = $this->createForm(CommentFormType::class);

        $this->handleCommentSubmit($form, $request, $doctrine, [
            'trick' => $trick
        ]);

        return $this->render('@client/pages/trick.html.twig', [
            'trick' => $trick,
            'comments' => $comments,
            'remain_comments' => ($count>5),
            'commentForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/tricks", name="show_tricks")
     */
    public function showTricks(ManagerRegistry $doctrine)
    {
        $tricks = $doctrine
            ->getRepository(Trick::class)
            ->findBy(
                [],
                ['createdAt' => 'DESC'],
                9,
                0
            );
        return $this->render('@client/pages/tricks.html.twig', [
            'tricks' => $tricks,
            'remain_tricks' => true
        ]);
    }

    public function handleCommentSubmit($form, $request, ManagerRegistry $doctrine, Array $data)
    {
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $entityManager = $doctrine->getManager();

            // $request->getUser()

            $comment->setStatus(true);
            $comment->setTrick($data['trick']);
            dd($comment);

            //$entityManager->persist($comment);
            //$entityManager->flush();


            // return $this->redirectToRoute('task_success');
        }
    }




}
