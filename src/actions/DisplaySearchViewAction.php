<?php

namespace App\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\controller\Search;
use App\controller\getCategorie;

/**
 * Route : [GET] -> /search
 */
final class DisplaySearchViewAction {

    private \Slim\App $app; 
    private \Twig\Environment $twig; 
    private array $menu; 
    private string $chemin; 
    private getCategorie $cat;

    public function __construct(\Slim\App $app, \Twig\Environment $twig, array $menu, string $chemin, getCategorie $cat) {
        $this->app = $app; 
        $this->twig = $twig; 
        $this->menu = $menu; 
        $this->chemin = $chemin; 
        $this->cat = $cat; 
    }

    public function __invoke(Request $request, Response $response, array $args): Response {
        $search = new Search();
        $search->show($this->twig, $this->menu, $this->chemin, $this->cat->getCategories());

        return $response;
    }
}