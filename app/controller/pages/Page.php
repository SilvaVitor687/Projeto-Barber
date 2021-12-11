<?php

namespace App\Controller\Pages;
use \App\Utils\View;

class Page {

    /**
     * Método responsável por renderizar o topo da página
     * @return string
     */

    private static function getHeader(){

        return View::getRender('pages/header');
    }

    /**
     * Método Responsável por retornar o conteudo (view) da nossa página generica.
     * @retunr string
     */

    public static function getPage($title, $content){

       return View::getRender('pages/page', [
           'title' =>$title,
           'header'=>self::getHeader(),
           'content' =>$content,
           'footer' =>self::getFooter()
       ]);
    }

    /**
     * Método responsável por renderizar o fim da página
     * @return string
     */

    private static function getFooter(){

        return View::getRender('pages/footer');
    }
}


?>