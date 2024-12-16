<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Posts;
use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PostsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $categ = [];
        for ($i = 0; $i < 10; $i++) {
            $categ = new Categories();
            $categ->setTitle($faker->words(1, true));           
            $manager->persist($categ);
            $categs[] = $categ;            
        }

        for ($i = 0; $i < 200; $i++) {
            $post = new Posts();
            $post
            ->setTitle($faker->words(3, true))
            ->setContent($faker->paragraphs(3 , true))
            ->setState(mt_rand(0,2) === 1 ? Posts::STATES[0]: Posts::STATES[1])
            ->setCategory($categs[array_rand($categs)]);
            
            $manager->persist($post);
        }

        $manager->flush();
    }
}
