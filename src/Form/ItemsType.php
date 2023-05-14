<?php

namespace App\Form;

use App\Entity\Items;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label"=>"Nom *"
            ])
            ->add('image', FileType::class, [
                "label"=>"Image",
                "required"=>false,
                "data_class"=>null
            ])
            ->add('youtubeLink', TextType::class, [
                "label"=>"Lien youtube",
                "required"=>false
            ])
            ->add('orientation', ChoiceType::class, [
                "label"=>"Sens de jeu / Format *",
                'choices'  => [
                    'V'=>'V',
                    'H'=>"H"
                ],
            ])
            ->add('placement', IntegerType::class, [
                "label"=>"Emplacement",
                "required"=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Items::class,
        ]);
    }
}
