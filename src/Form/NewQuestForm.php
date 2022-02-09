<?php

namespace App\Form;

use App\Entity\Quest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewQuestForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label_attr' => [
                    'class' => 'px-3 w-25',
                ],
                'attr' => [
                    'placeholder' => 'Title',
                    'class' => 'w-75',
                ],
                'row_attr' => [
                    'class' => 'py-1',
                ],
            ])
            ->add('author', TextType::class, [
                'label_attr' => [
                    'class' => 'px-3 w-25',
                ],
                'attr' => [
                    'placeholder' => 'Author',
                    'class' => 'w-75',
                ],
                'row_attr' => [
                    'class' => 'py-1',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label_attr' => [
                    'class' => 'px-3 w-25',
                ],
                'attr' => [
                    'placeholder' => 'Tell us about you quest ! What\'s its goal, where is it, how long time? etc.',
                    'class' => 'w-75',
                ],
                'row_attr' => [
                    'class' => 'py-1',
                ],
            ])
            ->add('date', DateTimeType::class, [
                'label_attr' => [
                    'class' => 'px-3 w-25',
                ],
                'attr' => [
                    'class' => 'w-75 d-flex',
                ],
                'row_attr' => [
                    'class' => 'd-flex py-1',
                ],
            ])
            ->add('place', TextType::class, [
                'label_attr' => [
                    'class' => 'px-3 w-25',
                ],
                'attr' => [
                    'placeholder' => 'Place',
                    'class' => 'w-75',
                ],
                'row_attr' => [
                    'class' => 'py-1',
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Create new quest',
                'attr' => [
                    'class' => 'btn btn-primary align-text-top',
                ],
                'row_attr' => [
                    'class' => 'text-center pt-3',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quest::class,
        ]);
    }
}