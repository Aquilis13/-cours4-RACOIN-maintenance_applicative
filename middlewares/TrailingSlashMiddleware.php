<?php

namespace middlewares;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TrailingSlashMiddleware {

    public function __invoke(Request $request, Response $response, $next): Response {
        $uri  = $request->getUri();
        $path = $uri->getPath();
        if ($path != '/' && str_ends_with($path, '/')) {
            $uri = $uri->withPath(substr($path, 0, -1));
            
            if ($request->getMethod() == 'GET') {
                return $response->withRedirect((string)$uri, 301);
            } 
            return $next($request->withUri($uri), $response);
        }
        return $next($request, $response);
    }
}