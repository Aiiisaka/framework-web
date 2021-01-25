<?php
namespace controllers;

 /**
 * Controller TestController
 **/
class TestController extends ControllerBase{
    public function index() {
        echo "Hello World !";
    }

    public function send($message) {
        echo $message;
    }

    public function sendTo(string $message, ?string $to='World') {
        echo "To: {$to}<br>Message: {$message}";
    }
}
