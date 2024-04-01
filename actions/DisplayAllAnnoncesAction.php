<?php

namespace actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use model\Annonce;

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
        $response->headers->set('Content-Type', 'application/json');
        $a     = Annonce::all($annonceList);
        $links = [];
        
        foreach ($a as $ann) {
            $links['self']['href'] = '/api/annonce/' . $ann->id_annonce;
            $ann->links            = $links;
        }
        
        $links['self']['href'] = '/api/annonces/';
        $a->links              = $links;
        echo $a->toJson();

        return $response;
    }
}