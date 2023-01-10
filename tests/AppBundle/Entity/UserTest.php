<?php


namespace Tests\AppBundle\Entity;


use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{

    public function testGetId()
    {
        $user = new User();
        $this->assertNull($user->getId());
    }

    public function testGetSetUsername()
    {
        $user = new User();
        $user->setUsername('Test username');
        $this->assertEquals($user->getUsername(), 'Test username');
    }

    public function testGetSetPassword()
    {
        $user = new User();
        $user->setPassword('Test password');
        $this->assertEquals($user->getPassword(), 'Test password');
    }

    public function testGetSetEmail()
    {
        $user = new User();
        $user->setEmail('Test@email.com');
        $this->assertEquals($user->getEmail(), 'Test@email.com');
    }

    public function testGetSalt()
    {
        $user = new User();
        $this->assertNull($user->getSalt());
    }

    public function testEraseCredentials()
    {
        $user = new User();
        $this->assertNull($user->eraseCredentials());
    }

    public function testAddTask()
    {
        $user = new User();
        $task = new Task();
        $user->addTask($task);
        $this->assertCount(1, $user->getTasks());
        $this->assertContains($task, $user->getTasks());
    }

    public function testRemoveTask()
    {
        $user = new User();
        $task = new Task();
        $user->addTask($task);
        $this->assertContains($task, $user->getTasks());
        $user->removeTask($task);
        $this->assertNotContains($task, $user->getTasks());
    }

    public function testGetRoles()
    {
        $user = new User();
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
    }

    public function testGetTasks()
    {
        $user = new User();
        $task1 = new Task();
        $task2 = new Task();
        $user->addTask($task1);
        $user->addTask($task2);
        $tasks = $user->getTasks();
        $this->assertCount(2, $tasks);
        $this->assertSame($task1, $tasks[0]);
        $this->assertSame($task2, $tasks[1]);
    }

}
