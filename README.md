## About
This is a simple event dispatcher for PHP. It allows components of an application to communicate with each other through events without having to know anything about each other.

## Install
```bash
composer require dhenfie/event-dispatcher
```
## Usage
### # Register Listeners
A listener is something that listens to events and does something when the event occurs. To register a listener, use the `EventDispatcher::listen($eventName, $listener)` method.

A listener is a class that implements the `EventListenerInterface` interface.

Here is an example class as an event listener:
```php
<?php
// file SendToEmail.php
use Dhenfie\EventDispatcher\EventDispatcher;

class SendToEmail implements EventListenerInterface {
 
    public function handle(array $params = []) {
        // send an email to the user
        Mail::send($params['email'], $params['message']);
    }
}
```
Next, register the listener class using the `listen() method:

```php
<?php
use Dhenfie\EventDispatcher\EventDispatcher;
use SendToEmail;

// daftarkan pendengar menggunakan static method `listen`
EventDispatcher::listen('passwordRequestSend', new SendToEmail());
```

When the **passwordRequestSend** event occurs, the handle() `method` on the SendToMail object will be executed.

### Trigger Events
Trigger a specific event to occur using the `dispatch()` method.

example:
```php
<?php
use Dhenfie\EventDispatcher\EventDispatcher;

// trigger event passwordRequestSend
EventDispatcher::dispatch('passwordRequestSend');
```
The dispatch method also accepts a second parameter, which is an array that can be used to send additional information to the listener.

Example:
```php
<?php

use Dhenfie\EventDispatcher\EventDispatcher;

EventDispatcher::dispatch('passwordRequestSend', ['email' => 'example@mail.com', 'message' => 'Your password reset token we send your email']);


```