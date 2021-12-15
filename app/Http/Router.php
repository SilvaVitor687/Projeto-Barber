<?php 

namespace App\Http;
use \Closure;
use \Exception;
use \ReflectionFunction;

class Router {

    /**
     * Url completa do projeto
     * @var string
     */
    private $url = "";

    /**
     * Prefixo da URL
     * @var string
     */
    private $prefix = "";

    /**
     * Variavel das rotas
     * @var array
     */
    private $routes = [];

    /**
     * Instacia de request
     * @var Request
     */
    private $request;

    /**
     * Construtor da classe
     * @param string $url
     */
    public function __construct($url){

        $this->request = new Request();
        $this->url = $url;
        $this->setPrefix();

    }

    /**
     * Metodo usado para definir o prefixo da url
     */
    private function setPrefix(){

        $parseUrl = parse_url($this->url);

        $this->prefix = $parseUrl['path'] ?? '';

    }

    /**
     * Adiciona a rota
     * @param string $method
     * @param string $route
     * @param array  $param
     */
    private function addRoute($method, $route, $params = []){

        foreach($params as $key => $value){

            if($value instanceof Closure){

                $params['controller'] = $value;
                unset($params[$key]);
                continue;

            }

        }

        $params['variables'] = [];
        $patternVariable = "/{(.*?)}/";

        if(preg_match_all($patternVariable, $route, $matches)){

            $route = preg_replace($patternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];

        }

        $patternRoute = '/^'.str_replace('/', '\/', $route).'$/';
        
        $this->routes[$patternRoute][$method] = $params;


    }

    /**
     * Define uma rota de GET
     * @param string $route
     * @param array  $param
     */
    public function get($route, $params = []){

        $this->addRoute('GET', $route, $params);

    }

    public function post($route, $params = []){

        $this->addRoute('POST', $route, $params);

    }

    public function put($route, $params = []){

        $this->addRoute('PUT', $route, $params);

    }

    public function delete($route, $params = []){

        $this->addRoute('DELETE', $route, $params);

    }

    public function catch($route, $params = []){

        $this->addRoute('CATCH', $route, $params);

    }

    /**
     * Retorna a URI atual
     * @return string
     */
    private function getUri(){

        $uri = $this->request->getUri();

        $xUri = (!empty($this->prefix)) ? explode($this->prefix, $uri) : [$uri];

        return end($xUri);

    }

    /**
     * Retorna a rota atual
     * @return array
     */
    private function getRoutes(){

        $uri = $this->getUri();
        $httpMethod = $this->request->getHttpMethod();

        foreach($this->routes as $patternRoute => $methods){

            if(preg_match($patternRoute, $uri, $matches)){
                
                if(isset($methods[$httpMethod])){

                    unset($matches[0]);

                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;

                    return $methods[$httpMethod];

                }

                throw new Exception("Método não permitido", 405);

            }

        }

        throw new Exception("Não encontrado", 404);

    }

    /**
     * Método que executa a rota atual
     * @return Response
     */
    public function run(){

        try {

            $route = $this->getRoutes();

            if(!isset($route['controller'])){

                throw new Exception("Erro do servidor", 500);
                
            }
            $args = [];

            $reflection = new ReflectionFunction($route['controller']);

            foreach($reflection->getParameters() as $parameter){

                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';

            }

            return call_user_func_array($route['controller'], $args);

        } catch (Exception $e) {

            return new Response($e->getCode(), $e->getMessage());

        }

    }

}