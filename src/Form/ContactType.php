<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ContactType
 * @package App\Controller\Form
 */
class ContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'name',
                    'placeholder' => 'Nom'

                ]
            ])
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'firstname',
                    'placeholder' => 'Prénom'

                ]
            ])
            ->add("email", EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'inputEmail4',
                    'placeholder' => 'Email'
                ]
            ])
            ->add("question", TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'question',
                    'placeholder' => 'Votre question'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Contact::class,
            'csrf_protection' => false,
        ));
    }
}