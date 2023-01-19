<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class BackofficeController extends AbstractController
{
    #[Route('/backoffice', name: 'backoffice')]
    public function backoffice(): Response
    {

        return $this->render('backoffice/backoffice.html.twig', [
            
        ]);
    }
    #[Route('/inscription', name: 'inscription')]
    public function inscription(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface, EntityManagerInterface $entityManagerInterface): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user->setPassword($userPasswordHasherInterface->hashPassword($user, $user->getPassword()));
            $entityManagerInterface->persist($user);
            $entityManagerInterface->flush();
            return $this->redirect('/backoffice');
        }
        return $this->render('backoffice/inscription.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('backoffice/login.html.twig', [
            'lastUsername' => $lastUsername,
            'error' => $error
        ]);
    }
}
