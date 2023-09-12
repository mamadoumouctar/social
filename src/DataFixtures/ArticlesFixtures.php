<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArticlesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 50; $i++){
            $article = (new Article())
                ->setTitle($faker->name)
                ->setContenue($faker->text(maxNbChars: 900))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTime))
                ->setUpdatedAt(\DateTimeImmutable::createFromMutable($faker->dateTime))
            ;
            $manager->persist($article);
        }
        $manager->flush();
    }
}
