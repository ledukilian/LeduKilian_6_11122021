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
    public function showTrick(Trick $trick)
    {
        return $this->render('@client/pages/trick.html.twig', [
            'trick' => $trick,
            'remain_comments' => false
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
        ]);    }






}
