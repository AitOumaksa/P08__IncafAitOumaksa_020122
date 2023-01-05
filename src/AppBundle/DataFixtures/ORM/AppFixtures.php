<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class AppFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // USER FIXTURE
        $user = [
            1 => [
                'email' => 'admin@bilmo.com',
                'password' => 'password',
                'name' => 'Willis',
            ],
            2 => [
                'email' => 'admin2@bilmo.com',
                'password' => 'password',
                'name' => 'Willis',
            ],
            3 => [
                'email' => 'admin3@bilmo.com',
                'password' => 'password',
                'userName' => 'Willis',
            ]
        ];
        
        foreach ($user as $value) {
            $user = new User();
            $user->setEmail($value['email']);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $value['password']));
            $user->setUsername($value['name']);
            $manager->persist($user);
        }
        $manager->flush();
    }

}