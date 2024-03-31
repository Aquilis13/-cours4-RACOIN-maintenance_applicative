<?php

namespace actions;

use Slim\Http\Request;
use Slim\Http\Response;
use controller\KeyGenerator;

/**
 * Route : [GET] -> /api/key
 */
final class DisplayKeyGeneratorViewAction {

    private $app; 
    private $twig; 
    private $menu; 
    private $chemin; 
    private $cat;

    public function __construct($app, $twig, $menu, $chemin, $cat) {
        $this->app = $app;
        $this->twig = $twig; 
        $this->menu = $menu; 
        $this->chemin = $chemin; 
        $this->cat = $cat; 
    }

    public function __invoke(Request $request, Response $response, array $args): Response {
        $kg = new KeyGenerator();
        $kg->show($this->twig, $this->menu, $this->chemin, $this->cat->getCategories());

        return $response;
    }
}