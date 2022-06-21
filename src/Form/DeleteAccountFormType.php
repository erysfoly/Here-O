<?php

namespace App\Form;

use App\Controller\UserController;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\EqualTo;

class DeleteAccountFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('validateDeletion', TextType::class, [
                'constraints' => [
                    new EqualTo(UserController::DELETE_ACCOUNT_SENTENCE)
                ]
            ])
            ->add('confirm', SubmitType::class)
        ;
    }
}
