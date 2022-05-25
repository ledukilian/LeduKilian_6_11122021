<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Media;
use App\Entity\Trick;
use App\Entity\User;
use App\Form\CommentFormType;
use App\Form\TrickType;
use App\Services\FileUploader;
use App\Services\Slug;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;


class TrickController extends AbstractController
{

    /**
     * @Route("/trick/editer/{slug}/", name="edit_trick")
     */
    public function editTrick(Trick $trick, ManagerRegistry $doctrine, Request $request, FileUploader $fileUploader) {

        $trickForm = $this->createForm(TrickType::class, $trick);

        $trickForm->handleRequest($request);
        if ($trickForm->isSubmitted() && $trickForm->isValid()) {
            $entityManager = $doctrine->getManager();
            $trick = $trickForm->getData();
            $trick->setUser($this->getUser());
            $trickRepository = $doctrine->getRepository(Trick::class);
            $slug = $slug->generate($trick->getName());
            $trick->setSlug($trickRepository->adaptToExistingSlug($slug));
            $medias = $trickForm->get('media');
            $cover = false;
            foreach ($medias as $media) {

                $newMedia = $media->getData();
                if ($newMedia->getType()==Media::TYPE_IMAGE) {
                    $fileName = $fileUploader->upload($media->get('image')->getData());
                    $newMedia->setLink($fileName);
                    if(!$cover){
                        $trick->setCoverImg($newMedia);
                        $cover = true;
                    }
                }
                if ($newMedia->getType()==Media::TYPE_VIDEO) {
                    $newMedia->setAlt('Intégration vidéo externe');
                    $newMedia->setLink($media->get('embed')->getData());
                }
                $media->getData()->setTrick($trick);
                $trick->addMedia($media->getData());
            }
            $entityManager->persist($trick);
            $entityManager->flush();

            $this->addFlash('success', 'Le trick '.$trick->getName().' a bien été modifié !');
            return $this->redirectToRoute('show_index');
        }

        return $this->renderForm('@client/pages/editTrick.html.twig', [
            'addTrickForm' => $trickForm
        ]);
    }

    /**
     * @Route("/trick/ajouter/", name="add_trick")
     */
    public function createTrick(Slug $slug, ManagerRegistry $doctrine, Request $request, FileUploader $fileUploader) {
        $trick = new Trick();

        $trickForm = $this->createForm(TrickType::class, $trick);

        $trickForm->handleRequest($request);
        if ($trickForm->isSubmitted() && $trickForm->isValid()) {
            $entityManager = $doctrine->getManager();
            $trick = $trickForm->getData();
            $trick->setUser($this->getUser());
            $trickRepository = $doctrine->getRepository(Trick::class);

            $slug = $slug->generate($trick->getName());
            $trick->setSlug($trickRepository->adaptToExistingSlug($slug));
            $medias = $trickForm->get('media');
            $cover = false;

            foreach ($medias as $media) {
                $newMedia = $media->getData();
                if ($newMedia->getType()==Media::TYPE_IMAGE) {
                    $fileName = $fileUploader->upload($media->get('image')->getData());
                    $newMedia->setLink($fileName);
                    if(!$cover){
                        $trick->setCoverImg($newMedia);
                        $cover = true;
                    }
                }
                if ($newMedia->getType()==Media::TYPE_VIDEO) {
                    $newMedia->setAlt('Intégration vidéo externe');
                    $newMedia->setLink($media->get('embed')->getData());
                }
                $media->getData()->setTrick($trick);
                $trick->addMedia($media->getData());
            }

            $entityManager->persist($trick);
            $entityManager->flush();

            $this->addFlash('success', 'Le trick '.$trick->getName().' a bien été créé !');
            return $this->redirectToRoute('show_index');
        }

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
