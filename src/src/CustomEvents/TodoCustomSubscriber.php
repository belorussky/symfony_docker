<?php

namespace App\CustomEvents;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TodoCustomSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            TodoEvent::NAME => 'todoOpened'
        ];
    }

    public function todoOpened(TodoEvent $todoEvent)
    {
        echo 'Hello from new subscriber::  ' . $todoEvent->getTodo()->getDescription();
    }
}
