<?php

namespace App\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\model\Annonce;
use App\model\Categorie;

/**
 * Route : [GET] -> /api/categorie/{id}
 */
final class DisplayCategorieByIdAction {

    private \Slim\App $app; 

    public function __construct(\Slim\App $app) {
        $this->app = $app; 
    }

    public function __invoke(Request $request, Response $response, array $args): Response {
        $id = $args['id'];
        
        $annonces     = Annonce::select('id_annonce', 'prix', 'titre', 'ville')
            ->where('id_categorie', '=', $id)
            ->get();
        $links = [];

        foreach ($annonces as $annonce) {
            $links['self']['href'] = '/api/annonce/' . $annonce->id_annonce;
            $annonce->links            = $links;
        }

        $categorie                     = Categorie::find($id);
        $links['self']['href'] = '/api/categorie/' . $id;
        $categorie->links              = $links;
        $categorie->annonces           = $annonces;
        
        $response->getBody()->write($categorie->toJson());
            
        return $response->withHeader('Content-Type', 'application/json');
    }
}