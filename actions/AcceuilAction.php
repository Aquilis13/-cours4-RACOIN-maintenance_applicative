<?php

namespace actions;

use Slim\Http\Request;
use Slim\Http\Response;
use controller\index;

/**
 * Route : [GET] -> /
 */
final class AcceuilAction {
 
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
        $index = new index();
        $index->displayAllAnnonce($this->twig, $this->menu, $this->chemin, $this->cat->getCategories());

        return $response;
    }
}