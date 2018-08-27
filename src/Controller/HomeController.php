<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
    	$entityManager = $this->getDoctrine()->getManager();
    	$newestPosts = $entityManager->getRepository(Post::class)->findBy([], ['timestamp' => 'DESC'], 5);
        return $this->render('home/index.html.twig', ['newestPosts' => $newestPosts, 'pageTitle' => 'Nieuwste blogs:']);
    }
}