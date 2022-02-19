<?php
namespace App\Controller;

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
     * @Route("/ajax/{entity}/{offset}", name="_loadMore_ajax")
     */
    public function loadMore(SerializerInterface $serializer, ManagerRegistry $doctrine, Request $request, String $entity, int $offset = 8)
    {


        $tricks = $doctrine
            ->getRepository(Trick::class)
            ->findNext($offset);

        //$trick = $serializer->serialize($result, 'json', ['groups' => ['trick']]);

        if ($request->isXMLHttpRequest()) {

            try {

                return new JsonResponse([
                    'success' => true,
                    'data'    => [$tricks]
                ]);

            } catch (\Exception $exception) {

                return new JsonResponse([
                    'success' => false,
                    'code'    => $exception->getCode(),
                    'message' => $exception->getMessage(),
                ]);

            }

        }

    }

}
