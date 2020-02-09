<?php

namespace App\Form;

use App\Entity\Groupe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\User;

class CreateGroupeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array(
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
            ->add('file', FileType::class, array(
                'required' => false
            ))
            ->add('users', 
            EntityType::class, array(
                'class' => User::class,
                'multiple' => true,
                'expanded' =>true,
                'choice_label' => 'username'
            ))
            -> add('Creer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Groupe::class,
            'attr' => array(
                'novalidate' => 'novalidate'
            )
        ]);
    }
}
