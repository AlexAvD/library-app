<?php

function responseJson($json): void {
  header('Content-Type: application/json');
  printJson($json);
  exit;
}


function printJson($json): void {
  echo json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

function valueOrDefault(array $arr, $key, $default = null) {
  return (isset($arr[$key]) ? $arr[$key] : $default);
} 