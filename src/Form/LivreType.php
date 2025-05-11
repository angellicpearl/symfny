<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Genre;
use App\Entity\Livre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre du livre',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le titre du livre'
                ],
                'label_attr' => ['class' => 'form-label custom-label'] // Classe personnalisée pour le label
            ])
            ->add('ISBN', TextType::class, [
                'label' => 'Numéro ISBN',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez l\'ISBN du livre'
                ],
                'label_attr' => ['class' => 'form-label custom-label']
            ])
            ->add('disponible', CheckboxType::class, [
                'label' => 'Disponible',
                'required' => false,
                'attr' => ['class' => 'form-check-input'],
                'label_attr' => ['class' => 'form-label custom-label']
            ])
            ->add('auteur', EntityType::class, [
                'class' => Auteur::class,
                'choice_label' => 'nom',
                'label' => 'Auteur',
                'placeholder' => 'Choisir un auteur',
                'attr' => ['class' => 'form-select select2'],
                'label_attr' => ['class' => 'form-label custom-label']
            ])
            ->add('genre', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'nom',
                'label' => 'Genre',
                'placeholder' => 'Choisir un genre',
                'attr' => ['class' => 'form-select select2'],
                'label_attr' => ['class' => 'form-label custom-label']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
