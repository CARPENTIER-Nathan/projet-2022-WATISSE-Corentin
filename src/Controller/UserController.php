<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigStringColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user-list', name: 'user-list')]
    public function showAction(Request $request, DataTableFactory $dataTableFactory)
    {
        $table = $dataTableFactory->create()
            ->add('Email', TextColumn::class, ['field' => 'user.email', 'label' => "Email"])
            ->add('Pseudo', TextColumn::class, ['field' => 'user.Pseudo', 'label' => "Pseudo"])
            ->add('Nom', TextColumn::class, ['field' => 'user.Nom', 'label' => "Nom"])
            ->add('Prenom', TextColumn::class, ['field' => 'user.Prenom', 'label' => "Prenom"])
            ->add('is_verified', TextColumn::class, ['field' => 'user.isVerified', 'label' => 'Is verified ?'])

            ->add('link', TwigStringColumn::class, ['label' => 'Delete', 'template' => "<a href='/delete_user/{{ row.id }}'> <i class='bx bx-message-alt-x'></i> </a>"])


            ->createAdapter(ORMAdapter::class, [
                'entity' => \App\Entity\User::class,
            ])
            ->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('user-list.html.twig', ['datatableUserList' => $table]);
    }


    #[Route('/delete_user/{id}', name: 'delete_user')]
    function deleteTheme($id, EntityManagerInterface $entityManager, ManagerRegistry $doctrine){

        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(User::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('user-list');

    }
}