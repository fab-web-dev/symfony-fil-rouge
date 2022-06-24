<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/contact', name: 'admin_contact_')]
class ContactController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ContactRepository $contactRepository): Response
    {
        $contacts = $contactRepository->findAll();
        return $this->render('admin/contact/index.html.twig', [
            'contacts' => $contacts,
        ]);
    }


    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Contact $contact, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $em->remove($contact);
        $em->flush();
        $this->addFlash('success', 'Commentaire supprimé !');
        return $this->redirectToRoute('admin_contact_index');
    }

    #[Route('/read/{id}', name: 'read')]
    public function read(Contact $contact): Response
    {
        return $this->render('admin/contact/message.html.twig', [
            'contact' => $contact,
        ]);
    }
}