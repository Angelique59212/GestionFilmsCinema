<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use App\Entity\Room;
use App\Entity\Schedule;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();
        $rooms = [];
        $schedules = [];
        $movies = [];

        for ($i = 0; $i < 10; $i++){
            $movies[$i] = new Movie();
            $movies[$i]->setTitle($faker->sentence());
            $movies[$i]->setProducer($faker->sentence());
            $movies[$i]->setDuration($faker->randomDigit());

            $manager->persist($movies[$i]);
        }

        for ($i = 0; $i < 10; $i++){
            $schedules[$i] = new Schedule();
            $schedules[$i]->setDate($faker->dateTime());
            $schedules[$i]->setMovie($movies[array_rand($movies)]);

            $manager->persist($schedules[$i]);
        }

        for ($i = 0; $i < 10; $i++){
            $rooms[$i] = new Room();
            $rooms[$i]->setName($faker->firstName());
            $rooms[$i]->setCapacity($faker->randomDigit());
            $rooms[$i]->setLocation($faker->address());
            $rooms[$i]->setMovie($movies[array_rand($movies)]);

            $manager->persist($rooms[$i]);
        }

        $manager->flush();
    }
}
