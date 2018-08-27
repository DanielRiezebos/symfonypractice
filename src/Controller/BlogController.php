<?php

namespace App\Controller;

use App\Form\BlogType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;

class BlogController extends Controller
{

	private $entityManager;

	public function __construct()
	{
		#$this->entityManager = $this->getDoctrine()->getManager();
	}

	/**
	 * @Route("/myblogs", name="listBlog")
	 */
	public function index()
	{
		return $this->render('blog/index.html.twig', [
			'pageTitle' => 'Mijn Blogr_\'s',
			'posts' => $this->getUser()->getPosts(),
		]);
	}

	/**
	 * @Route("/blog", name="createBlog")
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
			$newPost->setTimestamp(time());

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
	 * @Route("/read/{id}", name="readBlog")
	 */
	public function read(int $id)
	{
		$entityManager = $this->getDoctrine()->getManager();
		$thePost = $entityManager->getRepository(Post::class)->find($id);
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

	/**
	 * @Route("/blog/delete/{id}", name="deleteBlog")
	 */
	public function delete(int $id)
	{
		$entityManager = $this->getDoctrine()->getManager();
		$postToDelete = $entityManager->getRepository(Post::class)->find($id);

		if (!is_null($postToDelete)) {
			$entityManager->remove($postToDelete);
			$entityManager->flush();
			$this->addFlash(
				'danger',
				'Blog entry has been deleted. RIP'
			);
		}

		return $this->redirect('/myblogs');
	}
}
