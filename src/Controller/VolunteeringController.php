<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Entity\Volunteering;
use App\Form\VolunteeringType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VolunteeringController extends AbstractController
{
    #[Route('/volunteering/{id}', name: 'app_volunteering_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Volunteering $volunteering): Response
    {
        return $this->render('volunteering/show.html.twig', [
            'volunteering' => $volunteering,
        ]);
    }

    #[Route('/volunteering/new', name: 'app_volunteering_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        if ($request->query->get('conference')) {
            $conference = $manager->getRepository(Conference::class)->find($request->get('conference'));
        }

        return $this->render('volunteering/new.html.twig', [
            'conference' => $conference ?? null,
        ]);
    }
}
