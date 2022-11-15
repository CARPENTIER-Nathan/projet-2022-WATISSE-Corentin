<?php

namespace App\Controller;

use App\Entity\Themes;
use App\Form\NewThemeFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigStringColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThemeController extends AbstractController
{
    #[Route('/new_theme', name: 'new_theme')]
    public function register(Request $request,  EntityManagerInterface $entityManager, DataTableFactory $dataTableFactory): Response
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


        $table = $dataTableFactory->create()
            ->add('id', TextColumn::class, ['field' => 'themes.id', 'label' => "Theme's ID"])
            ->add('nom', TextColumn::class, ['field' => 'themes.Nom', 'label' => "Theme's name"])
            ->add('link', TwigStringColumn::class, ['label' => 'Delete', 'template' => "<a href='/delete_theme/{{ row.id }}'> <i class='bx bx-message-alt-x'></i> </a>"])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Themes::class,
            ])
            ->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }


        return $this->render('forms/newTheme.html.twig', [
            'NewThemeForm' => $form->createView(),
            'datatable' => $table,
        ]);
    }

    #[Route('/delete_theme/{id}', name: 'delete_theme')]
    function deleteTheme($id, EntityManagerInterface $entityManager, ManagerRegistry $doctrine){

        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Themes::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No theme found for id '.$id
            );
        }

        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('new_theme');

    }
}