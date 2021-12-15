<?php

require __DIR__.'/vendor/autoload.php';

use \App\Http\Router;


define('URL','http://www.sitebarber.com.br');

$obRouter = new Router(URL);

include __DIR__.'/routes/pages.php';

//Imprima o Response da Rota
$obRouter->run()
         ->sendResponse();
?>