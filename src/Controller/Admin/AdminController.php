<?php

namespace App\Controller\Admin;

use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findLastPosts();
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'posts' => $posts ,
        ]);
    }
}