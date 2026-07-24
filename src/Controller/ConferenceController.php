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
    public function newConference(): Response
    {
        return $this->render('conference/new.html.twig');
    }

    #[Route('/conference', name: 'app_conference_list', methods: ['GET'])]
    public function list(
        #[MapQueryParameter()] ?string $fromDate,
        #[MapQueryParameter()] ?string $toDate
    ): Response
    {
        $fromDate = \is_string($fromDate) ? \DateTimeImmutable::createFromFormat(\DateTimeImmutable::ATOM, $fromDate) : null;
        $toDate = \is_string($toDate) ? \DateTimeImmutable::createFromFormat(\DateTimeImmutable::ATOM, $toDate) : null;

        return $this->render('conference/list.html.twig', [
            'fromDate' => $fromDate,
            'toDate' => $toDate,
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
