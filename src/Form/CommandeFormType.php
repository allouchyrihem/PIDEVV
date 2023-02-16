<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\Product;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CommandeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('date')
            ->add('adress')
            ->add('sum')
            ->add('etat',ChoiceType::class,[
                'required'=>true,
                'multiple'=>false,
                'choices'=>[
                    'en attente'=>'en attente',
                    'livré'=>'livré',
                    'encours'=>'encours',
                    'confirmé'=>'confirmé'
                ],
            ])
            ->add('client',EntityType::class,[
                'class'=>User::class,
                'choice_label'=>'name'
            ])
            
            ->add('save',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
