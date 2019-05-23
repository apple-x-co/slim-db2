<?php

namespace App\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

trait DispatchActionTrait {

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param $argument
     *
     * @return ResponseInterface
     * @throws \Slim\Exception\NotFoundException
     */
    public function __invoke($request, $response, $argument)
    {
        $method_name = isset($argument['name']) ? $argument['name'] : 'index';

        if (method_exists($this, $method_name)) {
            return $this->$method_name($request, $response);
        }

        throw new \Slim\Exception\NotFoundException($request, $response);
    }

}