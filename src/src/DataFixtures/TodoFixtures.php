<?php

namespace App\DataFixtures;

use App\Entity\Todo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TodoFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i<10; $i++) {
            //set the user
            $user = new User();
            $user->setName('User ' + $i)
                ->setEmail('user@test.com' + $i);

            //set the todo
            $todo = new Todo();
            $todo->setName('This is another todo with id ' + rand($i, 510))
                ->setDescription('Lorem ipsum dolor simet')
                ->setUser($user)
                ->setStatus('pending')
                ->setPriority('Low')
                ->setCreatedDate(new \DateTime())
                ->setDueDate(null);
            $user->setTodo($todo);

            $manager->persist($todo);
            $manager->persist($user);

        }

        $manager->flush();
    }
    //php bin/console doctrine:fixtures:load
}
