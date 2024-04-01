<?php

namespace App\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Route : [GET, POST] -> /item/{id}/confirm
 */
final class ConfirmItemEditAction {
 
    private \Twig\Environment $twig; 
    private array $menu; 
    private string $chemin; 
    private \Slim\App $app;

    public function __construct(\Twig\Environment $twig, \Slim\App $app, array $menu, string $chemin) {
        $this->twig = $twig; 
        $this->menu = $menu; 
        $this->chemin = $chemin; 
        $this->app = $app; 
    }

    public function __invoke(Request $request, Response $response, array $args): Response {
        $id   = $args['id'];
        $allPostVars = $request->getParsedBody();
        $item        = new item();
        $item->edit($this->twig, $this->menu, $this->chemin, $this->id, $allPostVars);

        return $response;
    }
}