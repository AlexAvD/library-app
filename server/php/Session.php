<?php

class Session {
  private static $_instance = null;

  function __construct() {
    session_start();
  }
  
  function destroy() {
    self::$_instance = null;
    session_destroy();
    unset($_SESSION);
  }

  public function getInstance() {
    if (is_null(self::$_instance)) {
      self::$_instance = new Session();
    }

    return self::$_instance;
  }

  function __get($key) {
    if (isset($_SESSION[$key])) {
      return $_SESSION[$key];
    }
  }

  function __set($key, $value) {
    $_SESSION[$key] = $value;
  }

  function __isset($key) {
    return isset($_SESSION[$key]);
  }

  function __unset($key) {
    unset($_SESSION[$key]);
  }
}