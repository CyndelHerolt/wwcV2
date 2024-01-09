<?php

namespace App\Form;

use App\Entity\EstimationRole;
use App\Entity\Proposition;
use App\Entity\Role;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EstimationRoleType extends AbstractType
{

public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $game = $options['game'];

    $builder
        ->add('nb_jours', IntegerType::class, [
            'attr' => [
                'class' => 'form-control',
                'disabled' => $game->isPause(),
            ],
            'label' => 'Nombre de jours', // Ce libellé sera remplacé par l'événement PRE_SET_DATA
            'mapped' => true,
        ]);

    $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($game) { // Utilisez l'option ici
        $estimationRole = $event->getData();
        $form = $event->getForm();

        if ($estimationRole instanceof EstimationRole) {
            $form->add('nb_jours', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'disabled' => $game->isPause(),
                ],
                'label' => $estimationRole->getRole()->getLibelle(),
                'mapped' => true,
            ]);
        }
    });
}

public function configureOptions(OptionsResolver $resolver): void
{
    $resolver->setDefaults([
        'data_class' => EstimationRole::class,
        'game' => null,
    ]);
}
}
