<?php

namespace App\Controller\Admin;

use App\Entity\Profil;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\RangeType;

class ProfilCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Profil::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('prenom', 'Prénom'),
            TextField::new('nom', 'Nom'),
            ChoiceField::new('type', 'Type de profil')
                ->setChoices([
                    'Salarié' => 'salarie',
                    'Freelance' => 'freelance',
                ]),
            IntegerField::new('niveauCompetences', 'Niveau de compétences')
                ->setFormType(RangeType::class)
                ->setFormTypeOption('attr', [
                    'min' => 0,
                    'max' => 10,
                ]),
            IntegerField::new('tempsMission', 'Temps de mission')
                ->setHelp('Si c\'est un salarié, saisir "0", sinon, saisir le nombre de mois de mission.'),
            AssociationField::new('role', 'Rôle')
                ->autocomplete()
                ->setCrudController(RoleCrudController::class)
                ->setFormTypeOption('by_reference', true)
                ->setFormTypeOption('multiple', false),
            AssociationField::new('equipe', 'Equipe')
                ->autocomplete()
                ->setCrudController(EquipeCrudController::class)
                ->setFormTypeOption('by_reference', true)
                ->setFormTypeOption('multiple', false),
        ];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Profil) {
            $role = $entityInstance->getRole();
            $niveauCompetences = $entityInstance->getNiveauCompetences();

            if ($entityInstance->getType() === 'freelance') {
                $salaire = $role->getSalaireFreelance() * (1 + (($niveauCompetences - 5) / 10));
            } else {
                $salaire = $role->getSalaireSalarie() * (1 + (($niveauCompetences - 5) / 10));
            }
            $entityInstance->setSalaire($salaire);

            if ($niveauCompetences > 5 && $entityInstance->getType() === 'salarie') {
                $entityInstance->setTacheRecurrente($role->getTacheRecurrente() - ($niveauCompetences - 5));
                $entityInstance->setNbJours($role->getNbJoursTravailles() + ($niveauCompetences - 5));
            } elseif ($niveauCompetences < 5 && $entityInstance->getType() === 'salarie') {
                $entityInstance->setTacheRecurrente($role->getTacheRecurrente());
                $entityInstance->setNbJours($role->getNbJoursTravailles() - (5 - $niveauCompetences));
            } elseif ($niveauCompetences > 5 && $entityInstance->getType() === 'freelance') {
                $entityInstance->setTacheRecurrente(0);
                $entityInstance->setNbJours($role->getNbJoursTravailles() + ($niveauCompetences - 5));
            } elseif ($niveauCompetences < 5 && $entityInstance->getType() === 'freelance') {
                $entityInstance->setTacheRecurrente(0);
                $entityInstance->setNbJours($role->getNbJoursTravailles() - (5 - $niveauCompetences));
            } else {
                $entityInstance->setTacheRecurrente($role->getTacheRecurrente());
                $entityInstance->setNbJours($role->getNbJoursTravailles());
            }
        }

        parent::updateEntity($entityManager, $entityInstance);
    }

    public function createEntity(string $entityFqcn)
    {
        return new $entityFqcn;
    }

    public function prePersist(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Profil) {
            $role = $entityInstance->getRole();
            $niveauCompetences = $entityInstance->getNiveauCompetences();

            if ($entityInstance->getType() === 'freelance') {
                $salaire = $role->getSalaireFreelance() * (1 + (($niveauCompetences - 5) / 10));
            } else {
                $salaire = $role->getSalaireSalarie() * (1 + (($niveauCompetences - 5) / 10));
            }
            $entityInstance->setSalaire($salaire);

            if ($niveauCompetences > 5 && $entityInstance->getType() === 'salarie') {
                $entityInstance->setTacheRecurrente($role->getTacheRecurrente() - ($niveauCompetences - 5));
                $entityInstance->setNbJours($role->getNbJoursTravailles() + ($niveauCompetences - 5));
            } elseif ($niveauCompetences < 5 && $entityInstance->getType() === 'salarie') {
                $entityInstance->setTacheRecurrente($role->getTacheRecurrente());
                $entityInstance->setNbJours($role->getNbJoursTravailles() - (5 - $niveauCompetences));
            } elseif ($niveauCompetences > 5 && $entityInstance->getType() === 'freelance') {
                $entityInstance->setTacheRecurrente(0);
                $entityInstance->setNbJours($role->getNbJoursTravailles() + ($niveauCompetences - 5));
            } elseif ($niveauCompetences < 5 && $entityInstance->getType() === 'freelance') {
                $entityInstance->setTacheRecurrente(0);
                $entityInstance->setNbJours($role->getNbJoursTravailles() - (5 - $niveauCompetences));
            } else {
                $entityInstance->setTacheRecurrente($role->getTacheRecurrente());
                $entityInstance->setNbJours($role->getNbJoursTravailles());
            }

        }
    }

}
