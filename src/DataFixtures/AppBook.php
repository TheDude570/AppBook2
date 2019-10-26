<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppBook extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();


        // Creation des catégories

        for ($c = 0; $c < 5; $c++) {

            $category = new Category();

            $category->setTitle($faker->sentence(1))
                ->setDescription($faker->paragraph(3));

            $manager->persist($category);

            // Création des auteur

            for ($a = 0; $a < 5; $a++) {

                $auteur = new Author();

                $auteur->setFirstName($faker->firstName())
                    ->setLastName($faker->lastName())
                    ->setProfile($faker->paragraph(3))
                    ->setCategory($category);

                $manager->persist($auteur);

                // Création de book


                for ($b = 0; $b < 5; $b++) {

                    $book = new Book();

                    $book->setTitle($faker->sentence(3))
                        ->setImage($faker->imageUrl($height = 150, $weight = 100))
                        ->setShortDescription($faker->paragraph(1))
                        ->setLongDescription($faker->paragraph(6))
                        ->setIsbn10($faker->isbn10())
                        ->setIsbn13($faker->isbn13())
                        ->setAuthor($auteur);

                    $manager->persist($book);
                }
            }
        }

        $manager->flush();
    }
}
