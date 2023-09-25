<?php

namespace Dhenfie\EventDispatcher;

interface EventListenerInterface
{
    public function handler(array $params): void;
}