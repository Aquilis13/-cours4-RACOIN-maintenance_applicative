<?php

namespace App\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\model\Categorie;

/**
 * Route : [GET] -> /api/categories/
 */
final class DisplayAllCategoriesAction {

    private $app;

    public function __construct($app) {
        $this->app = $app;
    }

    public function __invoke(Request $request, Response $response, array $args): Response {
        $categories     = Categorie::get();
        $links = [];
        foreach ($categories as $categorie) {
            $links['self']['href'] = '/api/categorie/' . $categorie->id_categorie;
            $categorie->links            = $links;
        }
        $links['self']['href'] = '/api/categories/';
        $categories->links              = $links;

        $response->getBody()->write($categories->toJson());            
        return $response->withHeader('Content-Type', 'application/json');
    }
}