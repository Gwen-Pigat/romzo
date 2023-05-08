<?php

namespace App\Form;

use App\Entity\ItemsSpecs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemsSpecsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label"=>"Nom *"
            ])
            ->add('valueMax', IntegerType::class, [
                "label"=>"Valeur max (exemple 5)",
                "required"=>false
            ])
            ->add('placement', IntegerType::class, [
                "label"=>"Ordre"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ItemsSpecs::class,
        ]);
    }
}
