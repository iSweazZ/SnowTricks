<?php

namespace App\Form;

use App\Entity\TrickCategory;
use App\Entity\Tricks;
use App\Form\DataTransformer\StringToFileTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditTrickType extends AbstractType
{

    public function __construct(
        private StringToFileTransformer $fileTransformer
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('picture', FileType::class, [
                'required' => false,
            ])
            ->add('edit_picture', CheckboxType::class, [
                'data' => true,
            ])
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
            ->add('bg_img', FileType::class, ['required' => false])
            ->add('edit_bg_img', CheckboxType::class, [
                'data' => true,

            ])
            ->add('text', TextareaType::class)
            ->add('images', FileType::class, [
            'multiple' => true,
            'mapped' => false,
                'attr'     => [
                    'accept' => 'image/jpg,image/jpeg,image/jpg',
                    'multiple' => 'multiple'
                ],
                'required' => false
        ]);

        $builder->get("picture")->addModelTransformer($this->fileTransformer);
        $builder->get("bg_img")->addModelTransformer($this->fileTransformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tricks::class,
        ]);
    }
}
