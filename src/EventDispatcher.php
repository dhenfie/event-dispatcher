<?php

namespace Dhenfie\EventDispatcher;

class EventDispatcher
{

    /**
     * @var array $events
     */
    private array $events = [];

    /**
     * @var array $listener
     */
    private array $listener;

    /**
     * Singleton Instance
     * @var EventDispatcher $singleton
     */
    private static self $singleton;

    public function __construct()
    {
        self::$singleton = $this;
    }

    private static function singleton() : EventDispatcher|static
    {
        if (! isset(self::$singleton)) {
            self::$singleton = new self();
        }
        return self::$singleton;
    }

    private function hasEvent(string $eventName) : bool
    {
        return in_array($eventName, $this->events);
    }

    private function addEvent(string $eventName, EventListenerInterface $listeners) : void
    {
        if (! $this->hasEvent($eventName)) {
            $this->events[] = $eventName;
        }

        if ($this->hasEvent($eventName)) {
            $this->listener[$eventName][] = $listeners;
        }
    }

    public static function listen(string $eventName, EventListenerInterface $listener) : EventDispatcher|static
    {
        $instance = self::singleton();

        // add listener
        $instance->addEvent($eventName, $listener);

        return $instance;
    }

    public static function dispatch(string $eventName, array $params = []) : void
    {
        if (self::singleton()->hasEvent($eventName)) {
            $listener = self::singleton()->getListeners($eventName);

            foreach ($listener as $instance) {
                $instance->handler($params);
            }
        }
    }

    public function getEvents() : array
    {
        return $this->events;
    }

    public function getListeners(string $event = null) : array
    {
        if ($event) {
            return $this->listener[$event];
        }
        return $this->listener;
    }
}