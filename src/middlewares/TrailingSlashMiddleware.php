<?php

namespace App\middlewares;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class TrailingSlashMiddleware {

    public function __invoke(Request $request, RequestHandler $handler): Response {
        $uri  = $request->getUri();
        $path = $uri->getPath();
        if ($path != '/' && str_ends_with($path, '/')) {
            $uri = $uri->withPath(substr($path, 0, -1));
            
            if ($request->getMethod() == 'GET') {
                $response = $handler->handle($request);
                return $response->withRedirect((string)$uri, 301);
            } 
            $request = $request->withUri($uri);
        }
        return $handler->handle($request);
    }
}