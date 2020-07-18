<?php
// $library::clear();

/* 2 */
// $library->addBook('new book 1', 1, 2);
// $library->addBook('new book 2', 2, 1);

/* 3 */
$library->deleteBook(25);
$library->deleteBook(26);

$response['author'] = $library->getAuthor(1);
$response['genre'] = $library->getGenre(1);

