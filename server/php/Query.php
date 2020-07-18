<?php

class Query {
  private $_query = '';
  private $_select = '';
  private $_from = '';
  private $_where = '';
  private $_orderBy = '';
  private $_order = '';
  private $_limit = '';
  private $_join = '';
  private $_groupBy = '';

  const FIELDS_OR_TABLES_SEPARATOR = ', ';
  const CONDITIONS_SEPARATOR = ' AND ';

  static private function _joinIfArray(string $separator, $array) {
    return (is_array($array)) ? join($separator, $array) : $array;
  }

  static private function _joinFieldsOrTablesIfArray($fieldsOrTables) {
    return self::_joinIfArray(self::FIELDS_OR_TABLES_SEPARATOR, $fieldsOrTables);
  }

  static private function _joinConditionsIfArray($conditions) {
    return self::_joinIfArray(self::CONDITIONS_SEPARATOR, $conditions);
  }

  static private function _joinTableAndField(string $table, string $field): string {
    return $table . '.' . $field;
  }

  static function as(string $field, string $as): string {
    return $field . ' AS ' . $as;
  }

  static function equalTo(string $field, string $to): string {
    return $field . ' = ' . $to;
  }

  static function equalToString(string $field, string $to): string {
    return $field . ' = \'' . $to . '\'';
  }

  static function count(string $field = "*"): string {
    return "COUNT($field)";
  }

  static function like($field, $like): string {
    return "$field LIKE '$like'";
  }

  static function between(string $field, string $a, string $b): string {
    return "$field BETWEEN " . self::_joinConditionsIfArray([$a, $b]);
  }

  static function field(string $table, $fields): string {
    if (!is_array($fields)) return self::_joinTableAndField($table, $fields);
    
    $result = [];

    foreach ($fields as $field) {
      $result[] = self::_joinTableAndField($table, $field);
    }

    return self::_joinFieldsOrTablesIfArray($result);
  }

  function select($fields = '*'): Query {
    $this->_select = 'SELECT ' . $this->_joinFieldsOrTablesIfArray($fields);

    return $this;
  }

  function from($tables): Query {
    $this->_from = 'FROM ' . $this->_joinFieldsOrTablesIfArray($tables);

    return $this;
  }

  function where($conditions): Query {
    $this->_where = 'WHERE ' .  $this->_joinConditionsIfArray($conditions);

    return $this;
  }

  function orderBy($fields): Query {
    $this->_orderBy = 'ORDER BY ' . $this->_joinIfArray(self::FIELDS_OR_TABLES_SEPARATOR, $fields);

    return $this;
  }

  function asc(): Query {
    $this->_order = 'ASC';
    
    return $this;
  }

  function desc(): Query {
    $this->_order = 'DESC';
    
    return $this;
  }

  function limit(int $limit): Query {
    $this->_limit = 'LIMIT ' . $limit;

    return $this;
  }

  function leftJoin($table, $on): Query {
    $this->_join = 'LEFT JOIN ' . $this->_joinFieldsOrTablesIfArray($table) . ' ON ' . $this->_joinConditionsIfArray($on);

    return $this;
  }

  function groupBy($field): Query {
    $this->_groupBy = 'GROUP BY ' . $this->_joinFieldsOrTablesIfArray($field);

    return $this;
  }

  static private function _joinQueryParts(array $queryParts): string {
    $parts = [];

    foreach ($queryParts as $queryPart) {
      if (!empty($queryPart)) {
        $parts[] = $queryPart;
      }
    }

    return join(' ', $parts);
  }

  function build(): string {
    if (!isset($this->_select)) throw Exception('select not set');
    if (!isset($this->_from)) throw Exception('from not set');
    if (isset($this->_order) && !isset($this->_orderBy)) throw Exception('orderBy not set');

    return self::_joinQueryParts([
      $this->_select, 
      $this->_from, 
      $this->_join, 
      $this->_where, 
      $this->_groupBy, 
      $this->_orderBy,
      $this->_order, 
      $this->_limit
    ]);
  }

  public function __toString() {
    return $this->build();
  }
}