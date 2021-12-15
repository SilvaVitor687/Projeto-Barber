<?php


use \App\Http\Response;
use \App\Controller\Pages;

//Rota da HOME
$obRouter->get('/',[
    function(){
        return new Response(200,Pages\Home::getHome());
    }
]);

$obRouter->get('/sobre',[
    function(){
        return new Response(200,Pages\About::getHome());
    }
]);

$obRouter->get('/cadastro',[
    function(){
        return new Response(200,Pages\Cadastro::getHome());
    }
]);




?>