<?php

namespace App\Controller;

use App\Entity\Upload;
use App\Entity\Lacarte;
use App\Form\UploadType;
use App\Entity\Categorie;
use App\Form\LacarteType;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadsController extends AbstractController
{
    #[Route('/uploads', name: "uploads")]
    public function uploads(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $upload = new Upload();
        $form = $this->createForm(UploadType::class, $upload);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('name')->getData();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('upload_directory'), $fileName);
            $upload->setName($fileName);
            $entityManagerInterface->persist($upload);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('uploads');
        }
        return $this->render('uploads/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // ==========================================================================================
    #[Route('/backoffice/profile/lacarte', name: "lacarte")]
    public function lacarte(Request $request, EntityManagerInterface $entityManagerInterface, UploadedFile $uploadedFile): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', $subject = null, $message = "Acces refuser");
        if ($this->isGranted('ROLE_ADMIN')) {
            $message = "Acces autoriser, bonjour Admin";

            $lacarte = new Lacarte();
            $formLacarte = $this->createForm(LacarteType::class, $lacarte);
            $formLacarte->handleRequest($request);


            if ($formLacarte->isSubmitted() && $formLacarte->isValid()) {
                $lacarte = $formLacarte->getData();
                $uploadImage = $formLacarte->get('uploadImage')->getData();
                $fileName = $this->fileUploader->upload($uploadImage);
                $upload = new Upload();
                $upload->setName($fileName);
                $lacarte->setUploadImage($upload);
            
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

    private $fileUploader;

    public function __construct(FileUploader $fileUploader)
    {
        $this->fileUploader = $fileUploader;
    }
    






    // ==========================================================================================
    #[Route('/backoffice/profile/lacarte/categorie', name: "categorie")]
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
}
