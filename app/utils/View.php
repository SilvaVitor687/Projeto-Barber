<?php

namespace App\Utils;

class View {

    /**
     * Método que retorna o conteúdo de uma view
     * @param string $view
     * @return string
     */

    private static function getContentView($view){

        $file = __DIR__.'/../../resources/view/' .$view. '.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }

    /**
     * Método responsavel  por retornar o conteúdo renderizado de uma view
     * @param string $view
     * @return string 
     */

    public static function getRender($view, $vars = []){
        //Conteudo da View

        $contentView = self::getContentView($view);

        $keys = array_keys($vars);
        $keys = array_map(function($item){

            return '{{'.$item.'}}';
        }, $keys);


        //Retorna o conteudo renderizado
        return str_replace($keys,array_values($vars), $contentView);

    }
}

?>