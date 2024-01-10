<?php

namespace App\Form;

use App\Entity\AssigneRole;
use App\Entity\EstimationRole;
use App\Entity\Projet;
use App\Entity\Role;
use App\Repository\RoleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssigneRoleType extends AbstractType
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
            $assigneRole = $event->getData();
            $form = $event->getForm();

            if ($assigneRole instanceof AssigneRole) {
                $form->add('nb_jours', IntegerType::class, [
                    'attr' => [
                        'class' => 'form-control',
                        'disabled' => $game->isPause(),
                    ],
                    'label' => $assigneRole->getRole()->getLibelle(),
                    'mapped' => true,
                ]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AssigneRole::class,
            'game' => null,
        ]);
    }
}
