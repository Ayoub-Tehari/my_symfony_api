<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Song;
use Faker\Generator;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private Generator $faker;
    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        // $song = new Product();
        // $manager->persist($product);
        // $today = new \DateTime("now", $paris_timezone);
        for ($i = 0; $i < 100; $i++) {
            $createdAt = $this->faker->dateTime();
            $updatedAt = $this->faker->dateTimeBetween($createdAt, "now");
            $song = new Song();
            $song->
                setName($this->faker->word())->
                setStatus("on")->
                setCreatedAt($createdAt)->
                setUpdatedAt($updatedAt);

            $manager->persist($song);
        }



        $manager->flush();
    }
}
