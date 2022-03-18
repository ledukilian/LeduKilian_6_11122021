<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class AjaxController extends AbstractController
{
    /**
     * @Route("/change-comment-status/{$comment_id}/", name="_change_commentStatus_ajax")
     */
    public function changeCommentStatus(ManagerRegistry $doctrine, int $comment_id): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $repository = $doctrine->getRepository(Comment::class);
        $repository->toggleCommentStatus($comment_id);

        return $this->json([
            'success' => true,
            'comment' => $comment_id
        ], 200, [], ['groups' => ['trick', 'user', 'comment', 'datetime']]);
    }


    /**
     * @Route("/load-comments/{id}/{limit}/{offset}", name="_loadMore_comments_ajax")
     */
    public function loadMoreComments(ManagerRegistry $doctrine, int $id, int $limit = 8, int $offset = 8): JsonResponse
    {
        $elements = $doctrine
            ->getRepository(Comment::class)
            ->findNextComments(
                $id,
                $limit,
                $offset
            );

        $count = $doctrine
            ->getRepository(Comment::class)
            ->count($id);

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->normalize($elements, null, [
            AbstractNormalizer::ATTRIBUTES => ['id', 'content', 'status', 'createdAt', 'user' => ['username']]
        ]);

        $jsonContent = $serializer->serialize(
            [
                'success' => true,
                'data' => $jsonContent,
                'remain' => ($count > ($limit + $offset))
            ],
            'json'
        );

        return new JsonResponse($jsonContent, 200, [], true);

    }


    /**
     * @Route("/load-tricks/{id}/{limit}/{offset}", name="_loadMore_tricks_ajax")
     */
    public function loadMoreTricks(ManagerRegistry $doctrine, int $limit = 8, int $offset = 8): JsonResponse
    {
        $elements = $doctrine
            ->getRepository(Trick::class)
            ->findBy(
                [],
                ['createdAt' => 'DESC'],
                $limit,
                $offset
            );
        $count = $doctrine
            ->getRepository(Trick::class)
            ->size();

        return $this->json([
            'success' => true,
            'data' => $elements,
            'remain' => ($count > ($limit + $offset))
        ], 200, [], ['groups' => ['trick', 'user']]);

    }

    private function checkTricksRemain(ManagerRegistry $doctrine, int $asked): bool
    {
        return count($doctrine->getRepository(Trick::class)->findAll()) >= $asked;
    }

    private function checkCommentsRemain(ManagerRegistry $doctrine, string $slug, int $limit, int $offset): bool
    {
        $remains = $doctrine
            ->getRepository(Comment::class)
            ->findNextComments(
                $slug,
                $limit,
                $offset + $limit
            );
        return !empty($remains);
    }


}
