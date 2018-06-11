<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    
    require_once 'vendor/autoload.php';
    
    $app = new \Slim\Slim();
    
    $app->get("/hola/:nombre",  function ($nombre){
        echo "Hola" . $nombre;
    });
    
    $app->get("/pruebas(/:uno(/:dos))",'pruebaMiddle','pruebaTwo',  function ($uno="a" ,$dos=0){
        echo $uno."<br>";
        echo $dos."<br>";
    })->conditions(array(
        'uno' => '[a-zA-Z]*',
        'dos' => '[0-9]*'   
        )
    );
    
    
    function pruebaMiddle(){
        echo 'Soy un middleware';
    }
    
     function pruebaTwo(){
        echo 'Soy un middleware 2';
    }
    
    $app->group("/api",  function () use($app){
        $app->group("/ejemplo",  function() use ($app){
            $app->get("/hola/:nombre",function($nombre){
                echo "Hola ".$nombre;
            })->name("hola");
            
            $app->get("/apellido/:apellido",function($apellido){
                echo "Tu apellido es : ".$apellido;
            });
            
            $app->get("/mandame-a-hola",function() use($app){
                //$app->redirect("hola/Jose");
                $app->redirect($app->urlFor("hola",array("nombre"=>"Victor Robles")));
            });
        });
    });

    $app->run();
?>