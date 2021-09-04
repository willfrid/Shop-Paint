<?php

namespace App\DataFixtures;

use App\Entity\Blogpost;
use App\Entity\Categorie;
use App\Entity\Peinture;
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
                ->setInstagram('instagram')
                ->setRoles(['ROLE_PEINTRE']);

        $password = $this->encoder->encodePassword($user,'password');
        $user->setPassword($password);
        $manager->persist($user);

        //creation de 10 blogPost
        for ($i=0 ; $i<10 ; $i++){
            $blogpost = new Blogpost();
            $blogpost->setTitre($faker->word())
                        ->setCreatedAt($faker->dateTimeBetween('-30 years','now'))
                        ->setContenu($faker->text(350))
                        ->setSlug($faker->slug(3))
                        ->setUser($user);

            $manager->persist($blogpost);

            }

        // on va d'abord creer des ficture pour les categories car les filtres sont classé par categorie

        for ($i=0; $i<6; $i++ ){
            $categorie = new Categorie();
            $categorie->setNom($faker->word())
                        ->setDescription($faker->text(350))
                        ->setSlug($faker->slug(3));
            $manager->persist($categorie);

            //creation de deux peintures par categorie

            for($j=0;$j<2;$j++){
                $peinture = new Peinture();

                $peinture->setNom((string)$faker->words(3, true))
                            ->setLargeur($faker->randomFloat(2,20,60))
                            ->setHauteur($faker->randomFloat(2,20,60))
                            ->setEnVente($faker->randomElement([true,false]))
                            ->setDateRealisation($faker->dateTimeBetween('-6 month','now'))
                            ->setCreatedAt($faker->dateTimeBetween('-6 month','now'))
                            ->setDescription($faker->text())
                            ->setPortfolio($faker->randomElement([true,false]))
                            ->setSlug($faker->slug())
                            ->setFile('/img/tableau.jpg')
                            ->addCategorie($categorie)
                            ->setPrix($faker->randomFloat(2,100,9999))
                            ->setUser($user);
                $manager->persist($peinture);

            }
        }
        $manager->flush();


    }
}
