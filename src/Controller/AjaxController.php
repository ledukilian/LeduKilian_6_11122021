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
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class AjaxController extends AbstractController
{
    /**
     * @Route("/ajax/{page}/{entity}/{limit}/{offset}", name="_loadMore_ajax")
     */
    public function loadMore(ManagerRegistry $doctrine, Request $request, String $page, String $entity, int $limit = 8, int $offset = 8): JsonResponse
    {
        if ($entity=="trick") {
            $elements = $doctrine
                ->getRepository(Trick::class)
                ->findBy(
                    [],
                    ['createdAt' => 'DESC'],
                    $limit,
                    $offset
                );
            return $this->json([
                'success' => true,
                'data'    => $elements,
                'remain' => $this->CheckTricksRemain($doctrine, $limit+$offset)
            ], 200, [], ['groups' => ['trick', 'user']]);
        }
        if ($entity=="comment") {
            $elements = $doctrine
                ->getRepository(Comment::class)
                ->findNextComments(
                    $page,
                    $limit,
                    $offset
                );
            return $this->json([
                'success' => true,
                'data'    => $elements,
                'remain' =>  $this->CheckCommentsRemain($doctrine, $page, $limit, $offset)
            ], 200, [], ['groups' => ['trick', 'user', 'comment', 'datetime']]);
        }


    }

    private function CheckCommentsRemain(ManagerRegistry $doctrine, String $slug, int $limit, int $offset): bool
    {
        $remains = $doctrine
            ->getRepository(Comment::class)
            ->findNextComments(
                $slug,
                $limit,
                $offset+$limit
            );
        return !empty($remains);
    }


    private function CheckTricksRemain(ManagerRegistry $doctrine, int $asked): bool
    {
        return count($doctrine->getRepository(Trick::class)->findAll()) >= $asked;
    }


}
