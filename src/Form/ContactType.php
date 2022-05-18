<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', null, array(
                'attr' => array(
                    'placeholder' => 'Votre prénom',
                    'class' => 'form-label')
            ))
            ->add('nom', null, array(
                'attr' => array(
                    'placeholder' => 'Votre nom',
                    'class' => 'form-label')
            ))
            ->add('mail', null, array(
                'attr' => array(
                    'placeholder' => 'Votre email',
                    'class' => 'form-label')
            ))
            ->add('contenu', null, array(
                'label' => 'Message',
                'attr' => array(
                    'placeholder' => 'Votre message',
                    'class' => 'form-label')
            ))
            ->add('Valider', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn btn-primary btn-lg')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
