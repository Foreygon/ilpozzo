<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Lacarte;
use App\Entity\Categorie;
use App\Form\LacarteType;
use App\Form\CategorieType;
use App\Repository\UserRepository;
use App\Form\DateOpeningClosingType;
use App\Entity\DateOpeningClosingTime;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\DateOpeningClosingTimeRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProfileController extends AbstractController
{
    #[Route('/backoffice/profile', name: 'profile')]
    public function profile(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', $subject = null, $message = "Acces refuser");
        if ($this->isGranted('ROLE_ADMIN')) {
            $message = "Acces autoriser, bonjour Admin";
        }
        return $this->render('profile/profile.html.twig', [
            'controller_name' => 'ProfileController',
            'message' => $message
        ]);
    }

    #[Route('/backoffice/profile/role', name: 'role')]
    public function role(UserRepository $userRepository, Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', $subject = null, $message = "Acces refuser");

        if ($this->isGranted('ROLE_ADMIN')) {
            $message = "Acces autoriser, bonjour Admin";

            $users = $userRepository->findAll();
            $currentUser = $this->getUser();
            $filteredUsers = array_filter($users, function (User $user) use ($currentUser) {
                return $user->getEmail() != $currentUser->getEmail();
            });

            $editRoleUser = $this->createFormBuilder()
                ->add('email', ChoiceType::class, [
                    'choices' => $filteredUsers,
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

            return $this->render('profile/role.html.twig', [
                'controller_name' => 'ProfileController',
                'message' => $message,
                'editRoleUser' => $editRoleUser
            ]);
        }



        return $this->render('profile/role.html.twig', [
            'controller_name' => 'ProfileController',
            'message' => $message,


        ]);
    }
    // ==========================================================================================
    #[Route('/backoffice/profile/ardoise', name: 'ardoise')]
    public function ardoise(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', $subject = null, $message = "Acces refuser");
        if ($this->isGranted('ROLE_ADMIN')) {
            $message = "Acces autoriser, bonjour Admin";
        }
        return $this->render('profile/ardoise.html.twig', [
            'controller_name' => 'ProfileController',
            'message' => $message
        ]);
    }
    // ==========================================================================================
    #[Route('/backoffice/profile/lacarte', name: 'lacarte')]
    public function lacarte(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', $subject = null, $message = "Acces refuser");
        if ($this->isGranted('ROLE_ADMIN')) {
            $message = "Acces autoriser, bonjour Admin";

            $lacarte = new Lacarte();
            $formLacarte = $this->createForm(LacarteType::class, $lacarte);
            $formLacarte->handleRequest($request);


            if ($formLacarte->isSubmitted() && $formLacarte->isValid()) {
                $lacarte = $formLacarte->getData();
                $entityManagerInterface->persist($lacarte);
                $entityManagerInterface->flush();

                return $this->redirectToRoute('lacarte');
            }

            return $this->render('profile/lacarte.html.twig', [
                'controller_name' => 'ProfileController',
                'message' => $message,
                'form' => $formLacarte->createView(),
            ]);
        }

        return $this->render('profile/lacarte.html.twig', [
            'controller_name' => 'ProfileController',
            'message' => $message
        ]);
    }


    // ==========================================================================================
    #[Route('/backoffice/profile/lacarte/categorie', name: 'categorie')]
    public function categorie(Request $request, EntityManagerInterface $entityManagerInterface, CategorieRepository $categorieRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', $subject = null, $message = "Acces refuser");
        if ($this->isGranted('ROLE_ADMIN')) {
            $message = "Acces autoriser, bonjour Admin";

            $categorie = new Categorie();
            $formCategorie = $this->createForm(CategorieType::class, $categorie);

            $formCategorie->handleRequest($request);

            if ($formCategorie->isSubmitted() && $formCategorie->isValid()) {
                $entityManagerInterface->persist($categorie);
                $entityManagerInterface->flush();
            }

            $categoriesRepos = new Categorie();
            $categoriesRepos = $categorieRepository->findAll();

            return $this->render('profile/_categorie.html.twig', [
                'controller_name' => 'ProfileController',
                'message' => $message,
                'form' => $formCategorie->createView(),
                'categories' => $categoriesRepos,
            ]);
        }

        return $this->render('profile/_categorie.html.twig', [
            'controller_name' => 'ProfileController',
            'message' => $message,
        ]);
    }
    // ==========================================================================================
    #[Route('/backoffice/profile/carrousel', name: 'carrousel')]
    public function carrousel(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', $subject = null, $message = "Acces refuser");
        if ($this->isGranted('ROLE_ADMIN')) {
            $message = "Acces autoriser, bonjour Admin";
        }
        return $this->render('profile/carrousel.html.twig', [
            'controller_name' => 'ProfileController',
            'message' => $message
        ]);
    }
    // ==========================================================================================
    #[Route('/backoffice/profile/horaire', name: 'horaire')]
    public function horaire(Request $request, EntityManagerInterface $entityManagerInterface, DateOpeningClosingTimeRepository $dateOpeningClosingTimeRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', $subject = null, $message = "Acces refuser");
        if ($this->isGranted('ROLE_ADMIN')) {

            $message = "Acces autoriser, bonjour Admin";

            $dateOpeningClosingTime = new DateOpeningClosingTime();

            $formDateOpeningClosingTime = $this->createForm(DateOpeningClosingType::class, $dateOpeningClosingTime);

            $formDateOpeningClosingTime->handleRequest($request);

            if ($formDateOpeningClosingTime->isSubmitted() && $formDateOpeningClosingTime->isValid()) {
                $entityManagerInterface->persist($dateOpeningClosingTime);
                $entityManagerInterface->flush();
                return $this->redirect('/backoffice/profile/horaire');
            }

            $times = new DateOpeningClosingTime();
            $times = $dateOpeningClosingTimeRepository->findAll();

            return $this->render('profile/horaire.html.twig', [
                'controller_name' => 'ProfileController',
                'message' => $message,
                'form' => $formDateOpeningClosingTime->createView(),
                'times' => $times
            ]);
        }



        return $this->render('profile/horaire.html.twig', [
            'controller_name' => 'ProfileController',
            'message' => $message
        ]);
    }
    // ==========================================================================================
    #[Route('/backoffice/profile/ticket', name: 'ticket')]
    public function ticket(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', $subject = null, $message = "Acces refuser");
        if ($this->isGranted('ROLE_ADMIN')) {
            $message = "Acces autoriser, bonjour Admin";
        }
        return $this->render('profile/ticket.html.twig', [
            'controller_name' => 'ProfileController',
            'message' => $message
        ]);
    }
}
