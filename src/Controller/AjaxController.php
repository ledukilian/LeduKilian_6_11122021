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
     * @Route("/ajax/{entity}/{limit}/{offset}", name="_loadMore_ajax")
     */
    public function loadMore(ManagerRegistry $doctrine, Request $request, String $entity, int $limit = 8, int $offset = 8): JsonResponse
    {
        $tricks = $doctrine
            ->getRepository($this->StringToClass($entity))
            ->findBy(
                [],
                ['createdAt' => 'DESC'],
                $limit,
                $offset
            );
        return $this->json([
            'success' => true,
            'data'    => $tricks,
            'remain' => $this->CheckElementsRemain($doctrine, $this->StringToClass($entity), $limit+$offset)
        ], 200, [], ['groups' => ['trick', 'user']]);

    }

    private function CheckElementsRemain(ManagerRegistry $doctrine, String $class, int $asked): bool
    {
        return count($doctrine->getRepository($class)->findAll()) >= $asked;
    }

    private function StringToClass(string $entity): bool|string
    {
        if ($entity=='trick') {
            return Trick::class;
        }
        if ($entity=='comment') {
            return Comment::class;
        }
        return false;
    }

}
