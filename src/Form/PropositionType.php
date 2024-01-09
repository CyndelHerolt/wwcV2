<?php

namespace App\Form;

use App\Entity\Proposition;
use App\Entity\TypeOffre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropositionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $game = $options['game'];

        $builder
            ->add('prix', MoneyType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Prix',
                ],
                'mapped' => true,
            ])
            ->add('type', EntityType::class, [
                'attr' => [
                    'class' => 'form-select',
                ],
                'class' => TypeOffre::class,
                'choice_label' => 'libelle',
                'mapped' => true,
            ])
            ->add('estimationRoles', CollectionType::class, [
                'entry_type' => EstimationRoleType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => ['disabled' => $game->isPause(true)],
                    'game' => $game,
                ],
                'allow_add' => false,
                'allow_delete' => false,
                'by_reference' => false,
                'mapped' => true,
                'label' => 'Estimation du nombre de jours mobilisés pour chaque rôle',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Proposition::class,
            'game' => null,
        ]);
    }
}
