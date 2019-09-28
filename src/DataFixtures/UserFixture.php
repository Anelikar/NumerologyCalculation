<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\Argon2iPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\SodiumPasswordEncoder;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUuid("getcourse");
        $user->setApiToken("{DD010F67-7E23-473E-B867-019CEDDF016F}");

        $user->setSalt("{FD5C7D8A-DCE5-48F7-9D11-C3ABC77E5A43}");
        $encoder = new SodiumPasswordEncoder();
        $user->setPassword($encoder->encodePassword("{FF24892C-D4E3-4042-81E7-3F81C6A5A82C}", $user->getSalt()));

        $manager->persist($user);

        $manager->flush();
    }
}