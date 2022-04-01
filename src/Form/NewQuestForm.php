<?php

namespace App\Form;

use App\Entity\Quest;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class NewQuestForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $today = (new DateTime())->setTime(0,0);
        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(null, 5),
                ],
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(null, 140),
                ],
            ])
            ->add('date', DateTimeType::class, [
                'data' => $today,
                'date_widget' => 'single_text',
                'time_widget' => 'choice',
                'constraints' => [
                    new GreaterThanOrEqual($today),
                    new NotBlank(),
                ],
            ])
            ->add('place', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(null, 2),
                ],
            ])
            ->add('picture', ChoiceType::class, [
                'expanded' => true,
                'multiple' => false,
                'label_html' => true,
                'choices' => [
                    'Planète Terre' => '/images/globe-3984876_960_720.webp',
                    'Bricolage' => '/images/tools-864983_960_720.webp',
                    'Technologie' => '/images/pen-4337524_960_720.webp',
                    'Animaux' => '/images/dog-2606759_960_720.webp',
                ],
                'choice_label' => function ($choice, $key, $value) {
                    return '<img src="' . $value . '" alt="' . $key . '" class="w-100 rounded" />';
                },
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quest::class,
        ]);
    }
}