<?php

namespace App\Controller\Admin;

use App\Classes\DataUserSession;
use App\Entity\Offre;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OffreCrudController extends AbstractCrudController
{
    public function __construct(
        private DataUserSession $dataUserSession
    )
    {
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $game = $this->dataUserSession->getGame();

        // Ajoutez votre condition ici
        $queryBuilder->andWhere('entity.game = :id')
            ->setParameter('id', $game->getId());

        return $queryBuilder;
    }

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
            AssociationField::new('game')
                ->autocomplete()
                ->setCrudController(GameCrudController::class)
                ->setFormTypeOption('by_reference', true)
                ->setFormTypeOption('mapped', true),
            BooleanField::new('visible'),
        ];
    }
}
