<?php

namespace App\DataFixtures;

use App\Entity\Enchere;
use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use \Faker\Factory;

class EnchereFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        //Création produits
        for($i = 0 ; $i < 10 ; $i++){
            $produit = new Produit();
            $produit->setReference(strval($faker->randomNumber(8)))
                    ->setDescriptif($faker->word)
                    ->setPrix($faker->numberBetween(2.5,200))
                    ->setImage("https://placehold.it/150x150");

            $manager->persist($produit);

            $enchere = new Enchere();
            $enchere->setProduit($produit)
                ->setDateDebut(new \DateTime())
                ->setDateFin($faker->dateTimeBetween('now', '4 days'));

            $manager->persist($enchere);

        }

        $manager->flush();
    }
}
