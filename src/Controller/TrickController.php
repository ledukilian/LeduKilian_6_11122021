<?php
namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
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
    public function showTrick(Trick $trick, ManagerRegistry $doctrine)
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

        return $this->render('@client/pages/trick.html.twig', [
            'trick' => $trick,
            'comments' => $comments,
            'remain_comments' => ($count>5)
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

    public function new(Request $request): Response
    {
        dd('test');
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        if ($request->isMethod('POST')) {
            $form->submit($request->request->get($form->getName()));

            if ($form->isSubmitted() && $form->isValid()) {
                // perform some action...

                return $this->redirectToRoute('task_success');
            }
        }

        return $this->renderForm('task/new.html.twig', [
            'form' => $form,
        ]);
    }




}
