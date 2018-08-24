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
		return $this->render('blog/index.html.twig', [
			'pageTitle' => 'Mijn Blogr_\'s',
			'posts' => $this->getUser()->getPosts(),
		]);
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

			return $this->redirect('/read/'.$newPost->getId());
		}

		return $this->render('blog/create.html.twig', [
			'blogForm' => $blogForm->createView(),
		]);
	}

	/**
	 * @Route("/read/{id}", name="read")
	 */
	public function read(int $id)
	{
		$thePost = $this->getDoctrine()->getManager()->getRepository(Post::class)->find($id);
		if ($thePost) {
			return $this->render('blog/read.html.twig', [
				'pageTitle' => $thePost->getTitle(),
				'post' => $thePost,
			]);
		}
		$this->addFlash(
			'danger',
			'Sorry, that blog was not found. :('
		);
		return $this->redirect('/myblogs');
	}
}
