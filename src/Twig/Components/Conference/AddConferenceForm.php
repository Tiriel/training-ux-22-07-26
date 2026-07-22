<?php

namespace App\Twig\Components\Conference;

use App\Entity\Conference;
use App\Form\ConferenceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class AddConferenceForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(ConferenceType::class);
    }

    #[LiveAction]
    public function save(EntityManagerInterface $manager): Response
    {
        $this->submitForm();

        /** @var Conference $conference */
        $conference = $this->getForm()->getData();
        $manager->persist($conference);
        $manager->flush();

        return $this->redirectToRoute('app_conference_show', [
            'id' => $conference->getId(),
        ]);
    }
}
