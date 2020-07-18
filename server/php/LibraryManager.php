<?php

require_once('./php/DBManager.php');

class LibraryManager extends DBManager {
  const AUTHORS_TABLE = 'authors';
  const BOOKS_TABLE = 'books';
  const GENRES_TABLE = 'genres';
  const USERS_TABLE = 'users';

  const BOOKS_TABLES = [self::BOOKS_TABLE, self::GENRES_TABLE, self::AUTHORS_TABLE];
  const BOOKS_CONDITIONS = [
    self::BOOKS_TABLE . '.genre_id = ' . self::GENRES_TABLE . '.id', 
    self::BOOKS_TABLE . '.author_id = ' . self::AUTHORS_TABLE . '.id' 
  ]
  ;
  const BOOKS_FIELDS = [
    self::BOOKS_TABLE. '.id', 
    self::GENRES_TABLE. '.name',
    self::AUTHORS_TABLE . '.fullname as author',
    'title', 
    'description', 
    'year_of_writing'
  ];

  const BOOKS_ORDER = ['fields' => 'id', 'order' => 'desc'];

  function __construct(string $dbname, string $username = 'root', string $password = '', string $hostname = 'localhost') {
    parent::__construct($dbname, $username, $password, $hostname);
  }
  
  // books 
  function getBooks() {
    return $this->get(self::BOOKS_TABLES, self::BOOKS_CONDITIONS, self::BOOKS_FIELDS, ['fields' => 'id', 'order' => 'desc']);
  }

  function getBook($id) {
    $conditions = self::BOOKs_CONDITIONS;
    $conditions[] = self::BOOKS_TABLE . ".id = $id";
    
    return $this->get(self::BOOKS_TABLES, $conditions, self::BOOKS_FIELDS);
  }

  function addBook(string $title, $authorId, $genreId, $yearOfWriting, string $description) {
    return $this->put(self::BOOKS_TABLE, [
      'title' => $title,
      'author_id' => $authorId,
      'genre_id' => $genreId,
      'year_of_writing' => $yearOfWriting,
      'description' => $description
    ]);
  }

  function editBook($id, array $fieldsAndValues) {
    return $this->edit(self::BOOKS_TABLE, "id = $id", $fieldsAndValues);
  }

  function deleteBook($id) {
    return $this->delete(self::BOOKS_TABLE, "id = $id");  
  }

  function deleteAllBooks() {
    return $this->delete(self::BOOKS_TABLE);  
  }
}
  /* // authors
  function getAuthor($id) {
    return $this->get(self::AUTHORS_TABLE, "id = $id");
  }

  function editAuthor($id, $fieldsAndValues) {
    return $this->edit(self::AUTHORS_TABLE, "id = $id", $fieldsAndValues);
  }

  function addAuthor(string $fullname, $dateOfBirth, $dateOfDeath) {
    return $this->put(self::AUTHORS_TABLE, [
      'fullname' => $fullname,
      'date_of_birth' => $dateOfBirth,
      'date_of_death' => $dateOfDeath
    ]);
  }


  function deleteAuthor($id) {
    return $this->delete(self::AUTHORS_TABLE, "id = $id");
  }

  function getAuthors() {
    return $this->get(self::AUTHORS_TABLE);
  }

  // genres
  function getGenres() {
    return $this->get(self::GENRES_TABLE);
  }

  function getGenre($id) {
    return $this->get(self::GENRES_TABLE, "id = $id");
  }

  function addGenre($name) {
    return $this->put(self::GENRES_TABLE, ['name' => $name]);
  }

  function editGenre($id, $name) {
    return $this->edit(self::GENRES_TABLE, "id = $id", ['name' => $name]);
  }

  function deleteGenre($id) {
    return $this->delete(self::GENRES_TABLE, "id = $id");  
  }

  function deleteAllGenres() {
    return $this->delete(self::GENRES_TABLE);  
  }
} */