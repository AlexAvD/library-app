<?php

require_once('./libs/rb-mysql.php');
require_once('./php/Query.php');

use RedBeanPHP\OODBBean as Bean;

class LibraryManagerRB {
  const DB_NAME = 'library';
  const DB_USER = 'root';
  const DB_PASSWORD = '';
  
  const ID = 'id';

  const USER = 'user';
  const COMMENT = 'comment';

  const GENRE = 'genre';
  const GENRE_NAME = 'name';
  const GENRE_FIELDS = [self::GENRE_NAME];
  
  const AUTHOR = 'author';
  const AUTHOR_FULL_NAME = 'full_name';
  const AUTHOR_DATE_OF_BIRTH = 'date_of_birth';
  const AUTHOR_DATE_OF_DEATH = 'date_of_death';
  const AUTHOR_FIELDS = [
    self::AUTHOR_FULL_NAME, 
    self::AUTHOR_DATE_OF_BIRTH,
    self::AUTHOR_DATE_OF_DEATH
  ];
  
  const BOOK = 'book';
  const BOOK_TITLE = 'title';
  const BOOK_AUTHOR_ID = 'author_id';
  const BOOK_GENRE_ID = 'genre_id';
  const BOOK_YEAR_OF_WRITING = 'year_of_writing';
  const BOOK_DESCRIPTION = 'description';
  const BOOK_FIELDS = [
    self::BOOK_TITLE, 
    self::BOOK_AUTHOR_ID, 
    self::BOOK_GENRE_ID, 
    self::BOOK_YEAR_OF_WRITING, 
    self::BOOK_DESCRIPTION
  ];

  const FIELDS = [
    self::AUTHOR => self::AUTHOR_FIELDS,
    self::GENRE => self::GENRE_FIELDS,
    self::BOOK => self::BOOK_FIELDS
  ];

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

  function isEmptyBean(Bean $bean): bool {
    return ($bean->id === 0);
  }
  
  function getBean(string $table, $id): Bean {
    return R::load($table, $id);
  }
  
  function getOne(string $table, $id) {
    return R::getRow((new Query())->select()->from($table)->where('id = :id'), [ ':id' => $id ]);
  }

  function getAll(string $query): array {
    return R::getAll($query);
  }

  function getTableFields(string $table): array {
    return self::FIELDS[$table];
  }

  function setData(string $table, Bean $bean, array $data): Bean {
    $fields = $this->getTableFields($table);
    
    foreach ($data as $field => $value) {
      if (in_array($field, $fields)) {
        $bean[$field] = $value;
      }
    }

    return $bean;
  }

  function deleteAll(string $table) {
    return R::wipe($table);
  }

  function delete(string $table, $id) {
    $ids = is_array($id) ? $id : [$id];
    $condition = ' id IN ( ' . R::genSlots($ids) . ' ) ';

    return R::hunt($table, $condition, $ids);
  }

  function update(string $table, $id, array $data): bool {
    $bean = $this->getBean($table, $id);

    if ($this->isEmptyBean($bean)) return false;

    $this->setData($table, $bean, $data);

    try {
      $result = R::store($bean);
    } catch (Exception $e) {
      $result = 0;
    }

    return $result;
  }

  function add(string $table, array $data): int {
    $bean = R::dispense($table);
   
    $this->setData($table, $bean, $data);

    try {
      $result = R::store($bean);
    } catch (Exception $e) {
      $result = 0;
    }

    return $result;
  }
  
  /* genre */

  function addGenre(string $name): int {return $this->add(self::GENRE, [ self::GENRE_NAME => $name ]);}
  function getGenre($id) { return $this->getOne(self::GENRE, $id); }
  function getGenres(): array { return $this->getAll((new Query())->select()->from(self::GENRE)->orderBy(self::ID)); }
  function deleteGenre($id): int { return $this->delete(self::GENRE, $id); }
  function deleteAllGenres() {$this->deleteAll(self::GENRE);}
  function updateGenre($id, array $data): bool { return $this->update(self::GENRE, $id, $data); }
  function getGenresWithBookCount(): array { 
    $fields = [ Query::field(self::GENRE, [self::ID, self::GENRE_NAME]), Query::as(Query::count(Query::field(self::BOOK, self::ID)), 'book_count')];
    $genreId = Query::field(self::GENRE, self::ID);
    $bookGenreId = Query::field(self::BOOK, self::BOOK_GENRE_ID);
    $joinOn = Query::equalTo($genreId, $bookGenreId);
    $query = (new Query())->select($fields)->from(self::GENRE)->leftJoin(self::BOOK, $joinOn)->groupBy($genreId)->orderBy(self::ID);

    return $this->getAll($query); 
  }


  function addAuthor(
    string $fullName, string $dateOfBirth = null, 
    string $dateOfDeath = null
  ): int {
    return $this->add(self::AUTHOR, [
      self::AUTHOR_FULL_NAME => $fullName,
      self::AUTHOR_DATE_OF_BIRTH => $dateOfBirth, 
      self::AUTHOR_DATE_OF_DEATH => $dateOfDeath, 
    ]);
  }

  function getAuthor($id) { return $this->getOne(self::AUTHOR, $id); }
  function getAuthors(): array { return $this->getAll((new Query())->select()->from(self::AUTHOR)->orderBy(self::ID)); }
  function deleteAllAuthors() {$this->deleteAll(self::AUTHOR);}
  function deleteAuthor($id): int { return $this->delete(self::AUTHOR, $id); }
  function updateAuthor($id, array $data): bool { return $this->update(self::AUTHOR, $id, $data); }

  /* book */

  function addBook(
    string $title, $authorId, $genreId, 
    $yearOfWriting = null, $description = null
  ): int {
    return $this->add(self::BOOK, [
      self::BOOK_TITLE => $title, 
      self::BOOK_AUTHOR_ID => $authorId, 
      self::BOOK_GENRE_ID => $genreId, 
      self::BOOK_YEAR_OF_WRITING => $yearOfWriting, 
      self::BOOK_DESCRIPTION => $description,
    ]);
  }

  function getBook($id) { return $this->getOne(self::BOOK, $id); }
  function getBooks($q = null): array { 
    $tables = [self::GENRE, self::AUTHOR, self::BOOK];
    $conditions = [
      Query::equalTo(Query::field(self::BOOK, self::BOOK_GENRE_ID), Query::field(self::GENRE, self::ID)),
      Query::equalTo(Query::field(self::BOOK, self::BOOK_AUTHOR_ID), Query::field(self::AUTHOR, self::ID)),
    ];

    if (!is_null($q)) $conditions[] = Query::like(self::BOOK_TITLE, "%$q%");

    $bookField =  Query::field(self::BOOK, [self::ID, self::BOOK_TITLE, self::BOOK_DESCRIPTION, self::BOOK_YEAR_OF_WRITING]);
    $authorField = Query::as(Query::field(self::AUTHOR, self::AUTHOR_FULL_NAME), self::AUTHOR);
    $genreField = Query::as(Query::field(self::GENRE, self::GENRE_NAME), self::GENRE);

    
    $fields = [
      $bookField,
      $authorField,
      $genreField
    ];

    $query = (new Query())->select($fields)->from($tables)->where($conditions)->orderBy(self::ID);

    return $this->getAll($query); 
  }

  function getBooksInLastDecade() {
    $query = (new Query())
      ->select([self::BOOK_TITLE, self::BOOK_YEAR_OF_WRITING])
      ->from(self::BOOK)
      ->where(Query::between(self::BOOK_YEAR_OF_WRITING, date('Y') - 10, date('Y')));

    return $this->getAll($query);
  }

  function deleteBook($id): int { return $this->delete(self::BOOK, $id); }
  function deleteAllBooks() {$this->deleteAll(self::BOOK);}
  function updateBook($id, array $data): bool { return $this->update(self::BOOK, $id, $data); }
}