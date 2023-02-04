<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = [
            1 => [
                'email' => 'admin43@bilmo.com',
                'role' => 'ROLE_ADMIN',
                'password' => 'password',
                'username' => 'Willis7',
            ],
            2 => [
                'email' => 'admin233@bilmo.com',
                'role' => 'ROLE_USER',
                'password' => 'password',
                'username' => 'Willis6',
            ],
            3 => [
                'email' => 'admin3333@bilmo.com',
                'role' => 'ROLE_USER',
                'password' => 'password',
                'username' => 'Willis5',
            ]
        ];

        foreach ($user as $value) {
            $user = new User();
            $user->setEmail($value['email']);
            $user->setRoles(array($value['role']));
            $user->setPassword($this->userPasswordHasher->hashPassword($user, $value['password']));
            $user->setUsername($value['username']);
            $manager->persist($user);
        }
        $task = [
            1 => [
                'title' => 'task1',
                'content' => 'Allez a la salle'
            ],
            2 => [
                'title' => 'task2',
                'content' => 'Allez a la salle'
            ],
            3 => [
                'title' => 'task3',
                'content' => 'Allez a la salle'
            ],
            4 => [
                'title' => 'task14',
                'content' => 'Allez a la salle'
            ],
            5 => [
                'title' => 'task16',
                'content' => 'Allez a la salle'
            ],
        ];

        foreach ($task as $value) {
            $task = new Task();
            $task->setUser($user);
            $task->setTitle($value['title']);
            $task->setContent($value['content']);
            $task->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($task);
        }

        $manager->flush();
    }
}
