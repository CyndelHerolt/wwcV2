<?php

namespace App\Controller\Admin;

use App\Entity\Equipe;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\RangeType;

class EquipeCrudController extends AbstractCrudController
{

//    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
//    {
//        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
//
//        // Ajoutez votre condition ici
//        $queryBuilder->andWhere('entity.id = :id')
//            ->setParameter('id', 1);
//
//        return $queryBuilder;
//    }

    public static function getEntityFqcn(): string
    {
        return Equipe::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            AssociationField::new('users')
                ->autocomplete()
                ->setCrudController(UserCrudController::class)
                ->setFormTypeOption('by_reference', false)
                ->setFormTypeOption('multiple', true),
            AssociationField::new('game')
                ->autocomplete()
                ->setCrudController(GameCrudController::class)
                ->setFormTypeOption('by_reference', true)
                ->setFormTypeOption('multiple', false),
            IntegerField::new('reputation')
                ->setFormType(RangeType::class)
                ->setFormTypeOptions([
                    'attr' => [
                        'min' => 0,
                        'max' => 12
                    ]
                ]),
            ColorField::new('couleur'),
        ];
    }
}
