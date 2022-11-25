<?php

namespace App\Controller;

use App\Entity\Discussions;
use App\Entity\Themes;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Omines\DataTablesBundle\Adapter\Doctrine\FetchJoinORMAdapter;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigStringColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Annotation\Route;

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
//                        ->where('e.id = c.Theme');

                }
            ])

//            ->add('theme_name', TextColumn::class, ['field' => 'themes.Nom', 'label' => "Name"])
            ->add('theme_name', TwigStringColumn::class, ['label' => 'themes.Nom', 'template' => "<a href='/forum/theme/{{ row.Nom }}'> {{ row.Nom }} </a>"])

            //            ->add('last_comment', TextColumn::class, ['field' => "Discussions.date_modification", 'label' => "Last comment"])




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
                        ->add('Id', TextColumn::class, ['field' => 'discussions.id', 'label' => "Id"])
                        ->add('Contenu', TextColumn::class, ['field' => 'discussions.Contenu', 'label' => "Contenu"])
                        ->add('Creation date', TextColumn::class, ['field' => 'discussions.DateCreation', 'label' => "Creation date"])
                        ->add('Last modification date', TextColumn::class, ['field' => 'discussions.DateModification', 'label' => "Creation date"])
                        ->add('Creator', TextColumn::class, ['field' => 'discussions.Createur', 'label' => 'Creator'])



                        ->createAdapter(ORMAdapter::class, [
                            'entity' => \App\Entity\Discussions::class,
                            'query' => function(QueryBuilder $builder) use ($themeID) {
                                $builder
                                    ->select('e')
                                    ->from(Discussions::class, 'e')
                                    ->where('e.Theme = :theme')
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
}