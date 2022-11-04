<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifyFormFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',     TextType::class, array ('attr' => array ('readonly' => true)))
            ->add('pseudo',    TextType::class ,array ('attr' => array ('require' => false)))
            ->add('nom',       TextType::class ,array ('attr' => array ('require' => false)))
            ->add('prenom',    TextType::class ,array ('attr' => array ('require' => false)))
            ->add('age',       NumberType::class ,array ('attr' => array ('require' => false)))
            ->add('telephone', TelType::class ,array ('attr' => array ('require' => false)))
            ->add('ville',     TextType::class ,array ('attr' => array ('require' => false)))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
