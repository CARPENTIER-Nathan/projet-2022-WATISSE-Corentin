<?php

namespace App\Controller;

use App\Entity\Themes;
use App\Form\NewThemeFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ThemeController extends AbstractController
{
    #[Route('/new_theme', name: 'new_theme')]
    public function register(Request $request,  EntityManagerInterface $entityManager, ManagerRegistry $doctrine, UserInterface $user): Response
    {
        $theme = new Themes();

        $form = $this->createForm(NewThemeFormType::class, $theme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // nouvelles datas
            $theme->setNom($form->get('nom')->getData());

            $entityManager->persist($theme);
            $entityManager->flush();
        }
        return $this->render('forms/newTheme.html.twig', [
            'NewThemeForm' => $form->createView(),
        ]);
    }
}