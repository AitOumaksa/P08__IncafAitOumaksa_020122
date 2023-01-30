<?php


namespace Tests\App\Entity;


use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskTest extends WebTestCase
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

    public function testGetSetTitle()
    {
        $this->task->setTitle('Test title');
        $this->assertEquals($this->task->getTitle(), 'Test title');
    }

    public function testGetSetContent()
    {
        $this->task->setContent('Test content');
        $this->assertEquals($this->task->getContent(), 'Test content');
    }

    public function testGetSetCreatedAt()
    {
        $this->task->setCreatedAt(new \DateTime);
        $this->assertInstanceOf(\DateTime::class, $this->task->getCreatedAt());
    }

    public function testGetSetUser()
    {
        $this->task->setUser(new User);
        $this->assertInstanceOf(User::class, $this->task->getUser());
    }
    public function testIsDone()
    {
        $this->assertFalse($this->task->isDone());  
        $this->task->setIsDone(true);
        $this->assertTrue($this->task->isDone());
    }

    public function testToggleEntity()
    {
        $this->assertFalse($this->task->isDone());
        
        $this->task->toggle(true);
        $this->assertTrue($this->task->isDone());
        
        $this->task->toggle(false);
        $this->assertFalse($this->task->isDone());
    }

    public function testGetSetIsDone()
    {
        $this->task->setIsDone(false);
        $this->assertFalse($this->task->getIsDone());

        $this->task->setIsDone(true);
        $this->assertTrue($this->task->getIsDone());
    }
    
}