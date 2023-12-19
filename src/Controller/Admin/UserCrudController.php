<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('username'),
            EmailField::new('email'),
            AssociationField::new('game')
                ->autocomplete()
                ->setCrudController(GameCrudController::class),
            ChoiceField::new('roles')->setChoices(['choices' => ['JOUEUR' => 'ROLE_JOUEUR','CHEF DE PROJET' => 'ROLE_CHEFPROJET','COMPTABLE' => 'ROLE_COMPTA','RECRUTEUR' => 'ROLE_RECRUTE','PLANNING' => 'ROLE_PLANNING','MAITRE' => 'ROLE_MAITRE']])->renderExpanded()->allowMultipleChoices(),
        ];
    }
}
