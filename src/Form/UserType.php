<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints as Assert;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Veuillez renseigner ce champs'
                    )),
                    new Assert\Length(array(
                        'min' => 2,
                        'max' => 30,
                        'minMessage' => '2 carac mini',
                        'maxMessage' => '30 carac maxi'
                ))
                )
            ))
            ->add('password', PasswordType::class)
            ->add('file', FileType::class, array(
                'required' => true
            ))
            ->add('email', EmailType::class)
            ->add('Inscription', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => array(
                'novalidate' => 'novalidate'
            )
        ]);
    }
}
