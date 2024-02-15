<?php

namespace App\Form;

use App\Entity\TrickCategory;
use App\Entity\Tricks;
use App\Form\DataTransformer\StringToFileAttachmentsTransformer;
use App\Form\DataTransformer\StringToFileTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditTrickType extends AbstractType
{
    public function __construct(
        private readonly StringToFileTransformer $fileTransformer,
        private readonly StringToFileAttachmentsTransformer $fileAttachmentTransformer,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('picture', FileType::class, [
                'required' => false,
                "mapped" => false
            ])
            ->add('edit_picture', CheckboxType::class, [
                'data' => true,
                'mapped' => false,
                "required" => false
            ])
            ->add('description')
            ->add('category', ChoiceType::class, [
                "choices" => [
                    'Saut' => TrickCategory::jump,
                    'Glissade' => TrickCategory::slide,
                    'Rotation' => TrickCategory::spin,
                    'Grabs' => TrickCategory::grabs,
                    'Rotation inversée' => TrickCategory::reverseGrab,
                ]
            ])
            ->add('bg_img', FileType::class, [
                'required' => false,
                "mapped" => false
            ])
            ->add('edit_bg_img', CheckboxType::class, [
                'data' => true,
                'mapped' => false,
                "required" => false

            ])
            ->add('text', TextareaType::class)
            ->add('images', FileType::class, [
            'multiple' => true,
            'mapped' => false,
                'attr' => [
                    'accept' => 'image/jpg,image/jpeg,image/jpg',
                    'multiple' => 'multiple'
                ],
                'required' => false
        ]);
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            /** @var Tricks $trick */
            $trick = $event->getData();
            $form = $event->getForm();

            foreach ($trick->getAttachements()->toArray() as $att) {
                $form->add("check" . $att->getId(), CheckboxType::class, [
                    "mapped" => false,
                    "required" => false,
                    "data" => true,
                    "attr" => [
                        "id" => "att" . $att->getId(),
                        "class" => "checkbox attachment-checkbox",
                    ]
                ]);
            }
        });

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            /** @var array $trick */
            $trick = $event->getData();
            $form = $event->getForm();

            $keys = array_filter(
                array_keys($trick),
                fn ($k) => str_starts_with($k, 'check')
            );

            foreach ($keys as $att) {
                $form->add(
                    $att,
                    CheckboxType::class,
                    [
                        "mapped" => false
                    ]
                );
            }

            $form->get("picture")->setData($trick["picture"]);
        });

        $builder->get("picture")->addModelTransformer($this->fileTransformer);
        $builder->get("bg_img")->addModelTransformer($this->fileTransformer);
        $builder->get("images")->addModelTransformer($this->fileAttachmentTransformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tricks::class,
        ]);
    }
}
