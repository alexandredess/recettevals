<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Ingredient;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct(){
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
        for( $i = 0; $i < 50; $i++ ) {
        $ingredient =new Ingredient();
        //le nom va prendre ingredien + le numéro de l'index
        $ingredient ->setName($this->faker->word())
        //on un random pour le prix entre 0 et 100
                    ->setPrice(mt_rand(0,100));
        $manager->persist($ingredient);
        }
        $manager->flush();
    }
}
