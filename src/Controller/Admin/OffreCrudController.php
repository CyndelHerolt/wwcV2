<?php

namespace App\Controller\Admin;

use App\Entity\Offre;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OffreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Offre::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('libelle'),
            AssociationField::new('type_offre')
                ->autocomplete()
                ->setCrudController(TypeOffreCrudController::class),
            TextEditorField::new('description_courte'),
            TextEditorField::new('description_longue'),
            IntegerField::new('deadline'),
            MoneyField::new('prix_min')->setCurrency('EUR'),
            MoneyField::new('prix_max')->setCurrency('EUR'),
            BooleanField::new('visible'),
        ];
    }
}
