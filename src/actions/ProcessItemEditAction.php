<?php

namespace App\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\controller\item;
use App\controller\getCategorie;
use App\controller\getDepartment;

/**
 * Route : [POST] -> /item/{id}/edit
 */
final class ProcessItemEditAction {

    private \Slim\App $app; 
    private \Twig\Environment $twig; 
    private array $menu; 
    private string $chemin; 
    private getCategorie $cat;
    private getDepartment $dpt; 

    public function __construct(\Twig\Environment $twig, \Slim\App $app, array $menu, string $chemin, getCategorie $cat, getDepartment $dpt) {
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