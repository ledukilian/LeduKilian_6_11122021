<?php
namespace App\Controller;

use App\Entity\Trick;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function showTrick(SerializerInterface $serializer, ManagerRegistry $doctrine, String $slug)
    {
        $trick = $doctrine->getRepository(Trick::class)->findOneBy(['slug' => $slug]);

        if (!$trick) {
            throw $this->createNotFoundException(
                'Aucun trick pour le slug '.$slug
            );
        }

        $contributions = [];
        foreach($trick->getContributors() as $contributor) {
            $contributions[] = [
                'name' => $contributor->getUser()->getUsername(),
                'date' => date_format($contributor->getCreatedAt(), 'd/m/Y à H:i')
            ];
        }

        $comments = [];
        foreach($trick->getComments() as $comment) {
            if ($comment->getStatus()) {
                $comments[] = [
                    'author' => $comment->getUser()->getUsername(),
                    'content' => $comment->getContent(),
                    'date' => date_format($comment->getCreatedAt(), 'd/m/Y à H:i')
                ];
            }
        }
        return $this->render('@client/pages/trick.html.twig', [
            'trick' => [
                'id' => $trick->getId(),
                'name' => $trick->getName(),
                'description' => $trick->getDescription(),
                'slug' => $trick->getSlug(),
                'category' => $trick->getCategory()->getName(),
                'author' => $trick->getUser()->getUsername(),
                'date' => date_format($trick->getCreatedAt(), 'd/m/Y à H:i'),
                'contributors' => $contributions,
                'comments' => $comments
            ],
            'remain_comments' => false
        ]);
    }

    /**
     * @Route("/tricks", name="show_tricks")
     */
    public function showTricks()
    {
        return $this->render('@client/pages/trick.html.twig', []);
    }






}
