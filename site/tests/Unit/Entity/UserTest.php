<?php

namespace App\Tests\Unit\Entity;
use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testSetAndGetEmail()
    {
        $user = new User();
        $email = 'john@example.com';

        $user->setEmail($email);
        $this->assertEquals($email, $user->getEmail());
    }

    public function testPasswordVerification()
    {
        $user = new User();
        $plainPassword = 'password123';

        // Set the plain password on the user
        $user->setPassword($plainPassword);

        // Verify the password
        $this->assertTrue($user->getPassword() === $plainPassword);
    }

    public function testUserHasTasks()
    {
        $user = new User();
        $task1 = new Task();
        $task2 = new Task();

        // Associate tasks with the user
        $user->addTask($task1);
        $user->addTask($task2);

        // Check if the tasks are associated with the user
        $this->assertTrue($user->getTask()->contains($task1));
        $this->assertTrue($user->getTask()->contains($task2));
    }
}
