<?php

namespace App\Controller\Admin;

use App\Entity\Equipe;
use App\Entity\Profil;
use App\Repository\ProfilRepository;
use Doctrine\ORM\EntityManagerInterface;
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
use function PHPUnit\Framework\isEmpty;

class EquipeCrudController extends AbstractCrudController
{

    public function __construct(
        private ProfilRepository $profilRepository,
    )
    {

    }

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
            AssociationField::new('surface')
                ->autocomplete()
                ->setCrudController(SurfaceCrudController::class)
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

    public function createEntity(string $entityFqcn)
    {
        return new $entityFqcn;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Equipe) {
            if ($entityInstance->getProfils()->isEmpty()) {
                foreach ($entityInstance->getGame()->getRoles() as $role) {
                    if ($role->isOptDebut() === true) {
                        $profil = new Profil();
                        $profil->setPrenom($entityInstance->getNom());
                        $profil->setNom($role->getLibelle());
                        $profil->setEquipe($entityInstance);
                        $profil->setType('salarie');
                        $profil->setNiveauCompetences(5);
                        $profil->setSalaire($role->getSalaireSalarie());
                        $profil->setNbJours($role->getNbJoursTravailles());
                        $profil->setTacheRecurrente($role->getTacheRecurrente());
                        $profil->setTempsMission(0);
                        $profil->setRole($role);

                        $this->profilRepository->save($profil);
                    }
                }
            }
        }

        parent::updateEntity($entityManager, $entityInstance);
    }
}
