<?php

namespace App\DataFixtures;

use App\Entity\Blogpost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder=$encoder;
    }
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        //utilisation de faker
        // use the factory to create a Faker\Generator instance
        $faker = Factory::create('fr_FR');

        //creation utilisateur
        $user = new User();
        $user->setEmail('user@test.com')
            ->setPrenom($faker->firstName())
            ->setNom($faker->lastName())
            ->setTelephone($faker->phoneNumber)
            ->setAPropos($faker->text)
            ->setInstagram('instagram');

        $password = $this->encoder->encodePassword($user,'password');
        $user->setPassword($password);
        $manager->persist($user);

        //creation de 10 blogPost
        for ($i=0 ; $i<10 ; $i++){
            $blogpost = new Blogpost();
            $blogpost->setTitre($faker->words(3, true))
                    ->setCreatedAt($faker->dateTimeBetween('-30 years','now'))
                    ->setContenu($faker->text(350))
                    ->setSlug($faker->slug(3))
                    ->setUser($user);

            $manager->persist($blogpost);

            }

        // on va d'abord creer des ficture pour les categories car les filtres sont classé par categorie
        $manager->flush();


    }
}
