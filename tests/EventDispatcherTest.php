<?php

namespace Test;

use Dhenfie\Accessible\Accessible;
use Dhenfie\EventDispatcher\EventDispatcher;
use Dhenfie\EventDispatcher\EventListenerInterface;
use PHPUnit\Framework\TestCase;

class EventDispatcherTest extends TestCase
{

    public function test_singleton()
    {
        $eventDispatcher = new EventDispatcher();
        $singleton = Accessible::inspect($eventDispatcher)->singleton();

        self::assertInstanceOf($eventDispatcher::class, $singleton);
    }

    public function test_event_created()
    {
        $eventDispatcher = new EventDispatcher();

        Accessible::inspect($eventDispatcher)->addEvent('mounted', new class implements EventListenerInterface {
            public function handler(array $params): void
            {
            }
        });

        Accessible::inspect($eventDispatcher)->addEvent('mounted', new class implements EventListenerInterface {
            public function handler(array $params): void
            {
            }
        });

        self::assertCount(1, $eventDispatcher->getEvents());
        self::assertCount(2, $eventDispatcher->getListeners('mounted'));
    }

    public function test_dispatcher()
    {
        self::expectOutputString('hello worldhello world');

        EventDispatcher::listen('mounted', new class implements EventListenerInterface {

            public function handler(array $params): void
            {
                echo $params['message'];
            }
        });

        EventDispatcher::listen('mounted', new class implements EventListenerInterface {

            public function handler(array $params): void
            {
                echo $params['message'];
            }
        });

        EventDispatcher::dispatch('mounted', ['message' => 'hello world']);
    }
}
