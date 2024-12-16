<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PostsRepository;
use App\Entity\Posts;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/post')]
class PostController extends AbstractController
{
    private $postRepo;

    public function __construct(PostsRepository $postRepo)
    {
        $this->postRepo = $postRepo;        
    }

    #[Route('/', name: 'app_posts')]
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $posts = $this->postRepo->findPublished($page, $paginator);
        return $this->render('post/index.html.twig', [
            'allMyPosts' => $posts,
        ]);
    }

    #[Route('/details/{slug}', name: 'app_details')]
    public function show(Posts $post): Response
    {
        return $this->render('post/details.html.twig', [
            'onePost' => $post,
        ]);
    }

    #[Route('/category/{id}', name: 'category_post')]
    public function categPost(int $id): Response
    {
        $posts = $this->postRepo->findBy(['category_id' => $id]);
        return $this->render('post/categPost.html.twig', [
            'posts' => $posts,
        ]);
    }

}
