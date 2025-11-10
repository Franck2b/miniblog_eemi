<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de l\'article',
                'attr' => [
                    'placeholder' => 'Ex: La nouvelle Porsche 911 Turbo S',
                    'class' => 'form-control'
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Contenu',
                'attr' => [
                    'placeholder' => 'Rédigez votre article ici...',
                    'rows' => 12,
                    'class' => 'form-control'
                ]
            ])
            ->add('image', UrlType::class, [
                'label' => 'URL de l\'image',
                'required' => false,
                'attr' => [
                    'placeholder' => 'https://example.com/image.jpg',
                    'class' => 'form-control'
                ],
                'help' => 'URL de l\'image principale de l\'article (optionnel)'
            ])
            ->add('category', ChoiceType::class, [
                'label' => 'Catégorie',
                'choices' => [
                    'Luxe' => 'Luxury',
                    'Sports' => 'Sports',
                    'Abordable' => 'Affordable',
                    'Moteur' => 'Engine',
                    'Présentation' => 'Presentation',
                    'Recherche' => 'Research',
                    'Classique' => 'Classic',
                    'Experts' => 'Experts',
                    'Assurance' => 'Assurance',
                    'Succès Client' => 'Customer Success',
                ],
                'placeholder' => 'Choisissez une catégorie',
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
