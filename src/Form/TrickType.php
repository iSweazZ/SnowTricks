<?php

namespace App\Form;

use App\Entity\TrickCategory;
use App\Entity\Tricks;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('picture', FileType::class)
            ->add('description')
            ->add('category', ChoiceType::class,[
                "choices" => [
                    'Saut' => TrickCategory::jump,
                    'Glissade' => TrickCategory::slide,
                    'Rotation' => TrickCategory::spin,
                    'Grabs' => TrickCategory::grabs,
                    'Rotation inversée' => TrickCategory::reverseGrab,
                ]
            ])
            ->add('bg_img', FileType::class)
            ->add('text')
            ->add('images', FileType::class, [
            'multiple' => true,
            'mapped' => false,
                'attr'     => [
                    'accept' => 'image/jpg,image/jpeg,image/jpg',
                    'multiple' => 'multiple'
                ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tricks::class,
        ]);
    }
}