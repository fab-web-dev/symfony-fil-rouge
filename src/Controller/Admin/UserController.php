<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/user', name: 'admin_user_')]
class UserController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('admin/user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/add', name: 'add')]
    public function addUser(Request $request, ManagerRegistry $doctrine): Response
    {
        $user = new user();

        $form = $this->createForm(UserType::class, $user);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Utilisateur ajouté !');
            return $this->redirectToRoute('admin_user_index');
        }
        
        return $this->render('admin/user/add.html.twig', [
            'form' => $form->createView(),
            'title' => 'Ajout d\'un utilisateur',
        ]);    
    }

    #[Route('/update/{id}', name: 'update')]
    public function updateUser(User $user, Request $request, ManagerRegistry $doctrine): Response
    {
        // $category = new Category();

        $form = $this->createForm(UserType::class, $user);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Utilisateur modifié !');
            return $this->redirectToRoute('admin_user_index');
        }
        
        return $this->render('admin/user/add.html.twig', [
            'form' => $form->createView(),
            'title' => 'Modification d\'un utilisateur',
        ]);    
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(User $user, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $em->remove($user);
        $em->flush();
        $this->addFlash('success', 'Utilisateur supprimé !');
        return $this->redirectToRoute('admin_user_index');
    }

}