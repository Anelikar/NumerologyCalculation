<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\Argon2iPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\SodiumPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder){
        $this->encoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUuid("getcourse");
        $user->setApiToken("{DD010F67-7E23-473E-B867-019CEDDF016F}");

        $user->setSalt("{FD5C7D8A-DCE5-48F7-9D11-C3ABC77E5A43}");
        $user->setPassword($this->encoder->encodePassword($user,"{FF24892C-D4E3-4042-81E7-3F81C6A5A82C}"));

        $manager->persist($user);

        $manager->flush();
    }
}