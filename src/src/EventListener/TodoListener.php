<?php

namespace App\EventListener;

use App\CustomEvents\TodoEvent;
use App\Entity\Todo;
use Doctrine\ORM\Event\LifecycleEventArgs;

class TodoListener
{
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if(!$entity instanceof Todo)
            return;
    }

    public function todoOpened(TodoEvent $todoEvent)
    {
        //echo $todoEvent->getTodo()->getDescription();
    }
}
