<?php

if (isset($request) && isset($request['type']) && isset($request['payload'])) {  
  $type = $request['type'];
  $data = $request['payload'];
  $id = valueOrDefault($data, 'id');
  $title = valueOrDefault($data, $library::BOOK_TITLE);
  $authorId = valueOrDefault($data, $library::BOOK_AUTHOR_ID);
  $genreId = valueOrDefault($data, $library::BOOK_GENRE_ID);
  $yearOfWriting = valueOrDefault($data, $library::BOOK_YEAR_OF_WRITING);
  $description = valueOrDefault($data, $library::BOOK_DESCRIPTION);
  
  switch ($type) {
    case ADD:
      if (empty($title)) {
        $response['errors'][$library::BOOK_TITLE] = 'not set';
      } if (empty($authorId)) {
        $response['errors'][$library::BOOK_AUTHOR_ID] = 'not set';
      } if (empty($genreId)) {
        $response['errors'][$library::BOOK_GENRE_ID] = 'not set';
      } else {
        $bookId = $library->addBook($title, $authorId, $genreId, $yearOfWriting, $description);
        $book = $library->getBook($bookId);
        
        if (!empty($book)) {
          $response['data'] = $book;
          $response['success'] = 1;
        } else {
          $response['error'] = '';
        }
      }
    break;

    case UPDATE:
      if (empty($id)) {
        $response['errors']['id'] = 'not set';
      } else {
        $bookData = [$library::BOOK_TITLE => $title];
        
        if (!empty($title)) { $bookData[$library::BOOK_TITLE] = $title; }
        if (!empty($authorId)) { $bookData[$library::BOOK_AUTHOR_ID] = $authorId; }
        if (!empty($genreId)) { $bookData[$library::BOOK_GENRE_ID] = $genreId; }
        if (!empty($yearOfWriting)) { $bookData[$library::BOOK_YEAR_OF_WRITING] = $yearOfWriting; }
        if (!empty($description)) { $bookData[$library::BOOK_DESCRIPTION] = $description; }

        $result = $library->updateBook($id, $bookData);
        
        if (!empty($result)) {
          $book = $library->getBook($id);

          $response['data'] = $book;
          $response['success'] = 1;
        } else {
          $response['error'] = '';
        }
      }

    break;

    case DELETE: 
      if (empty($id)) {
        $response['errors']['id'] = 'not set';
      } else {
        $result = $library->deleteBook($id);

        if ($result) {
          $response['success'] = 1;
        } else {
          $response['error'] = '';
        }
      }

    break;
  }
} else {
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $response['data'] = $library->getBook($id);
  } else if (isset($_GET['in-last-decade'])) {
    $response['data'] = $library->getBooksInLastDecade();
  } else {
    $response['data'] = (isset($_GET['q']) ? $library->getBooks($_GET['q']) : $library->getBooks());
  }

  $response['success'] = 1;
}



