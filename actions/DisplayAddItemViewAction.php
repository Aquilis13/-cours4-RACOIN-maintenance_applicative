<?php

namespace actions;

use Slim\Http\Request;
use Slim\Http\Response;
use controller\addItem;

/**
 * Route : [GET] -> /add
 */
final class DisplayAddItemViewAction {
    
    private $twig; 
    private $app;
    private $menu; 
    private $chemin; 
    private $cat;
    private $dpt;

    public function __construct($twig, $app, $menu, $chemin, $cat, $dpt) {
        $this->twig = $twig; 
        $this->app = $app; 
        $this->menu = $menu; 
        $this->chemin = $chemin; 
        $this->cat = $cat;
        $this->dpt = $dpt; 
    }

    public function __invoke(Request $request, Response $response, array $args): Response {
        $ajout = new addItem();
        $ajout->addItemView($this->twig, $this->menu, $this->chemin, $this->cat->getCategories(), $this->dpt->getAllDepartments());

        return $response;
    }
}