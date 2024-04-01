<?php

namespace App\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\controller\item;

/**
 * Route : [GET] -> /del/{n}
 */
final class DisplayDeleteItemViewAction {

    private \Twig\Environment $twig; 
    private array $menu; 
    private string $chemin;

    public function __construct(\Twig\Environment $twig, array $menu, string $chemin) {
        $this->twig = $twig; 
        $this->menu = $menu; 
        $this->chemin = $chemin; 
    }

    public function __invoke(Request $request, Response $response, array $args): Response {
        $numeroItem    = $args['n'];
        $item = new item();
        $item->supprimerItemGet($this->twig, $this->menu, $this->chemin, $numeroItem);

        return $response;
    }
}