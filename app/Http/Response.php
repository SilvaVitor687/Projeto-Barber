<?php

namespace App\Http;

class Response {

    /**
     * Código do Status HTTP
     * @var integer
     */

    private $httpCode = 200;

    /**
     * Cabeçalho do Response
     * @var array
     */
    private $headers = [];

    /**
     * Tipo de Conteudo que estar sendo retornada
     * @var string
     */
    private $contetType = 'text/html';

    /**
     * Conteudo do Response 
     * @var mixed
     */
    private $content;


    /**
     * Método responsavel por iniciar a classe e definir os valores
     */
    public function  __construct($httpCode,$content, $contentType = 'text/html'){
        $this->httpCode         =  $httpCode;
        $this->content          =  $content;
        $this->setContentType($contentType);
        
        
    }

    /**
     * Método responsavel por alterar o CONTENT TYPE
     * @var string
     */

    public function setContentType($contentType){


        $this->contentType  = $contentType;
        $this->addHeader('Content-Type',$contentType);

    }

    /**
     * Método Responsavel por adicionar  um registro na cabeçalho response
     * @param string
     * @param string
     */

    public function  addHeader($key,$value){
        $this->headers[$key] = $value;
    }

    /**
     * Método responsavel de enviar os headers para o navegador.
     * 
     */

    private function sendHeaders(){
        //STATUS
        http_response_code($this->httpCode);

        //Enviar Headers

        foreach($this->headers as $key=>$value){
            header($key.': '.$value);
        }
    }

    /**
     * Método responsavel  por enviar a resposta para o usuário.
     */
    public function sendResponse(){

        $this->sendHeaders();
        
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                break;
        }

    }
}

?>