<?php

namespace App\Form;

use App\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SendMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextType::class, array(
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Veuillez renseigner ce champs'
                    )),
                    new Assert\Length(array(
                        'min' => 2,
                        'max' => 255,
                        'minMessage' => '2 carac mini',
                        'maxMessage' => '255 carac maxi'
                    ))
                ))
                )
                -> add('Send', SubmitType::class)
            ;
        }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
