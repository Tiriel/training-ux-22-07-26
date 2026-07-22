<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Conference;
use App\Form\ConferenceType;
use App\Repository\ConferenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class ConferenceController extends AbstractController
{
    #[Route('/conference/new', name: 'app_conference_new', methods: ['GET', 'POST'])]
    public function newConference(Request $request, EntityManagerInterface $manager): Response
    {
        $conference = new Conference();
        $form = $this->createForm(ConferenceType::class, $conference);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($conference);
            $manager->flush();

            return $this->redirectToRoute('app_conference_show', ['id' => $conference->getId()]);
        }

        return $this->render('conference/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/conference', name: 'app_conference_list', methods: ['GET'])]
    public function list(
        ConferenceRepository $repository,
        #[MapQueryParameter('from_date')] ?string $fromDate,
        #[MapQueryParameter('to_date')] ?string $toDate
    ): Response
    {
        $toDate = \is_string($toDate) ? new \DateTimeImmutable($toDate) : null;
        $fromDate = \is_string($fromDate) ? new \DateTimeImmutable($fromDate) : null;

        return $this->render('conference/list.html.twig', [
            'conferences' => $repository->findConferencesBetweenDates($fromDate, $toDate),
            'from_date' => $fromDate,
            'to_date' => $toDate,
        ]);
    }

    #[Route('/conference/{id}', name: 'app_conference_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Conference $conference): Response
    {
        return $this->render('conference/show.html.twig', [
            'conference' => $conference,
        ]);
    }
}
