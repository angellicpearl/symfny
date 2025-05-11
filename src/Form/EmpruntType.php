<?php

/// src/Form/EmpruntType.php
namespace App\Form;

use App\Entity\Emprunt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpruntType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateEmprunt', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date d\'emprunt',
            ])
            ->add('dateRetour', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de retour',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Emprunt::class,
        ]);
    }
}

