<?php

namespace actions;

use Slim\Http\Request;
use Slim\Http\Response;
use controller\getCategorie;

/**
 * Route : [GET] -> /cat/{n}
 */
final class DisplayCategorieAction {

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
        $n = $args['n'];
        $categorie = new getCategorie();
        $categorie->displayCategorie($this->twig, $this->menu, $this->chemin, $this->cat->getCategories(), $n);

        return $response;
    }
}