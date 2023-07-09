<?php

namespace App\DataFixtures;

use App\Entity\TrickCategory;
use App\Entity\Tricks;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 50; $i++) {
            $faker = Faker\Factory::create();
            $trick = new Tricks();
            $trick->setName("test " . $i)
                ->setPicture("testImg" . $i)
                ->setDescription($faker->address())
                ->setPublisher($faker->name())
                ->setCategory(TrickCategory::toto);

            $manager->persist($trick);
        }


        $manager->flush();
    }
}
