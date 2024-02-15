<?php

namespace App\DataFixtures;

use App\Entity\TrickCategory;
use App\Entity\Tricks;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail("test@faker.faker");

        $user->setEmail('admin@admin.lan');
        $user->setPassword('$2y$13$p1bTdU3QH6.yGRtMcDy3J.GY7k4XKWkoidkkfG/hP4syTDGD.vhjK');//mot de passe: test
        $manager->persist($user);
        $manager->flush();



        for ($i = 1; $i <= 50; $i++) {
            $faker = Faker\Factory::create();
            $trick = new Tricks();
            $trick->setName("test " . $i)
                ->setPicture("testImg" . $i)
                ->setBgImg("default.jpeg")
                ->setDescription($faker->address())
                ->setPublisher($user)
                ->setText($faker->text(50))
                ->setCategory(TrickCategory::grabs);

            $manager->persist($trick);
        }


        $manager->flush();
    }
}
