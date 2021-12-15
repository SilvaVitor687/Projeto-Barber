<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Organization;


class About extends Page {

    /**
     * Método Responsável por retornar o conteudo (view) da nossa HOME.
     * @return string
     */

    public static function getHome(){

        $obOrganization = new Organization;

       $content = View::getRender('pages/about',[
           'name'  => 'Victor Silva'
       ]);

       return parent::getPage('Site Barber', $content);
    }
}


?>