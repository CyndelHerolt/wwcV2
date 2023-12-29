<?php

namespace App\Form;

use App\Entity\Proposition;
use App\Entity\TypeOffre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropositionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prix', MoneyType::class, [
                'divisor' => 100,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Prix',
                ],
            ])
//            ->add('etat')
            ->add('type', EntityType::class, [
                'class' => TypeOffre::class,
                'choice_label' => 'libelle',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Proposition::class,
        ]);
    }
}
