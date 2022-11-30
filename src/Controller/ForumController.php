<?php

namespace App\Controller;

use App\Entity\Discussions;
use App\Entity\Themes;
use App\Entity\User;
use App\Form\NewDiscussionsType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Omines\DataTablesBundle\Adapter\Doctrine\FetchJoinORMAdapter;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigStringColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ForumController extends AbstractController
{
    #[Route('/forum/theme', name: 'forum_theme')]
    function indexForum(Request $request, DataTableFactory $dataTableFactory) {

        $table = $dataTableFactory->create()

            ->createAdapter(FetchJoinORMAdapter::class, [
                'entity' => Themes::class,
                'query' => function(QueryBuilder $builder) {
                    $builder
                        ->select('e, c')
                        ->from(Themes::class, 'e')
                        ->leftJoin('e.Discussions', 'c');
//                        ->setMaxResults(1)
//                        ->from(Discussions::class)
//                        ->groupBy('Themes.id');
//                        ->where('e.id = c.Theme');

                }
            ])

//            ->add('last comment', TextColumn::class, ['field' => 'themes.Discussions.DateModifications', 'label' => "Last comment"])
            ->add('theme_name', TwigStringColumn::class, ['label' => 'Theme', 'template' => "<a href='/forum/theme/{{ row.Nom }}'> {{ row.Nom }} </a>"])




            ->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('forum_theme.html.twig', ['datatableTheme' => $table]);
    }

    #[Route('/forum/theme/{theme}', name: 'forum_theme_themes')]
    function themePrecise($theme, ManagerRegistry $doctrine, DataTableFactory $dataTableFactory, Request $request) {
        $existeTheme = $doctrine->getRepository(Themes::class)->findAll();
        $themeID = $doctrine->getRepository(Themes::class)->findBy(array('Nom'=>$theme));


                if(  isset($themeID[0] )){

                    $themeID = $themeID[0]->getId();

                    $table = $dataTableFactory->create()
//                        ->add('Id', TextColumn::class, ['field' => 'discussions.id', 'label' => "Id"])
                        ->add('Contenu', TextColumn::class, ['field' => 'discussions.Contenu', 'label' => "Contenu"])
                        ->add('Creation date', TextColumn::class, ['field' => 'discussions.DateCreation', 'label' => "Creation date"])
                        ->add('Last modification date', TextColumn::class, ['field' => 'discussions.DateModification', 'label' => "Modification date"])
                        ->add('Creator', TextColumn::class, ['field' => 'discussions.Use.Email', 'label' => 'Creator'])



                        ->createAdapter(ORMAdapter::class, [
                            'entity' => \App\Entity\Discussions::class,
                            'query' => function(QueryBuilder $builder) use ($themeID) {
                                $builder
                                    ->select('e')
                                    ->from(Discussions::class, 'e')
                                    ->where('e.Theme = :theme')
                                    ->orderBy('e.DateModification ', 'DESC')
                                    ->setParameter('theme', $themeID);

                            }
                        ])
                        ->handleRequest($request);

                    if ($table->isCallback()) {
                        return $table->getResponse();}



                    return $this->render('theme.html.twig', ['theme'=> $theme, 'datatableDiscussions' => $table]);
                } else {
                    return $this->redirectToRoute('forum_theme');
                }

    }

    #[Route('/forum/theme/{theme}/new_discussions', name:'forum_new_discussions_')]
    function newDiscussions($theme, /*Request*/ $request,EntityManagerInterface $entityManager,UserInterface $user) {

        $themes = $entityManager->getRepository(Themes::class)->findBy(array('Nom'=>$theme));
        $users = $entityManager->getRepository(User::class)->findBy(array('id'=>$user->getId()));
        $themes = $themes[0];
        $users = $users[0];

        $discussions = new Discussions();
        $form = $this->createForm(NewDiscussionsType::class, $discussions);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password

            $discussions->setContenu($form->get('Contenu')->getData());
            $discussions->setCreateur($users->getEmail());
            $discussions->setDateCreation(date('j M Y - H:i:s'));
            $discussions->setDateModification(date('j M Y - H:i:s'));
            $discussions->setTheme($themes);
            $discussions->setUser($users);

            $entityManager->persist($discussions);
            $entityManager->flush();


                return $this->render('new_discussions.html.twig', [
                'newDiscussions' => $form->createView(),
            ]);

        }

        return $this->render('new_discussions.html.twig', [
            'newDiscussions' => $form->createView(),
        ]);
    }
}