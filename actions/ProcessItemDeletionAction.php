<?php

namespace actions;

use Slim\Http\Request;
use Slim\Http\Response;
use controller\item;

/**
 * Route : [POST] -> /del/{n}
 */
final class ProcessItemDeletionAction {

    private $twig; 
    private $menu; 
    private $chemin; 
    private $cat;

    public function __construct($twig, $menu, $chemin, $cat) {
        $this->twig = $twig; 
        $this->menu = $menu; 
        $this->chemin = $chemin; 
        $this->cat = $cat; 
    }

    public function __invoke(Request $request, Response $response, array $args): Response {
        $n    = $args['n'];
        $item = new item();
        $item->supprimerItemPost($this->twig, $this->menu, $this->chemin, $n, $this->cat->getCategories());

        return $response;
    }
}