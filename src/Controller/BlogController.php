<?php

namespace App\Controller;

use App\Form\BlogType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;

class BlogController extends Controller
{
	/**
	 * @Route("/myblogs", name="myblogs")
	 */
	public function index()
	{
		foreach($this->getUser()->getPosts() as $post){
			dump($post);
		};
		die;
	}

	/**
	 * @Route("/blog", name="blog")
	 */
	public function create(Request $request)
	{
		$entityManager = $this->getDoctrine()->getManager();
		$blogForm = $this->createForm(BlogType::class);
		$blogForm->handleRequest($request);

		if ($blogForm->isSubmitted() && $blogForm->isValid()) {
			$newPost = $blogForm->getData();
			$newPost->setUser($this->getUser());
			$newPost->setVotes(1);

			$entityManager->persist($newPost);
			$entityManager->flush();

			$this->addFlash(
				'success',
				'Your blog has been published! :D'
			);
		}

		return $this->render('blog/index.html.twig', [
			'blogForm' => $blogForm->createView(),
		]);
	}
}
