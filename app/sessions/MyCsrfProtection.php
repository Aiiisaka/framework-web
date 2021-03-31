<?php

namespace sessions;

class MyCsrfProtection implements VerifySessionCsrfInterface {
   private AbstractSession $sessionInstance;

   public function __construct(AbstractSession $sessionInstance) {
      $this->sessionInstance = $sessionInstance;
   }

   public function init() {
      //TODO when the session starts
   }

   public function clear() {
      //TODO when the session ends
   }

   public function start() {
      //TODO When the session starts or is resumed
   }

   public static function getLevel() {
      return 1; //An integer to appreciate the level of security
   }
}