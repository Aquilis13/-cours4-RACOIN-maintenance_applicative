<?php

namespace actions;

use Slim\Http\Request;
use Slim\Http\Response;
use controller\item;

/**
 * Route : [GET] -> /item/{id}/edit
 */
final class DisplayEditItemViewAction {

    private $twig; 
    private $menu; 
    private $chemin; 

    public function __construct($twig, $menu, $chemin) {
        $this->twig = $twig; 
        $this->menu = $menu; 
        $this->chemin = $chemin; 
    }

    public function __invoke(Request $request, Response $response, array $args): Response {
        $id   = $arg['id'];
        $item = new item();
        $item->modifyGet($twig, $menu, $chemin, $id);

        return $response;
    }
}