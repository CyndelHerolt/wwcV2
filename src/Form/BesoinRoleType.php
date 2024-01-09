<?php

namespace App\Form;

use App\Entity\BesoinRole;
use App\Entity\Role;
use App\Repository\RoleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BesoinRoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('role', EntityType::class, [
                'class' => Role::class,
                'choice_label' => 'libelle',
                'query_builder' => function (RoleRepository $er) {
                    return $er->createQueryBuilder('r');
                },
            ])
            ->add('nb_jours', ChoiceType::class, [
                // créer un tableau avec des valeurs de 1 à 30
                'choices' => array_combine(
                    range(1, 30),
                    range(1, 30)
                )
            ])
            ->add('nb_jours_estime_min', ChoiceType::class, [
                // créer un tableau avec des valeurs de 1 à 30
                'choices' => array_combine(
                    range(1, 30),
                    range(1, 30)
                )
            ])
            ->add('nb_jours_estime_max', ChoiceType::class, [
                // créer un tableau avec des valeurs de 1 à 30
                'choices' => array_combine(
                    range(1, 30),
                    range(1, 30)
                )
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BesoinRole::class,
        ]);
    }
}