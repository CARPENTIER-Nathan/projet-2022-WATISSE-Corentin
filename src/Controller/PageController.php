<?php

namespace App\Controller;

use App\Entity\Themes;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigStringColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    function homepage() {
//        return $this->render('base.html.twig');
        return $this->redirectToRoute('forum_theme');
    }


    #[Route('/number_of_connected', name: 'number_of_connected')]
    function numberOfConnected (ManagerRegistry $doctrine){

        $entityManager = $doctrine->getManager();
        $users = $entityManager->getRepository(User::class);

        $actualDate = new \DateTime();
        $actualDate->sub(new \DateInterval('PT2M'));
        $date = date_format($actualDate,"Y/m/d H:i:s" );


        $connectedNumber = $users->createQueryBuilder('u')
            ->select('count(u.id)')
            ->where('u.lastActivityAt > :test')
            ->setParameter('test', $date)
            ->getQuery()
            ->getResult();

    return new Response($connectedNumber[0]['1']);


    }
}