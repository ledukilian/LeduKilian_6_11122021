<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="show_index")
     */
    public function showIndex()
    {
        return $this->render('@client/pages/index.html.twig', []);
    }
    /**
     * @Route("/", name="show_trick")
     */
    public function showTrick()
    {
        return $this->render('@client/pages/trick.html.twig', []);
    }
}