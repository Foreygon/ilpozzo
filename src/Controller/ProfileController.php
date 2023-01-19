<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile')]
    public function profile(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', $subject=null, $message= "Acces refuser");
        
        if($this->isGranted('ROLE_ADMIN')){
            $message= "Bonjour Admin";
        }

        return $this->render('profile/profile.html.twig', [
            'controller_name' => 'ProfileController',
            'message'=> $message
        ]);
    }
}
