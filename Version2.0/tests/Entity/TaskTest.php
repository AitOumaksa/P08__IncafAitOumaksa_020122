<?php


namespace Tests\AppBundle\Entity;


use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskTest extends WebTestCase
{

    public function testGetId()
    {
        $user = new Task();
        $this->assertNull($user->getId());
    }

    public function testGetSetTitle()
    {
        $task = new Task();
        $task->setTitle('Test title');
        $this->assertEquals($task->getTitle(), 'Test title');
    }

    public function testGetSetContent()
    {
        $task = new Task();
        $task->setContent('Test content');
        $this->assertEquals($task->getContent(), 'Test content');
    }

    public function testGetSetCreatedAt()
    {
        $task = new Task();
        $task->setCreatedAt(new \DateTime);
        $this->assertInstanceOf(\DateTime::class, $task->getCreatedAt());
    }

    public function testGetSetUser()
    {
        $task = new Task();
        $task->setUser(new User);
        $this->assertInstanceOf(User::class, $task->getUser());
    }
    public function testIsDone()
    {
        $task = new Task();
        $this->assertFalse($task->isDone());  
        $task->setIsDone(true);
        $this->assertTrue($task->isDone());
    }

    public function testToggle()
    {
        $task = new Task();
        $this->assertFalse($task->isDone());
        
        $task->toggle(true);
        $this->assertTrue($task->isDone());
        
        $task->toggle(false);
        $this->assertFalse($task->isDone());
    }

    public function testGetSetIsDone()
    {
        $task = new Task();
        $task->setIsDone(false);
        $this->assertFalse($task->getIsDone());

        $task->setIsDone(true);
        $this->assertTrue($task->getIsDone());
    }
    
}