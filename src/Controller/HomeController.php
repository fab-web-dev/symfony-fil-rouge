<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\Length;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findLastPosts(1);
        $postsPopular = $postRepository->findAll();
            // Je déclare un tableau vide 
        $sort = array();
        foreach ($postsPopular as $key => $row) {
            // Assigne le nombre de commentaires dans le tableau $sort
          $sort[$key]  = count($row->getComments());
        }
            // Trie par ordre décroissant la combinaison des deux tableaux
        array_multisort($sort, SORT_DESC, $postsPopular);
           // Récupère les deux derniers éléments du tableau grace au slice qui coupe le tableau
        $postsPopular = array_slice($postsPopular, 0, count($postsPopular) - 1 );
        // dd($postsPopular);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'post' => $posts[0],
            'postsPopular' => $postsPopular
        ]);
    }
}
