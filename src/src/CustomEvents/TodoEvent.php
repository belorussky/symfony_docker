<?php

namespace App\CustomEvents;

use App\Entity\Todo;
use Symfony\Contracts\EventDispatcher\Event;

class TodoEvent extends Event
{
    public const NAME = 'todo.opened';
    protected $todo;

    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }

    public function getTodo()
    {
        return $this->todo;
    }
}
