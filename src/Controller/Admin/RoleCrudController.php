<?php

namespace App\Controller\Admin;

use App\Entity\Role;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RoleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Role::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('libelle', 'Libellé'),
            MoneyField::new('salaireSalarie', 'Salaire salarié')->setCurrency('EUR')->setStoredAsCents(false),
            MoneyField::new('salaireFreelance', 'Salaire freelance')->setCurrency('EUR')->setStoredAsCents(false),
            IntegerField::new('tacheRecurrente', 'Tâche récurrente'),
            IntegerField::new('nbJoursTravailles', 'Nombre de jours travaillés'),
        ];
    }
}
