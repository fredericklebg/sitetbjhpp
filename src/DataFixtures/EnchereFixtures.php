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
                    ->setDescriptif($faker->title())
                    ->setPrix($faker->numberBetween(2.5,200))
                    ->setImage($faker->imageUrl(150, 150));

            $manager->persist($produit);

            for($j = 1; $j <= mt_rand(3, 6); $j++){
                $enchere = new Enchere();
                $enchere->setProduit($produit)
                    ->setDateDebut(new \DateTime())
                    ->setDateFin($faker->dateTimeBetween('now', '2 days'));

                $manager->persist($enchere);
            }
        }

        $manager->flush();
    }
}
