<?php


namespace Asoum\Utility\Middleware;


use Exception;
use Slim\Http\Request;
use Slim\Http\Response;

abstract class ValidationMiddleware
{
    protected $parameter;

    protected $typeCheck;

    protected function setParameters($parameter, String $typeCheck){
        $this->parameter = $parameter;
        $this->typeCheck = $typeCheck;
    }

    public function handleMiddleware(Request $request, Response $response, Callable $next): Response
    {
        $jsonData = $request->getParsedBody();
        if ($jsonData[$this->parameter] == null || $jsonData[$this->parameter] == "") {
            throw new Exception('Input '.$this->parameter.' is missing!');
        }
        if (!call_user_func_array($this->typeCheck, array($jsonData[$this->parameter]))){

            throw new Exception('Invalid '.$this->parameter.' input type!');
        }
        return $next($request, $response);
    }
}

