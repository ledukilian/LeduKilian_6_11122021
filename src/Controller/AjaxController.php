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
        /* Deny access unless Admin */
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        /* Change comment status */
        $repository = $doctrine->getRepository(Comment::class);
        $repository->toggleCommentStatus($comment_id);

        /* Return response with code 200 */
        return $this->json([
            'success' => true,
            'comment' => $comment_id
        ], 200, [], ['groups' => ['trick', 'user', 'comment', 'datetime']]);
    }


    /**
     * @Route("/load-comments/{id}/{limit}/{offset}", name="_loadMore_comments_ajax")
     */
    public function loadMoreComments(ManagerRegistry $doctrine, int $id, int $limit = 10, int $offset = 10): JsonResponse
    {
        /* Get next comments */
        $elements = $doctrine
            ->getRepository(Comment::class)
            ->findNextComments(
                $id,
                $limit,
                $offset
            );

        /* Get next comments (if remaining we get > 0) */
        $count = $doctrine
            ->getRepository(Comment::class)
            ->count($id);

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->normalize($elements, null, [
            AbstractNormalizer::ATTRIBUTES => ['id', 'content', 'status', 'createdAt', 'user' => ['username']]
        ]);

        /* Format JSON content with serializer */
        $jsonContent = $serializer->serialize(
            [
                'success' => true,
                'data' => $jsonContent,
                'remain' => ($count > ($limit + $offset))
            ],
            'json'
        );

        /* Return response with code 200 */
        return new JsonResponse($jsonContent, 200, [], true);
    }


    /**
     * @Route("/load-tricks/{id}/{limit}/{offset}", name="_loadMore_tricks_ajax")
     */
    public function loadMoreTricks(ManagerRegistry $doctrine, int $limit = 8, int $offset = 8): JsonResponse
    {
        /* Get the next tricks with limit and offset */
        $elements = $doctrine
            ->getRepository(Trick::class)
            ->findBy(
                [],
                ['createdAt' => 'DESC'],
                $limit,
                $offset
            );

        /* Count all tricks */
        $count = $doctrine
            ->getRepository(Trick::class)
            ->size();

        /* Return JSON response with elements, and 'remain' boolean */
        return $this->json([
            'success' => true,
            'data' => $elements,
            'remain' => ($count > ($limit + $offset))
        ], 200, [], ['groups' => ['trick', 'user']]);

    }

    private function checkTricksRemain(ManagerRegistry $doctrine, int $asked): bool
    {
        /* Return trick count */
        return count($doctrine->getRepository(Trick::class)->findAll()) >= $asked;
    }


    private function checkCommentsRemain(ManagerRegistry $doctrine, string $slug, int $limit, int $offset): bool
    {
        /* Get next comments */
        $remains = $doctrine
            ->getRepository(Comment::class)
            ->findNextComments(
                $slug,
                $limit,
                $offset + $limit
            );

        /* Return remaining comments, boolean format */
        return !empty($remains);
    }


}
