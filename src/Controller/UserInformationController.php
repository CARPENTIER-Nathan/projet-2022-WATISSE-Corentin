<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ModifyForm;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class UserInformationController extends AbstractController
{
    #[Route('/user_informations', name: 'user_informations')]
    public function register(Request $request,  EntityManagerInterface $entityManager, ManagerRegistry $doctrine, UserInterface $user): Response
    {
        $user = $doctrine->getRepository(User::class)->find($user->getId());


        $form = $this->createForm(ModifyForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // nouvelles datas
            $user->setNom($form->get('nom')->getData());
            $user->setPrenom($form->get('prenom')->getData());
            $user->setAge($form->get('age')->getData());
            $user->setTelephone($form->get('telephone')->getData());
            $user->setVille($form->get('ville')->getData());

            $entityManager->persist($user);
            $entityManager->flush();
        }
        return $this->render('registration/modify.html.twig', [
            'modifyForm' => $form->createView(),
        ]);
    }
}