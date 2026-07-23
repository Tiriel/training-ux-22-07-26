<?php

namespace App\Twig\Components;

use App\Entity\Conference;
use App\Entity\Volunteering;
use App\Form\VolunteeringType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent()]
class VolunteerForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    private ?Volunteering $initialFormData = null;

    #[LiveProp]
    public ?Conference $conference = null;

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    #[LiveProp]
    public int $currentStep = 1;

    protected function instantiateForm(): FormInterface
    {
        $this->initialFormData = (new Volunteering())
            ->setForUser($this->getUser())
            ->setConference($this->conference)
        ;

        return $this->createForm(VolunteeringType::class, $this->initialFormData);
    }

    #[LiveAction]
    public function nextStep(): void
    {
        $this->submitForm();
        if ($this->validateCurrentStep()) {
            $this->currentStep = min($this->currentStep + 1, 2);
        }
    }

    #[LiveAction]
    public function previousStep(): void
    {
        $this->currentStep = max($this->currentStep - 1, 1);
    }

    #[LiveAction]
    public function save(): void
    {
        $this->submitForm();
        if ($this->getForm()->isValid()) {
            $volunteering = $this->getForm()->getData();

            $this->entityManager->persist($volunteering);
            $this->entityManager->flush();

            $this->currentStep = 3;
        }
    }

    private function validateCurrentStep(): bool
    {
        if ($this->currentStep === 2) {
            return $this->validateSkillsAndPreferences();
        }

        return $this->validateTimeAvailability();
    }

    private function validateAllSteps(): bool
    {
        return $this->validateSkillsAndPreferences() && $this->validateTimeAvailability();
    }

    private function validateTimeAvailability(): bool
    {
        $startAtField = $this->getForm()->get('startAt');
        $endAtField = $this->getForm()->get('endAt');

        return $startAtField->isValid() && $endAtField->isValid();
    }

    private function validateSkillsAndPreferences(): bool
    {
        $skillsField = $this->getForm()->get('skills');
        $experienceField = $this->getForm()->get('experienceLevel');

        return $skillsField->isValid() && $experienceField->isValid();
    }
}
