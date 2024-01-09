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
        ];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
{
    if ($entityInstance instanceof Profil) {
        $role = $entityInstance->getRole();
        $niveauCompetences = $entityInstance->getNiveauCompetences();

        if ($entityInstance->getType() === 'freelance') {
            // Si c'est un freelance, le salaire est égal au salaire du rôle plus 10% par niveau de compétences à partir de 5
            $salaire = $role->getSalaireFreelance() * (1 + (($niveauCompetences - 5) / 10));
        } else {
            // Si c'est un salarié, le salaire est égal au salaire du role plus 10% par niveau de compétences à partir de 5
            $salaire = $role->getSalaireSalarie() * (1 + (($niveauCompetences - 5) / 10));
        }
        // si le niveau de compétences est supérieur à 5, ces taches recurrentes seront réalisées avec un bonus de 1 point de compétence par niveau de compétence au dessus de 5
        if ($niveauCompetences > 5) {
            $entityInstance->setTacheRecurrente($role->getTacheRecurrente() - ($niveauCompetences - 5));
        } else {
            $entityInstance->setTacheRecurrente($role->getTacheRecurrente());
        }
        $entityInstance->setSalaire($salaire);
    }

    parent::updateEntity($entityManager, $entityInstance);
}
}
