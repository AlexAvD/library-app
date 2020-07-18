<?php

require_once('./php/CinemaManager.php');
require_once('./helpers/index.php');

$cinema = CinemaManager::getInstance();

// отчищаем базу данных
$cinema::clear();
// продюсера
$producers = [
  ['Joseph Schmidt', 1997, 'Chattanooga', 'Poplar Dr 3741'],
  ['Steve Jones', 1991, 'Norwalk', 'N Stelling Rd 7905'],
  ['Avery Bradley', 1955, 'Durham', 'Dogwood Ave 8097'],
  ['David Tucker', 1965, 'Bozeman', 'Country Club Rd 8096'],
  ['Darlene Russell', 1945, 'Garland', 'Washington Ave 6011'],
];
// исполнители
$performers = [
  ["Aubree Nichols", 1, 1950, "Denver", "Karen Dr 3702"],
  ["Ashley George", 2, 1982, "Topeka", "Green Rd 715"],
  ["Margie Hamilton", 3, 1968, "Naperville", "Country Club Rd 5080"],
  ["Hector Alvarez", 1, 1993, "Altoona", "Wheeler Ridge Dr 8624"],
  ["Austin Garcia", 1, 1963, "Cleveland", "Miller Ave 9295"],
  ["Sara Caldwell", 4, 1974, "Santa Clara", "Spring St 6717"],
  ["Glen Holmes", 4, 1950, "Cedar Hill", "W Belt Line Rd 8568"],
  ["Willie Hicks", 5, 1994, "Columbus", "Frances Ct 2843"],
  ["Noelle Bennett", 3, 1945, "Amarillo", "Cackson St 5511"],
  ["Aaron Graham", 1, 1980, "Santa Clarita", "W Belt Line Rd 5798"]
];
// заполняем таблицу с продюсерами
foreach ($producers as $producer) {
  $cinema->addProducer(...$producer);
}

// заполняем таблицу с исполнителями
foreach ($performers as $performer) {
  $cinema->addPerformer(...$performer);
}

$producerId = 1;
// извлекаем из базы данных продюсера с id = 1 со всеми его исполнителями и добавляем его в ответ
$response['producer'] = $cinema->getProducerWithOwnPerformers($producerId);
// выводим все в формате json
responseJson($response);