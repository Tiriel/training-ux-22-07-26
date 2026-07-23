<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\FormHandler\RegistrationFormHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, RegistrationFormHandler $handler): Response
    {
        $responseOrForm = $handler->handleForm($request);

        if ($responseOrForm instanceof Response) {
            return $responseOrForm;
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $responseOrForm,
        ]);
    }
}
