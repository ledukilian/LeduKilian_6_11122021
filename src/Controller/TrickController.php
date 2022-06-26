<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Contributor;
use App\Entity\Media;
use App\Entity\Trick;
use App\Form\CommentFormType;
use App\Form\TrickType;
use App\Services\FileUploader;
use App\Services\Slug;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class TrickController extends AbstractController
{
    /**
     * @Route("/trick/editer/{slug}/", name="edit_trick")
     */
    public function editTrick(Trick $trick, ManagerRegistry $doctrine, Request $request, FileUploader $fileUploader)
    {
        /* Deny access unless authentified */
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $editTrickForm = $this->createForm(TrickType::class, $trick);
        $editTrickForm->handleRequest($request);

        /* If we have a form validated */
        if ($editTrickForm->isSubmitted() && $editTrickForm->isValid()) {
            $entityManager = $doctrine->getManager();
            $trick = $editTrickForm->getData();

            /* Bind the current authentified user */
            $trick->setUser($this->getUser());
            $trickRepository = $doctrine->getRepository(Trick::class);
            $medias = $editTrickForm->get('medias');

            /* Foreach media inside the form submitted */
            foreach ($medias as $media) {
                $newMedia = $media->getData();

                /* If we have an image type */
                if ($newMedia->getType()==Media::TYPE_IMAGE) {
                    if ($media->get('image')->getData()!==null) {

                        /* If we don't have any cover but we have medias */
                        if (sizeof($trick->getMedias())>0 && is_null($trick->getCoverImg())) {
                            $trick->setCoverImg($newMedia);
                        }

                        /* Upload the image and bind image link */
                        $fileName = $fileUploader->upload($media->get('image')->getData());
                        $newMedia->setLink($fileName);

                    }
                }
                /* If we have a video type */
                if ($newMedia->getType()==Media::TYPE_VIDEO) {
                    $newMedia->setAlt('Intégration vidéo externe');
                }
                $media->getData()->setTrick($trick);
                $trick->addMedia($media->getData());
            }

            /* Add a new contributor to the trick (current user) */
            $contributor = new Contributor();
            $contributor->setTrick($trick);
            $contributor->setUser($this->getUser());
            $trick->addContributor($contributor);

            /* Persist the entity into the database */
            $entityManager->persist($trick);
            $entityManager->flush();

            /* Add message and redirect to index */
            $this->addFlash('success', 'Le trick '.$trick->getName().' a bien été modifié !');
            return $this->redirectToRoute('show_index');
        }

        /* Render template, with form */
        return $this->renderForm('@client/pages/editTrick.html.twig', [
            'addTrickForm' => $editTrickForm
        ]);
    }

    /**
     * @Route("/trick/ajouter/", name="add_trick")
     */
    public function createTrick(Slug $slug, ManagerRegistry $doctrine, Request $request, FileUploader $fileUploader)
    {
        /* Deny access unless authentified */
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $trick = new Trick();
        $trickForm = $this->createForm(TrickType::class, $trick);
        $trickForm->handleRequest($request);

         /* If we have a form validated */
        if ($trickForm->isSubmitted() && $trickForm->isValid()) {
                $entityManager = $doctrine->getManager();
                $trick = $trickForm->getData();

                /* Bind the current authentified user */
                $trick->setUser($this->getUser());
                $trickRepository = $doctrine->getRepository(Trick::class);

                /* Generate a slug from trick name, adapting to existing ones */
                $slug = $slug->generate($trick->getName());
                $trick->setSlug($trickRepository->adaptToExistingSlug($slug));

                $medias = $trickForm->get('medias');
                $cover = false;

                /* Foreach media inside the form submitted */
                foreach ($medias as $media) {
                    $newMedia = $media->getData();
                    /* If we have an image type */
                    if ($newMedia->getType()==Media::TYPE_IMAGE) {

                        /* Upload the image and bind image link */
                        $fileName = $fileUploader->upload($media->get('image')->getData());
                        $newMedia->setLink($fileName);

                        /* if we don't have any cover, we add one */
                        if(!$cover){
                            $trick->setCoverImg($newMedia);
                            $cover = true;
                        }

                    }
                    /* If we have a video type */
                    if ($newMedia->getType()==Media::TYPE_VIDEO) {
                        $newMedia->setAlt('Intégration vidéo externe');
                    }

                    /* Add the trick to the media, for the cascade persist to work properly*/
                    $media->getData()->setTrick($trick);
                    $trick->addMedia($media->getData());
                }

                /* Persist the entity into the database */
                $entityManager->persist($trick);
                $entityManager->flush();

                $this->addFlash('success', 'Le trick '.$trick->getName().' a bien été créé !');
                return $this->redirectToRoute('show_index');
        }

        /* Render template, with form */
        return $this->renderForm('@client/pages/addTrick.html.twig', [
            'addTrickForm' => $trickForm
        ]);
    }


    /**
     * @Route("/trick/{slug}", name="show_trick")
     */
    public function showTrick(Trick $trick, ManagerRegistry $doctrine, Request $request)
    {
        /* Create the comment form */
        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);

        $form->handleRequest($request);

        /* If we have a form validated (comment form) */
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setStatus(false);
            $comment->setUser($this->getUser());
            $comment->setTrick($trick);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            /* Comment has been added, success message and redirection to the trick */
            $this->addFlash('success', 'Votre commentaire a été pris en compte, il sera traité et mis en ligne dans les plus brefs délais');
            return $this->redirectToRoute('show_trick', ['slug' => $trick->getSlug()]);
        }

        /* Search for the 10 last published comments */
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

        /* Count if there are any comments remaining to display the 'show more' button */
        $count = $doctrine
            ->getRepository(Comment::class)
            ->count($trick->getId());

        /* Render template, with the comment form, trick comments, and the 'remain_comments' boolean */
        return $this->render('@client/pages/trick.html.twig', [
            'trick' => $trick,
            'comments' => $comments,
            'remain_comments' => ($count > 10),
            'commentForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/trick/couverture/{slug}/{image}/", name="setcover_trick")
     */
    public function changeCover(Trick $trick, Media $image, ManagerRegistry $doctrine)
    {
            /* Deny access unless authentified */
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

            /* Add a new contributor for changing the trick cover */
            $contributor = new Contributor();
            $contributor->setTrick($trick);
            $contributor->setUser($this->getUser());
            $trick->addContributor($contributor);

            /* Set the new cover image */
            $trick->setCoverImg($image);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($trick);
            $entityManager->flush();


            /* Add flash message and redirect to the trick */
            $this->addFlash('success', 'L\'image de couverture a bien été mise à jour');
            return $this->redirectToRoute('show_trick', ['slug' => $trick->getSlug()]);
    }

    /**
     * @Route("/trick/supprimer/{slug}/", name="delete_trick")
     */
    public function deleteTrick(Trick $trick, ManagerRegistry $doctrine) {
        /* Check permission for this route */
        if ($this->isGranted('delete', $trick)) {
            $entityManager = $doctrine->getManager();

            /* Remove the trick */
            $entityManager->remove($trick);
            $entityManager->flush();

            /* Add flash message and redirect to index */
            $this->addFlash('success', 'Le trick '.$trick->getName().' a bien été supprimé');
            return $this->redirectToRoute('show_index');
        }
    }

}
