<?php

require_once('./php/Session.php');

class Flash {
  private $_session;

  function __construct() {
    $this->_session = Session::getInstance();
  }

  function setMessage(string $msg) {
    $this->_session->msg = $msg;
  }

  function getMessage(string $msg) {
    return $this->_session->msg;
  }
}