<?php

/// src/Form/EmpruntType.php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class EmpruntType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateEmprunt', DateType::class, [
                'label' => 'Date de début',
                'widget' => 'single_text',
                'data' => new \DateTime(),
                'attr' => ['min' => (new \DateTime())->format('Y-m-d')]
            ])
            ->add('dateRetour', DateType::class, [
                'label' => 'Date de retour',
                'widget' => 'single_text',
                'data' => (new \DateTime())->modify('+14 days'),
                'attr' => ['min' => (new \DateTime())->modify('+1 day')->format('Y-m-d')]
            ]);
    }
}