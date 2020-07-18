<?php

require_once('./helpers/index.php');

class Router {
  private $_url;
  private $_routes;
  private $_route;

  function __construct(array $routes) {
    $this->_url = isset($_GET['uri']) ? $_GET['uri'] : "/";
    $this->_routes = $routes;
    $this->_activeRoute = $this->_getActiveRoute($this->_url, $this->_routes);
  }

  function toRoute($route): void {
    if (isset($route['resource'])) {
      require_once($route['resource']);
    }
  }

  function getActiveRoute() {
    return $this->_activeRoute;
  }

  private function startWith($str, $start): bool {
    if (empty($str) && !empty($start)) return false;

    return (substr($str, 0, strlen($start)) === $start);
  }

  private function _getActiveRoute($url, $routes) {
    $result = null;
    $default = null;
    $url = trim($url, '/ ');
    $urlStart = substr($url, 0, stripos($url, '/'));

    if (empty($urlStart)) {
      $urlStart = $url;
    }

    foreach ($routes as $route) {
      if (isset($route['path'])) {
        $path =  trim($route['path'], '/ ');
        
        if ($urlStart === $path) {
          if (isset($route['children'])) {
            $childRoute = $this->_getActiveRoute(substr($url, strlen($path)), $route['children']);

            if (!is_null($childRoute)) {
              $result = $childRoute;
              break;
            }
          } else {
            $result = $route;
            break;
          }
        } else if ($route['path'] === '*' && is_null($result)) {
          $result = $route;
        }
      }
    }

    return $result;
  }
}