<?php

namespace App\Form\Type;

use App\Form\Model\PlayerDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', TextType::class)
            ->add('name', TextType::class)
            ->add('age', TextType::class)
            ->add('base64Image', TextType::class)
            ->add('teamId', TextType::class)
            ->add('position', CollectionType::class, [
                'allow_add' => true,
                'allow_delete' => true,
                'entry_type' => PositionFormType::class
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlayerDto::class,
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }

    public function getName(): string
    {
        return '';
    }
}