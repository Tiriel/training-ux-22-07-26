<?php

namespace App\Twig\Components;

use App\Entity\Conference;
use App\Entity\Volunteering;
use App\Form\VolunteeringType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent()]
class VolunteerForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp]
    public Volunteering $initialFormData;

    #[LiveProp]
    public ?Conference $conference = null;

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    #[LiveProp]
    public int $currentStep = 1;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(VolunteeringType::class, $this->initialFormData);
    }
}
