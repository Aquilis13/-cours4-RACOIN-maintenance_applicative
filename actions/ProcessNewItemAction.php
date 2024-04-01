<?php

namespace actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use controller\addItem;

/**
 * Route : [POST] -> /add
 */
final class ProcessNewItemAction {

    private $app; 
    private $twig; 
    private $menu; 
    private $chemin; 

    public function __construct($twig, $app, $menu, $chemin) {
        $this->app = $app; 
        $this->twig = $twig; 
        $this->menu = $menu; 
        $this->chemin = $chemin; 
    }

    public function __invoke(Request $request, Response $response, array $args): Response {
        $allPostVars = $request->getParsedBody();
        $ajout       = new addItem();
        $ajout->addNewItem($this->twig, $this->menu, $this->chemin, $allPostVars);

        return $response;
    }
}