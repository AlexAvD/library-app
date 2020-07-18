<?php

if (isset($request) && isset($request['type']) && isset($request['payload'])) {  
  $type = $request['type'];
  $data = $request['payload'];
  $id = valueOrDefault($data, 'id');
  $name = valueOrDefault($data, $library::GENRE_NAME);

  switch ($type) {
    case ADD:
      if (empty($name)) {
        $response['errors'][$library::GENRE_NAME] = 'not set';
      } else {
        $genreId = $library->addGenre($name);
        $genre = $library->getGenre($genreId);
        
        if (!empty($genre)) {
          $response['data'] = $genre;
          $response['success'] = 1;
        } else {
          $response['error'] = '';
        }
      }
    break;

    case UPDATE:
      if (empty($id)) {
        $response['errors']['id'] = 'not set';
      } else if (empty($name)) {
        $response['errors'][$library::GENRE_NAME] = 'not set';
      } else {
        $genreData = [$library::GENRE_NAME => $name];
        $result = $library->updateGenre($id, $genreData);
        
        if (!empty($result)) {
          $genre = $library->getGenre($id);

          $response['data'] = $genre;
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
        $result = $library->deleteGenre($id);

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
    $response['data'] = $library->getGenre($id);
  } else {
    $response['data'] = $library->getGenresWithBookCount();
  }

  $response['success'] = 1;
}



