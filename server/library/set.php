<?php

$library::clear();

$genres = ['Научная фантастика', 'Роман', 'Философская сказка', 'Биография'];

$authors = [
  ['Рэй Брэдбери', '1920-08-22', '2012-06-05'],
  ['Джордж Оруэлл', '1903-06-25', '1950-01-21'],
  ['Грегори Дэвид Робертс', '1952-06-21', null],
  ['Михаил Афанасьевич Булгаков', '1891-05-15', '1940-03-10'],
  ['Эрих Мария Ремарк', '1892-06-22', '1970-09-25'],
  ['Даниел Киз', '1927-08-09', '2014-06-16'],
  ['Антуан де Сент-Экзюпери', '1900-05-29', '1944-07-31']
]; 

$books = [
  ['451° по Фаренгейту', 1, 1, 1953, '451° по Фаренгейту – температура, при которой воспламеняется и горит бумага.'],
  ['1984', 2, 2, 1948, 'Своеобразный антипод второй великой антиутопии XX века – «О дивный новый мир» Олдоса Хаксли.'],
  ['Шантарам', 3, 2, 1997, 'Представляем читателю один из самых поразительных романов начала XXI века.'],
  ['Мастер и Маргарита', 4, 2, 1940, 'Любовь, страх, самопожертвование, творчество, вера, религия, смерть…'],
  ['Три товарища', 5, 2, 1936, 'Послевоенная Германия середины двадцатых годов прошлого века.'],
  ['Цветы для Элджернона', 6, 1, 1959, 'Сорок лет назад это читалось как фантастика.'],
  ['Маленький принц', 7, 3, 1942, 'Самое знаменитое произведение Антуана де Сент-Экзюпери с авторскими рисунками.'],
  ['Таинственная история Билли Миллигана', 6, 4, 1981, 'Билли просыпается и обнаруживает, что находится в тюремной камере.']
];

foreach ($genres as $genre) {
  $library->addGenre($genre);
}

foreach ($authors as $author) {
  $library->addAuthor(...$author);
}

foreach ($books as $book) {
  $library->addBook(...$book);
}

