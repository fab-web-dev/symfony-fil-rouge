<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    #[Route('/post', name: 'post')]
    public function home(PostRepository $postRepository): Response
    {
        // $posts = $postRepository->findAll();
        $posts = $postRepository->findLastPosts();
        // dd($posts);
        $oldPosts = $postRepository->findOldPosts();
        // dd($posts);




        return $this->render('post/home.html.twig', [
            'posts' => $posts,
            'oldPosts' => $oldPosts,
        ]);
    }

    #[Route('/lastPost', name: 'lastPost')]
    public function lastPost(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findLastPosts(1);




        return $this->render('post/lastPost.html.twig', [
            'post' => $posts[0],
        ]);
    }

    #[Route('/post/{slug}', name: 'post_view')]

    public function post(Post $post, Request $request, ManagerRegistry $doctrine): Response
    {
        // dd($post->getComments());

        // Traitement du formulaire pour ajouter un commentaire
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // Associer le user connecté
            $comment->setUser($this->getUser());

            // Associer le post concerné
            $comment->setPost($post);

            // Persister le commentaire
            $em = $doctrine->getManager();
            $em->persist($comment);
            $em->flush();

            // Rediriger vers la même page, grâce au slug
            return $this->redirectToRoute('post_view', array('slug' => $post->getSlug()));
        }
        return $this->render('post/view.html.twig', [
            // Passer l'article à la vue
            'post' => $post,

            // Passer le formulaire à la vue
            'form' => $form->createView()
        ]);
    }
    #[Route('/post/add', name: 'post_add')]
    public function addPost(Request $request, ManagerRegistry $doctrine): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post->setUser($this->getUser());
            $post->setActive(false);
            // $em = $this->getDoctrine()->getManager();
            $em = $doctrine->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('post');
        }

        return $this->render('post/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
