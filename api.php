<?php
  error_reporting(E_ALL);
  ini_set('display_errors', '1');
  require_once 'vendor/autoload.php';
  
  $app = new \Slim\Slim();
  
  $db = new mysqli("localhost","root","odiseo1514","pruebas");

  $app->get("/productos",  function () use($db,$app){
      $query = $db->query("SELECT * FROM productos;");
      $productos = array();
      while ($fila = $query->fetch_assoc()){
          $productos[] = $fila;
      }
      echo json_encode($productos);
  });
  
  $app->post("/productos",  function () use($db,$app){
      $query = "INSERT INTO productos VALUES(NULL,"
              ."'{$app->request->post("name")}',"
              ."'{$app->request->post("description")}',"
              ."'{$app->request->post("price")}'"
              . ");";
      echo $query;
      $insert = $db->query($query);
      if($insert){
          $result = array("STATUS"=>"true","message"=>"Producto creado correctamente!!!");
      }else{
          $result = array("STATUS"=>"false","message"=>"Producto NO SE HA creado!!!!");
      }
      
      echo json_encode($result);
  });
  
  $app->put("/productos/:id",  function ($id) use($db,$app){
      $query = "UPDATE productos SET "
              ."name ='{$app->request->put("name")}',"
              ."description='{$app->request->put("description")}',"
              ."price='{$app->request->put("price")}' "
              ."WHERE id={$id}";
       $update = $db->query($query);
      if($update){
          $result = array("STATUS"=>"true","message"=>"Producto Actualizado!!");
      }else{
          $result = array("STATUS"=>"false","message"=>"Producto NO SE HA Actualizado!!!!");
      }
      
      echo json_encode($result);
  });
  
  $app->delete("/productos/:id",function ($id) use($db,$app){
      $query = "DELETE FROM productos WHERE id = {$id}";
      $delete = $db->query($query);
      
      if($delete){
          $result = array("STATUS"=>"true","message"=>"Producto Borrado");
      }else{
          $result = array("STATUS"=>"false","message"=>"Producto NO SE HA Borrado!!!!");
      }
      
      echo json_encode($result);
  });
  
  $app->run();