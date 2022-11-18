<?php

namespace App\Listener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ActivityListener
{
    private $requestStack;
    private $tokenStorage;
    private $entityManager;

    public function __construct(RequestStack $requestStack, TokenStorageInterface  $tokenStorage, EntityManagerInterface $entityManager)
    {
        $this->requestStack = $requestStack;
        $this->tokenStorage = $tokenStorage;
        $this->entityManager = $entityManager;
    }

    //-----------------------------------------------------//

    public function onKernelController(ControllerEvent $event)
    {
       try {
           $user = $this->tokenStorage->getToken()->getUser();

           if ($user instanceof UserInterface) {
               $user->setLastActivityAt(new \DateTime());

               $this->entityManager->persist($user);
               $this->entityManager->flush();

           }
       } finally {
           return;
       }

    }
}