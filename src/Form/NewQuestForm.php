<?php

namespace App\Form;

use App\Entity\Quest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
                'label' => 'Titre',
                'label_attr' => [
                    'class' => 'px-3 w-25',
                ],
                'attr' => [
                    'placeholder' => 'Donne un titre à ta quête.',
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
                    'placeholder' => 'Dis-nous en plus sur ta quête ! Quel est son but, où a-t-elle lieu, pendant combien de temps, quelles sont les missions à accomplir ? etc.',
                    'class' => 'w-75',
                    'rows' => '5',
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
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
            ])
            ->add('place', TextType::class, [
                'label' => 'Lieu',
                'label_attr' => [
                    'class' => 'px-3 w-25',
                ],
                'attr' => [
                    'placeholder' => 'Indique ici le lieu de ta quête.',
                    'class' => 'w-75',
                ],
                'row_attr' => [
                    'class' => 'py-1',
                ],
            ])
            ->add('picture', ChoiceType::class, [
                'label' => 'Image',
                'label_attr' => [
                    'class' => 'px-3 w-25',
                ],
                'attr' => [
                    'class' => 'w-75 d-flex flex-wrap',
                ],
                'row_attr' => [
                    'class' => 'd-flex py-1',
                ],
                'choice_attr' => function () {
                    return [
                        'class' => 'mx-1',
                    ];
                },
                'expanded' => true,
                'multiple' => false,
                'label_html' => true,
                'choices' => [
                    'Planète Terre' => 'https://cdn.pixabay.com/photo/2019/02/09/11/03/globe-3984876_960_720.jpg',
                    'Bricolage' => 'https://cdn.pixabay.com/photo/2015/07/28/20/55/tools-864983_960_720.jpg',
                    'Technologie' => 'https://cdn.pixabay.com/photo/2019/07/14/16/29/pen-4337524_960_720.jpg',
                    'Animaux' => 'https://cdn.pixabay.com/photo/2017/08/07/18/57/dog-2606759_960_720.jpg',
                ],
                'choice_label' => function ($choice, $key, $value) {
                    return '<img src="' . $value . '" alt="' . $key . '" class="w-100" />';
                },
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Crée ta quête maintenant',
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