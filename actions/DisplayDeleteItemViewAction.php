<?php

namespace actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use controller\item;

/**
 * Route : [GET] -> /del/{n}
 */
final class DisplayDeleteItemViewAction {

    private $twig; 
    private $menu; 
    private $chemin; 

    public function __construct($twig, $menu, $chemin) {
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