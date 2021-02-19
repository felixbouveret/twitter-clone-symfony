<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\User;
use App\Entity\Tweets;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    // ...
    public function load(ObjectManager $manager)
    {

        /** User : Simon */
        $user = new User();
        $user->setUsername('Simon');
        $user->setEmail('simon@simon.fr');

        $password = $this->encoder->encodePassword($user, 'admin123');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();

        /** User : Admin */
        $userAdmin = new User();
        $userAdmin->setUsername('Admin');
        $userAdmin->setEmail('admin@simon.fr');

        $passwordAdmin = $this->encoder->encodePassword($userAdmin, 'admin123');
        $userAdmin->setPassword($passwordAdmin);

        $manager->persist($userAdmin);
        $manager->flush();

    }
}
