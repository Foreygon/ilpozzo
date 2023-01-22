<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    #[Route('/backoffice/profile', name: 'profile')]
    public function profile(UserRepository $userRepository, Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', $subject = null, $message = "Acces refuser");

        if ($this->isGranted('ROLE_ADMIN')) {
            $message = "Bonjour Admin";

            $editRoleUser = $this->createFormBuilder()
                ->add('email', ChoiceType::class, [
                    'choices' => $userRepository->findAll(),
                    'choice_label' => function (User $user) {
                        return $user->getEmail();
                    },
                ])
                ->add('roles', ChoiceType::class, [
                    'choices' => [
                        'Utilisateur' => 'ROLE_USER',
                        'Administrateur' => 'ROLE_ADMIN'
                    ],
                    'expanded' => true,
                    'multiple' => true,
                    'label' => 'Rôles'
                ])
                ->add('bouton', SubmitType::class)
                ->getForm();
            $editRoleUser->handleRequest($request);
            if ($editRoleUser->isSubmitted() && $editRoleUser->isValid()) {
                $user = $userRepository->find($editRoleUser->get('email')->getData());
                if ($user != null) {
                    $user->setRoles($editRoleUser->get('roles')->getData());
                    $entityManagerInterface->persist($user);
                    $entityManagerInterface->flush();
                    return $this->redirect('/backoffice/profile');
                } else {
                    // gérer l'erreur
                }
            }
        }

        return $this->render('profile/profile.html.twig', [
            'controller_name' => 'ProfileController',
            'message' => $message,
            'editRoleUser' => $editRoleUser
        ]);
    }
}
