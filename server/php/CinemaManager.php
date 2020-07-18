<?php

require_once('./libs/rb-mysql.php');

class CinemaManager {
  const DB_NAME = 'cinema';
  const DB_USER = 'root';
  const DB_PASSWORD = '';

  const PRODUCER = 'producer';
  const PERFORMER = 'performer';

  static private $_instance = null;

  function __construct() {
    R::setup('mysql:host=localhost;dbname=' . self::DB_NAME, self::DB_USER, self::DB_PASSWORD);

    if (!R::testConnection()) exit('Failed to connect to database');
  }

  function __destruct() { $this->destroy(); }

  static function destroy() {
    R::close();
    self::$_instance = null;
  }

  static function getInstance() {
    if (is_null(self::$_instance)) {
      self::$_instance = new self;
    }

    return self::$_instance;
  }

  static function clear() { R::nuke(); }

  function addProducer(
    $fullName, $yearOfBirth = null, 
    $cityOfBirth = null, $addressOfResidence = null
  ) {
    $producer = $this->_createProducerOrPerformer(
      self::PRODUCER, $fullName, $yearOfBirth, $cityOfBirth, $addressOfResidence
    );

    return R::store($producer);
  }

  function addPerformer(
    $fullName, $producer = null, $yearOfBirth = null, 
    $cityOfBirth = null, $addressOfResidence = null
    ) {
      $performer = $this->_createProducerOrPerformer(
        self::PERFORMER, $fullName, $yearOfBirth, $cityOfBirth, $addressOfResidence
      );
      
      if (is_int($producer)) {
        $performer->producer_id = $producer;
      } else if ($producer instanceof RedBeanPHP\OODBBean) {
        $performer->producer = $producer;
      }
      
      return R::store($performer);
    }
    
  private function _createProducerOrPerformer(
    $producerOrPerformer, $fullName, $yearOfBirth = null, 
    $cityOfBirth = null, $addressOfResidence = null
  ) {
    if (
      $producerOrPerformer !== self::PRODUCER && 
      $producerOrPerformer !== self::PERFORMER
    ) return null;
    
    $result = R::dispense($producerOrPerformer);
    
    $result->fullName = $fullName; 
    $result->yearOfBirth = $yearOfBirth;
    $result->cityOfBirth = $cityOfBirth;
    $result->addressOfResidence = $addressOfResidence;
    
    return $result;
  }

  function getPerformersOfProducer(int $producerId) {
    return R::getAll("SELECT *  FROM performer WHERE producer_id = $producerId");
  }

  function getProducerWithOwnPerformers($producerId) {
    $performer = $this->getProducer($producerId);
    
    if ($performer->id !== 0) $performer->ownPerformerList;

    return $performer;
  }

  function getProducer(int $id) { return R::load(self::PRODUCER, $id); }
  function getPerformer(int $id) { return R::load(self::PERFORMER, $id); }
}