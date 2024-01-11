<?php

namespace App\Form;

use App\Entity\Equipe;
use App\Entity\Offre;
use App\Entity\Projet;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $game = $options['game'];

        $builder
            ->add('assigneRoles', CollectionType::class, [
                'entry_type' => AssigneRoleType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => ['disabled' => $game->isPause(true)],
                    'game' => $game,
                ],
                'allow_add' => false,
                'allow_delete' => false,
                'by_reference' => false,
                'mapped' => true,
                'label' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
            'game' => null,
            //todo: retirer en prod
            'csrf_protection' => false,
        ]);
    }
}
