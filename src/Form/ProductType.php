<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Discount;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('price')
            ->add('quantity')
            ->add('description')
            ->add('imagep',FileType::class, [
                'mapped' => false
            ])
            ->add('owner',EntityType::class,[
                   'class'=>User::class,
                    'choice_label'=>'name'
                 ])
            ->add('category',EntityType::class,[
                'class'=>Category::class,
                 'choice_label'=>'name'
              ])
            ->add('discount',EntityType::class,[
                'class'=>Discount::class,
                 'choice_label'=>'value'
            ])
            ->add('add',SubmitType::class)
;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
