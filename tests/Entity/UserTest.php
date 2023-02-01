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
        $this->assertNull($this->user->getId());
    }

    public function testGetSetUsername()
    {
        $this->user->setUsername('Test username');
        $this->assertEquals($this->user->getUsername(), 'Test username');
    }

    public function testGetSetPassword()
    {
        $this->user->setPassword('Test password');
        $this->assertEquals($this->user->getPassword(), 'Test password');
    }

    public function testGetSetEmail()
    {
        $this->user->setEmail('Test@email.com');
        $this->assertEquals($this->user->getEmail(), 'Test@email.com');
    }

    public function testGetSalt()
    {
        $this->assertNull($this->user->getSalt());
    }

    public function testEraseCredentials()
    {
        $this->assertNull($this->user->eraseCredentials());
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
        $this->user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $this->assertEquals(['ROLE_USER', 'ROLE_ADMIN'], $this->user->getRoles());
    }


}
