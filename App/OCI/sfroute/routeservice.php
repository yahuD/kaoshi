<?php
header('Content-Type: text/html; charset=utf-8');
 require_once (dirname(__FILE__) . "/route.class.php");

  $route_mailno = $_GET['postid'];
  $SF = new route();

  $data = $SF->RouteService($route_mailno)->Send()->View();        
  echo $data;
  


?>