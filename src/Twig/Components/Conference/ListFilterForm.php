<?php

namespace App\Twig\Components\Conference;

use App\Form\ConferenceFilterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class ListFilterForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp(writable: true, url: true)]
    public ?\DateTimeImmutable $fromDate = null;
    #[LiveProp(writable: true, url: true)]
    public ?\DateTimeImmutable $toDate = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(ConferenceFilterType::class, [
            'fromDate' => $this->fromDate,
            'toDate' => $this->toDate,
        ]);
    }

    #[LiveAction]
    public function filter(): Response
    {
        $this->submitForm();

        $data = $this->getForm()->getData();

        $this->fromDate = $data['fromDate'];
        $this->toDate = $data['toDate'];

        return $this->redirectToRoute('app_conference_list', [
            'fromDate' => $this->fromDate?->format(\DateTimeImmutable::ATOM),
            'toDate' => $this->toDate?->format(\DateTimeImmutable::ATOM),
        ]);
    }
}
