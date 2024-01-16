<?php

namespace App\Controller\Admin;

use App\Entity\Surface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SurfaceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Surface::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('libelle', 'Libellé'),
            MoneyField::new('tarif', 'Tarif')->setCurrency('EUR')->setStoredAsCents(false),
            IntegerField::new('capaciteMin', 'Capacité minimale'),
            IntegerField::new('capaciteMax', 'Capacité maximale'),
            AssociationField::new('game')
                ->autocomplete()
                ->setCrudController(GameCrudController::class)
                ->setFormTypeOption('by_reference', false)
                ->setFormTypeOption('multiple', true),
        ];
    }
}
