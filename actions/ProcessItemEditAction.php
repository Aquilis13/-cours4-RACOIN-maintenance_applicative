<?php

namespace actions;

use Slim\Http\Request;
use Slim\Http\Response;
use controller\item;

/**
 * Route : [POST] -> /item/{id}/edit
 */
final class ProcessItemEditAction {

    private $app; 
    private $twig; 
    private $menu; 
    private $chemin; 
    private $cat;
    private $dpt; 

    public function __construct($twig, $app, $menu, $chemin, $cat, $dpt) {
        $this->app = $app; 
        $this->twig = $twig; 
        $this->menu = $menu; 
        $this->chemin = $chemin; 
        $this->cat = $cat; 
        $this->dpt = $dpt; 
    }

    public function __invoke(Request $request, Response $response, array $args): Response {
        $id          = $args['id'];
        $allPostVars = $request->getParsedBody();
        $item        = new item();
        $item->modifyPost($this->twig, $this->menu, $this->chemin, $id, $allPostVars, $this->cat->getCategories(), $this->dpt->getAllDepartments());

        return $response;
    }
}