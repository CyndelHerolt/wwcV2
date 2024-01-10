<?php

namespace App\Controller\Admin;

use App\Classes\DataUserSession;
use App\Entity\Game;
use App\Entity\Profil;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Doctrine\ORM\QueryBuilder;


class GameCrudController extends AbstractCrudController
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

        $queryBuilder->andWhere('entity.id = :id')
            ->setParameter('id', $game->getId());

        return $queryBuilder;
    }

    public static function getEntityFqcn(): string
    {
        return Game::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addPanel('Général')->setIcon('fa fa-gamepad'),
            TextField::new('nom_partie'),
            AssociationField::new('equipes')
                ->autocomplete()
                ->setCrudController(EquipeCrudController::class)
                ->setFormTypeOption('by_reference', false)
                ->setFormTypeOption('multiple', true),
            AssociationField::new('roles')
                ->autocomplete()
                ->setCrudController(RoleCrudController::class)
                ->setFormTypeOption('by_reference', false)
                ->setFormTypeOption('multiple', true),
            BooleanField::new('active'),
            IntegerField::new('nb_equipes'),
            BooleanField::new('pause'),
            IntegerField::new('periode'),
            TextField::new('phase'),
            TextField::new('time_next'),

            FormField::addPanel('Paramétrage')->setIcon('fa fa-tools'),
            IntegerField::new('nb_jours_mois'),
            MoneyField::new('init_actif_dispo')->setCurrency('EUR')->setStoredAsCents(false),
            MoneyField::new('init_tresorerie_decaissement')->setCurrency('EUR')->setStoredAsCents(false),
            MoneyField::new('init_actif_materiel')->setCurrency('EUR')->setStoredAsCents(false),
            MoneyField::new('montant_impot')->setCurrency('EUR')->setStoredAsCents(false),
            MoneyField::new('location_materiel')->setCurrency('EUR')->setStoredAsCents(false),
            IntegerField::new('init_materiel'),

            NumberField::new('coeff_charges_patronales'),
            NumberField::new('coeff_charges_salariales'),
            NumberField::new('coeff_electricite'),
            NumberField::new('coeff_telephonie'),
            NumberField::new('coeff_deplacement'),
            NumberField::new('coeff_autre'),
            NumberField::new('taux_decouvert'),
            NumberField::new('taux_interet'),

            MoneyField::new('penalite_machine')->setCurrency('EUR')->setStoredAsCents(false),
            MoneyField::new('penalite_surface')->setCurrency('EUR')->setStoredAsCents(false),
        ];
    }
}
