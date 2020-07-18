<?php

// require_once('./php/Session.php');

// $session = Session::getInstance();

// echo "is 'test' set: " . ((isset($session->test)) ? 'true' : 'false') . "<br>"; 
// $session->test = 10;
// echo "test = " . $session->test . "<br>";
// echo "is 'test' set: " . ((isset($session->test)) ? 'true' : 'false') . "<br>";
// unset($session->test);
// echo "is 'test' set: " . ((isset($session->test)) ? 'true' : 'false')  . "<br>";

require_once('./helpers/index.php');
require_once('./php/LibraryManager.php');

// создаем экземпляр менеджера библиотеки
$library = new LibraryManager('library');
// массив в который будут записываться все данных которые должны будут выводится на странице
$response = [];

// 1
// получаем все книги и записываем их в массив
$response['books'] = $library->getBooks();
// выводим ассоциативный массив в формате response
responseJson($response);

// // 2
// // удаляем все книги
// $library->deleteAllBooks();

// // 3
// // проверяем, что книг больше нет
// $response['books'] = $library->getBooks();


// // 4
// // массив с данным книг
// $books = [
//   ['451° по Фаренгейту', 1, 1, 1953, '451° по Фаренгейту – температура, при которой воспламеняется и горит бумага.'],
//   ['1984', 2, 2, 1948, 'Своеобразный антипод второй великой антиутопии XX века – «О дивный новый мир» Олдоса Хаксли.'],
//   ['Шантарам', 3, 2, 1997, 'Представляем читателю один из самых поразительных романов начала XXI века.'],
//   ['Мастер и Маргарита', 4, 2, 1940, 'Любовь, страх, самопожертвование, творчество, вера, религия, смерть…'],
//   ['Три товарища', 5, 2, 1936, 'Послевоенная Германия середины двадцатых годов прошлого века.'],
//   ['Цветы для Элджернона', 6, 1, 1959, 'Сорок лет назад это читалось как фантастика.'],
//   ['Маленький принц', 7, 3, 1942, 'Самое знаменитое произведение Антуана де Сент-Экзюпери с авторскими рисунками.'],
//   ['Таинственная история Билли Миллигана', 6, 4, 1981, 'Билли просыпается и обнаруживает, что находится в тюремной камере.'],
// ];

// // обходим массив с книгами и добавляем их в базу данных
// foreach ($books as $book) {
//   $library->addBook(...$book);
// }

// $response['books'] = $library->getBooks();


// // 6
// // изменяем название книги с id 21
// $library->editBook(21, [
//   'title' => 'TEST'
// ]);
// // получаем книгу с id 21
// $response['book'] = $library->getBook(21);

// // 7
// // Удаляем книгу с id 21
// $library->deleteBook(21);
// $response['books'] = $library->getBooks();


$response['lastQuery'] = $library->getLastQuery();
$response['error'] = $library->getError();


