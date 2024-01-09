<?php

namespace App\Controller\Admin;

use App\Entity\BesoinRole;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BesoinRoleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BesoinRole::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('role')
                ->autocomplete()
                ->setCrudController(RoleCrudController::class),
            ChoiceField::new('nb_jours')
                ->setChoices(
                    // On crée un tableau avec des valeurs de 1 à 30
                    array_combine(
                        range(1, 30),
                        range(1, 30)
                    )
                ),
            ChoiceField::new('nb_jours_estime_min')
                ->setChoices(
                    // On crée un tableau avec des valeurs de 1 à 30
                    array_combine(
                        range(1, 30),
                        range(1, 30)
                    )
                ),
            ChoiceField::new('nb_jours_estime_max')
                ->setChoices(
                    // On crée un tableau avec des valeurs de 1 à 30
                    array_combine(
                        range(1, 30),
                        range(1, 30)
                    )
                )
        ];
    }

}
