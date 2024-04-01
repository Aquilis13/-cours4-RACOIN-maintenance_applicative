<?php

namespace actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use model\Categorie;

/**
 * Route : [GET] -> /api/categories/
 */
final class DisplayAllCategoriesAction {

    private $app;

    public function __construct($app) {
        $this->app = $app;
    }

    public function __invoke(Request $request, Response $response, array $args): Response {
        $response->headers->set('Content-Type', 'application/json');
        $c     = Categorie::get();
        $links = [];
        foreach ($c as $cat) {
            $links['self']['href'] = '/api/categorie/' . $cat->id_categorie;
            $cat->links            = $links;
        }
        $links['self']['href'] = '/api/categories/';
        $c->links              = $links;
        echo $c->toJson();

        return $response;
    }
}