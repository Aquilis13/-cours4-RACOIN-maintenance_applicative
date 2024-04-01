<?php

namespace App\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\controller\item;

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
        $id   = $args['id'];
        $item = new item();
        $item->modifyGet($this->twig, $this->menu, $this->chemin, $id);

        return $response;
    }
}