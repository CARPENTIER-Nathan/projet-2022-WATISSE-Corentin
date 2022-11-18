<?php

namespace App\Controller;

use App\Entity\Themes;
use Doctrine\ORM\QueryBuilder;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigStringColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{
    #[Route('/forum/theme', name: 'forum_theme')]
    function indexForum(Request $request, DataTableFactory $dataTableFactory) {

        $table = $dataTableFactory->create()
            ->add('Pseudo', TextColumn::class, ['field' => 'themes.Nom', 'label' => "Name"])



            ->createAdapter(ORMAdapter::class, [
                'entity' => \App\Entity\Themes::class,
                'query' => function(QueryBuilder $builder) {
                $builder
                    ->select('e')
                    ->from(Themes::class, 'e')
                    ->leftJoin('e.Discussions', 'c')
                    ->where('e = c.theme');
                }
            ])
            ->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }


        return $this->render('forum_theme.html.twig', ['datatable' => $table]);
    }

    #[Route('/forum/theme/{theme}', name: 'forum_theme_themes')]
    function themePrecise($theme) {
        return $this->render('theme.html.twig', ['theme' => $theme]);
    }
}