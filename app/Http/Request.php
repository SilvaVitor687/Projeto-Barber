<?php

    namespace App\Http;

    class Request {

        /**
         * Metodo de Requsição de HTTP
         * @var string
         */
        private $httpMethod;

        /**
         * URI da página
         * @var string
         */
        private $uri;

        /**
         * Parâmetro da URL ($_GET)
         * @var array
         */
        private $queryParams = [];


        /**
         * Varíaveis recebidas no POST da página ($_POST)
         * @var array
         */
        private $postVars = [];

        /**
         * Cabeçalho de requisição
         * @var array
         */
        private $headers = [];

        public function __construct(){

            $this->queryParams  = $_GET ?? [];
            $this->postVars     = $_POST ?? [];
            $this->headers     = getallheaders();
            $this->httpMethod   = $_SERVER['REQUEST_METHOD'] ?? '';
            $this->uri          = $_SERVER['REQUEST_URI'] ?? '';
   }

   /**
    * Metodo responsavel  por retornar o metodo HTTTP
    * @return string
    */
   public function getHttpMethod(){

    return $this->httpMethod;
   }

   /**
    * Metodo que retorna o metodo URI
    * @return array
    */

   public function getUri(){

    return $this->uri;
   }

    /**
    * Metodo que retorna o metodo HEADERS
    * @return array
    */
   public function getHeaders(){

    return $this->headers;
   }

    /**
    * Metodo que retorna o metodo Params
    * @return array
    */
   public function getQueryParams(){

    return $this->queryParams;
   }

    /**
    * Metodo que retorna o metodo POST
    * @return array
    */
    public function getPostVars(){

        return $this->postVars;
       }
                    
}

    


?>