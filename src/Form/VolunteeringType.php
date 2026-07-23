<?php

namespace App\Form;

use App\Entity\Conference;
use App\Entity\User;
use App\Entity\Volunteering;
use App\Enum\VolunteerSkill;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VolunteeringType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startAt', DateType::class, [
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
            ])
            ->add('endAt', DateType::class, [
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
            ])
            ->add('conference', EntityType::class, [
                'class' => Conference::class,
                'choice_label' => 'name',
            ])
            ->add('skills', EnumType::class, [
                'class' => VolunteerSkill::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => fn(VolunteerSkill $skill) => $skill->getLabel(),
            ])
            ->add('experienceLevel', ChoiceType::class, [
                'choices' => [
                    'Beginner' => 'beginner',
                    'Intermediate' => 'intermediate',
                    'Expert' => 'expert'
                ]
            ])
            ->add('notes', TextareaType::class, [
                'required' => false,
                'attr' => ['rows' => 3]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'data_class' => Volunteering::class,
                'conference' => null,
            ])
            ->setAllowedTypes('conference', [Conference::class, 'null'])
        ;
    }
}
