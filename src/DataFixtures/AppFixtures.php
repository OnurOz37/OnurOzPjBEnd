<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Offers;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Prophecy\Comparator\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{

    /**
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = \Faker\Factory::create();
        $width = 640;
        $height = 480;

        $offers = [];
        $companies = [];
//        $users = [];
//
//
//        for ($u = 0 ; $u < 10 ; $u++)
//        {
//
//            $user = new User();
//            $user->setFirstname($faker->firstName)
//                ->setLastname($faker->name)
//                ->setEmail($faker->email)
//                ->setLogin($faker->userName)
//                ->setPassword($this->passwordHasher->hashPassword($user, 'Test1234'));
//
//            $users[]=$user;
//            $manager->persist($user);
//        }


        for($c=0; $c<10; $c++)
        {
            $company = new Company();
            $user = new User();
            $user->setFirstname($faker->firstName)
                ->setLastname($faker->name)
                ->setEmail($faker->email)
                ->setLogin($faker->userName)
                ->setPassword($this->passwordHasher->hashPassword($user, 'Test1234'));

            $company->setName($faker->company)
                ->setWebsite($faker->domainName)
                ->setCity($faker->city)
                ->setLogo($faker->imageUrl($width, $height, category: 'cats', randomize: true))
                ->setLogoColor($faker->rgbCssColor)
                ->setPhone(0101010101)
                ->setFkUser($user);
                //->addFkUser($users[random_int(0, count($users)-1)]);

            $user->setCompany($company);



            $companies[] = $company;


            $manager->persist($company);

        }

        for ($i = 0; $i<10; $i++)
        {
            $offer = new Offers();
            $offer->setTitle($faker->realText(10,2));
            $offer->setDescription($faker->realText(50,5));
            $offer->setRequirementsContent($faker->realText(50,5));
            $offer->setRequirementsItem($faker->realText(50,5));
            $offer->setRoleContent($faker->realText(50,5));
            $offer->setRoleItem($faker->realText(50,5));
            $offer->setType($faker->realText(10,5));
            $offer->setWebsite($faker->domainName);
            $offer->setPostedAt(\DateTimeImmutable::createFromMutable(($faker->dateTimeBetween('-1 year', 'now'))));
            $offer->setFkCompany($companies[random_int(0, count($companies)-1)]);

            $manager->persist($offer);


        }






        $manager->flush();
    }
}
