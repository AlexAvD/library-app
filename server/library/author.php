<?php


if (isset($request) && isset($request['type']) && isset($request['payload'])) {  
  $type = $request['type'];
  $data = $request['payload'];
  $id = valueOrDefault($data, 'id');
  $fullName = valueOrDefault($data, $library::AUTHOR_FULL_NAME);
  $dateOfBirth = valueOrDefault($data, $library::AUTHOR_DATE_OF_BIRTH);
  $dateOfDeath = valueOrDefault($data, $library::AUTHOR_DATE_OF_DEATH);

  switch ($type) {
    case ADD:
      if (empty($fullName)) {
        $response['errors'][$library::AUTHOR_FULL_NAME] = 'not set';
      } else {
        $authorId = $library->addAuthor($fullName, $dateOfBirth, $dateOfDeath);
        $author = $library->getAuthor($authorId);
        
        if (!empty($author)) {
          $response['data'] = $author;
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
        $authorData = [];

        if (!empty($fullName)) { $authorData[$library::AUTHOR_FULL_NAME] = $fullName; }
        if (!empty($dateOfBirth)) { $authorData[$library::AUTHOR_DATE_OF_BIRTH] = $dateOfBirth; }
        if (!empty($dateOfDeath)) { $authorData[$library::AUTHOR_DATE_OF_DEATH] = $dateOfDeath; }

        $result = $library->updateAuthor($id, $authorData);
        
        if (!empty($result)) {
          $author = $library->getAuthor($id);

          $response['data'] = $author;
          $response['success'] = 1;
          $response['test'] = [
            $fullName, $dateOfBirth, $dateOfDeath
          ];

        } else {
          $response['error'] = '';
        }
      }

    break;

    case DELETE: 
      if (empty($id)) {
        $response['errors']['id'] = 'not set';
      } else {
        $result = $library->deleteAuthor($id);
      
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
    $response['data'] = $library->getAuthor($id);
  } else {
    $response['data'] = $library->getAuthors();
  }

  $response['success'] = 1;
}



