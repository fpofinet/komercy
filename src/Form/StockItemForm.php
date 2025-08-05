<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\StockItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class StockItemForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'designation',
            ])
            ->add('quantity', IntegerType::class,[])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StockItem::class,
        ]);
    }
}
