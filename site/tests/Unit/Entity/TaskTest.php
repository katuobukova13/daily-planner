<?php

namespace App\Tests\Unit\Entity;
use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testTaskRelations()
    {
        $user = new User();
        $task = new Task();
        $file = 'task_file.doc';
        $description = 'Task description';
        $date = new \DateTime('2023-06-26');

        // Set task properties
        $task->setUser($user);
        $task->setFile($file);
        $task->setDescription($description);
        $task->setDate($date);

        // Check task relations and properties
        $this->assertEquals($user, $task->getUser());
        $this->assertEquals($file, $task->getFile());
        $this->assertEquals($description, $task->getDescription());
        $this->assertEquals($date, $task->getDate());
    }
}
