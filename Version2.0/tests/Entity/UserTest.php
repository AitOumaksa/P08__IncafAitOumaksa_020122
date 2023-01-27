<?php


namespace Tests\App\Entity;


use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{

    private $user;
    private $task;

    public function setUp(): void
    {
        $this->user = new User();
        $this->task = new Task();
    }

    public function testGetId()
    {
        $user = new User();
        $this->assertNull($user->getId());
    }

    public function testGetSetUsername()
    {
        $this->user->setUsername('Test username');
        $this->assertEquals($this->user->getUsername(), 'Test username');
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

       public function testTask()
    {
        $this->user->addTask($this->task);
        $this->assertCount(1, $this->user->getTasks());

        $tasks = $this->user->getTasks();
        $this->assertSame($this->user->getTasks(), $tasks);

        $this->user->removeTask($this->task);
        $this->assertCount(0, $this->user->getTasks());
    }

    public function testGetSetRoles()
    {
        $user = new User();
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $this->assertEquals(['ROLE_USER', 'ROLE_ADMIN'], $user->getRoles());
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

    public function testAddRole()
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $user->addRole('ROLE_ADMIN');
        $this->assertContains('ROLE_ADMIN', $user->getRoles());
    }

}
