<?php

namespace actions;

use Slim\Http\Request;
use Slim\Http\Response;
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
        $n    = $args['n'];
        $item = new item();
        $item->supprimerItemGet($this->twig, $this->menu, $this->chemin, $n);

        return $response;
    }
}