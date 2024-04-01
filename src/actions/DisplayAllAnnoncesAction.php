<?php

namespace App\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\model\Annonce;

/**
 * Route : [GET] -> /api/annonces/
 */
final class DisplayAllAnnoncesAction {

    private $app;

    public function __construct($app) {
        $this->app = $app;
    }

    public function __invoke(Request $request, Response $response, array $args): Response {
        $annonceList = ['id_annonce', 'prix', 'titre', 'ville'];

        $annonces     = Annonce::all($annonceList);
        $links = [];
        
        foreach ($annonces as $annonce) {
            $links['self']['href'] = '/api/annonce/' . $annonce->id_annonce;
            $annonce->links            = $links;
        }
        
        $links['self']['href'] = '/api/annonces/';
        $annonces->links              = $links;

        $response->getBody()->write($annonces->toJson());            
        return $response->withHeader('Content-Type', 'application/json');
    }
}