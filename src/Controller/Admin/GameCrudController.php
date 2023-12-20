<?php

namespace App\Controller\Admin;

use App\Classes\DataUserSession;
use App\Entity\Game;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
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

        // Ajoutez votre condition ici
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
        yield FormField::addPanel('Général')->setIcon('fa fa-gamepad');
        yield TextField::new('nom_partie');
        yield BooleanField::new('active');
        yield IntegerField::new('nb_equipes');
        yield BooleanField::new('pause');
        yield IntegerField::new('periode');
        yield TextField::new('phase');
        yield TextField::new('time_next');

        yield FormField::addPanel('Paramétrage')->setIcon('fa fa-tools');
        yield IntegerField::new('nb_jours_mois');
        yield MoneyField::new('init_actif_dispo')->setCurrency('EUR')->setStoredAsCents(false);
        yield MoneyField::new('init_tresorerie_decaissement')->setCurrency('EUR')->setStoredAsCents(false);
        yield MoneyField::new('init_actif_materiel')->setCurrency('EUR')->setStoredAsCents(false);
        yield MoneyField::new('montant_impot')->setCurrency('EUR')->setStoredAsCents(false);
        yield MoneyField::new('location_materiel')->setCurrency('EUR')->setStoredAsCents(false);
        yield IntegerField::new('init_materiel');

        yield NumberField::new('coeff_charges_patronales');
        yield NumberField::new('coeff_charges_salariales');
        yield NumberField::new('coeff_electricite');
        yield NumberField::new('coeff_telephonie');
        yield NumberField::new('coeff_deplacement');
        yield NumberField::new('coeff_autre');
        yield NumberField::new('taux_decouvert');
        yield NumberField::new('taux_interet');

        yield MoneyField::new('penalite_machine')->setCurrency('EUR')->setStoredAsCents(false);
        yield MoneyField::new('penalite_surface')->setCurrency('EUR')->setStoredAsCents(false);


    }
}
