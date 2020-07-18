<?php

class DBManager {
  private $_hostname;
  private $_username;
  private $_password;
  private $_dbname;
  private $_connection;
  private $_lastAddedId;
  private $_lastAddedTable;
  private $_lastQuery;
  private $_error;

  function __construct(string $dbname, string $username = 'root', string $password = '', string $hostname = 'localhost') {
    $this->_hostname = $hostname;
    $this->_username = $username;
    $this->_password = $password;
    $this->_dbname = $dbname;
    $this->_connection = $this->_connect();

    $this->setCharset('utf8');
  }

  function __destruct() {
    mysqli_close($this->_connection);
  }

  function getConnection() {
    return $connection;
  }

  function setCharset(string $charset): void {
    mysqli_set_charset($this->_connection, $charset);
  }

  private function _connect() {
    $connection = mysqli_connect($this->_hostname, $this->_username, $this->_password, $this->_dbname);

    if (!$connection) {
      throw new Error(mysqli_connect_error());
    }

    return $connection;
  }

  function getError() {
    return $this->_error;
  }

  function hasError() {
    return isset($this->_error);
  }

  function query($query) {
    $result = mysqli_query($this->_connection, $query);

    $this->_lastQuery = $query;
    $this->_error = ($result) ? null : mysqli_error($this->_connection);

    return $result;
  }

  function getLastQuery() {
    return $this->_lastQuery;
  }

  function createPutQuery(string $table, array $data): string {
    $fields = [];
    $values = [];

    foreach ($data as $field => $value) {
      $fields[] = $field;
      $values[] = (is_null($value)) ? 'NULL' : "'$value'";
    }

    $result = "INSERT INTO $table (" . join(', ', $fields) . ") VALUES (" . join(', ', $values) . ")";

    return $result;
  }

  function createDeleteQuery(string $table, $conditions = ''): string {
    return "DELETE FROM $table" . $this->createCondition($conditions);
  }

  function createCondition($conditions) {
    if (empty($conditions)) return '';

    return " WHERE " . (is_array($conditions) ? join(' AND ', $conditions) : $conditions);
  }

  function createOrder(array $order): string {
    if (isset($order['fields']) && empty($order['fields'])) return '';

    $result = ' ORDER BY ' . (is_array($order['fields']) ? join(', ', $order['fields']) : $order['fields']);
    
    if (isset($order['order']) && !empty($order['order'])) {
      $result .= ' ' . $order['order'];
    }

    return $result;
  }

  function createGetQuery($table, $fields = '*', $conditions = '', array $order): string {
    $result = "SELECT " . (is_array($fields) ? join(", ", $fields) : $fields);
    $result .= " FROM " . (is_array($table) ? join(", ", $table) : $table); 
    $result .= $this->createCondition($conditions);
    $result .= $this->createOrder($order);
    
    return $result;
  }

  function createEditQuery(string $table, $conditions, array $fieldsAndValues): string {
    return "UPDATE $table" . $this->createSet($fieldsAndValues) . $this->createCondition($conditions);
  }

  function createSet(array $fieldsAndValues) {
    $result = [];

    foreach ($fieldsAndValues as $field => $value) {
      $result[] = "$field = " . (is_null($value) ? 'NULL' : "'$value'");
    }

    $result = " SET " . join(', ', $result);

    return $result;
  }

  function extractDataFromResult($queryResult): array {
    $result = ($queryResult) ? mysqli_fetch_all($queryResult, 1) : [];

    return $result;
  }

  function get($table, $conditions = '', $fields = '*', array $order = ['fields' => [], 'order' => '']) {
    $query = $this->createGetQuery($table, $fields, $conditions, $order);
    $result = $this->query($query);
    $data = ($result) ? $this->extractDataFromResult($result) : NULL;
    
    return $data;
  }

  function getLastAdded($nameOfAutoIncrementField = 'id') {
    if (isset($this->_lastAddedId)) {
      $last = $this->get($this->_lastAddedTable, "*", "$nameOfAutoIncrementField = {$this->_lastAddedId}");

      return $last;
    }

    return NULL;
  }

  private function updateLastAddedId(string $table) {
    $this->_lastAddedId = mysqli_insert_id($this->_connection);
    $this->_lastAddedTable = $table;
  }

  function put($table, $data) {
    $query = $this->createPutQuery($table, $data);
    $result = $this->query($query);

    if ($result) {
      $this->updateLastAddedId($table);
    }

    return $result;
  }

  function delete($table, $conditions = '') {
    $query = $this->createDeleteQuery($table, $conditions);
    $result = $this->query($query);

    return $result;
  }

  function edit($table, $conditions, $fieldsAndValues) {
    $query = $this->createEditQuery($table, $conditions, $fieldsAndValues);
    $result = $this->query($query);

    return $result;
  }

  function safeFromMysql($str) {
    return (is_string($str) ? mysqli_real_escape_string($this->_connection, $str) : $str);
  }

  function safeFromHtml($str) {
    return (is_string($str) ? htmlspecialchars($str) : $str); 
  }

  function makeSafe($str) {
    return $this->safeFromHtml($this->safeFromHtml($str));
  }

  function clearTable($table) {
    $query = $this->createDeleteQuery($table);
    $result = $this->query($query);

    return $result;
  }
}