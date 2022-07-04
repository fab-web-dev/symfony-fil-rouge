<?php

namespace App\Controller;

// les uses servent à indiquer les chemins dont j'ai besoin ( repository, form, ect...)
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PostRepository $postRepository): Response
    {
        // va chercher dans $postRepository le resultat de la methode findLastPosts et l'assigne à $posts []
        $posts = $postRepository->findLastPosts(1);

        // va chercher dans $postRepository le resultat de la methode findAll et l'assigne à $postsPopular []
        $postsPopular = $postRepository->findAll();

        // Je déclare un tableau vide 
        $sort = array();

        // Je fais une boucle foreach pour passer en défilé le tableau en assignant la clé de l'élément courant (sa valeur dans le tableau) à la variable $key.
        // $key étant l'id et $row étant l'article
        foreach ($postsPopular as $key => $row) {

            // Assigne le nombre de commentaires dans le tableau $sort , pour chaque commentaire compte 
          $sort[$key]  = count($row->getComments());
        }
            // Trie par ordre décroissant la combinaison des deux tableaux
        array_multisort($sort, SORT_DESC, $postsPopular);
           // Récupère les trois derniers éléments du tableau grace au slice qui coupe le tableau
        $postsPopular = array_slice($postsPopular, 0, 3 );

        return $this->render('home/index.html.twig', [
            'post' => $posts[0],
            'postsPopular' => $postsPopular
        ]);
    }
}
