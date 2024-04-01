<?php

namespace App\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\controller\item;

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
        $numeroItem    = $args['n'];
        $item = new item();
        $item->supprimerItemPost($this->twig, $this->menu, $this->chemin, $numeroItem, $this->cat->getCategories());

        return $response;
    }
}