<?php

namespace App\Twig\Components\Conference;

use App\Entity\Conference;
use App\Repository\ConferenceRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class ConferenceList
{
    use DefaultActionTrait;
    use ComponentToolsTrait;

    #[LiveProp]
    public ?\DateTimeImmutable $fromDate = null;

    #[LiveProp]
    public ?\DateTimeImmutable $toDate = null;

    #[LiveProp]
    public string $search = '';

    #[LiveProp]
    public string $organization = '';

    #[LiveProp]
    public string $sortBy = 'startAt';

    #[LiveProp]
    public bool $sortDesc = false;

    #[LiveProp]
    public ?Conference $selectedConference = null;

    public function __construct(
        private readonly ConferenceRepository $repository,
    ) {}

    #[LiveAction]
    public function selectConference(#[LiveArg] Conference $conference): void
    {
        $this->selectedConference = $conference;
        $this->emit('conference:selected', [
            'conference' => $this->selectedConference,
        ]);
    }

    #[LiveAction]
    public function backToList(): void
    {
        $this->selectedConference = null;
        $this->emit('conference:back_to_list');
    }

    public function getConferences(): array
    {
        return $this->repository->findConferencesBetweenDates($this->fromDate, $this->toDate);
    }
}
