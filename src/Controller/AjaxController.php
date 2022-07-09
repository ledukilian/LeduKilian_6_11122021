<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Security\Core\Security;

class AjaxController extends AbstractController
{
    /**
     * @Route("/change-comment-status/{$comment_id}/", name="_change_commentStatus_ajax")
     * @param ManagerRegistry $doctrine
     * @param int             $comment_id
     * @return JsonResponse
     * @throws Exception
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
     * @param ManagerRegistry $doctrine
     * @param int             $id
     * @param int             $limit
     * @param int             $offset
     * @return JsonResponse
     * @throws NoResultException
     * @throws NonUniqueResultException
     * @throws ExceptionInterface
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
            AbstractNormalizer::ATTRIBUTES => ['id', 'content', 'status', 'createdAt', 'user' => ['username', 'image']]
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
     * @param ManagerRegistry $doctrine
     * @param Security        $security
     * @param int             $limit
     * @param int             $offset
     * @return JsonResponse
     * @throws ExceptionInterface
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function loadMoreTricks(ManagerRegistry $doctrine, Security $security, int $limit = 8, int $offset = 8): JsonResponse
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

        $tricks = [];
        foreach ($elements as $trick) {
            $tricks[] = [
                'element' => $trick,
                'permissions' => [
                    'canEdit' => $security->isGranted('IS_AUTHENTICATED_FULLY'),
                    'canDelete' => $security->isGranted('delete', $trick)
                ]
            ];
        }

        /* Count all tricks */
        $count = $doctrine
            ->getRepository(Trick::class)
            ->size();

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->normalize($tricks, null, [
            AbstractNormalizer::ATTRIBUTES => ['id', 'name', 'description', 'slug', 'coverImg' => ['type', 'link', 'alt'], 'user' => ['username']]
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

        return new JsonResponse($jsonContent, 200, [], true);
    }

    /**
     * @param ManagerRegistry $doctrine
     * @param int             $asked
     * @return bool
     */
    private function checkTricksRemain(ManagerRegistry $doctrine, int $asked): bool
    {
        /* Return trick count */
        return count($doctrine->getRepository(Trick::class)->findAll()) >= $asked;
    }


    /**
     * @param ManagerRegistry $doctrine
     * @param string          $slug
     * @param int             $limit
     * @param int             $offset
     * @return bool
     */
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
