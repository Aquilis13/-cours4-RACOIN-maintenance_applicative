<?php

namespace App\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use OpenApi\Annotations as OA;
use App\model\Annonce;
use App\model\Categorie;

/**
 * @OA\Get(path="/api/categorie/{id}", 
 * tags={"Api"},
 * 
 * @OA\Parameter(
 *   parameter="id",
 *   name="id",
 *   description="Identifiant d'une categorie.",
 *   @OA\Schema(
 *     type="string"
 *   ),
 *   in="path",
 *   required=true
 * ),
 * 
 * @OA\Response(
 *     response="200", 
 *     description="Données d'une categorie pour un identifiant donnée",
 *     @OA\JsonContent(type="string", description="is json")
 * ),
 * @OA\Response(response="404", description="Not Found")
 * )
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

        foreach ($annonces as $categorie) {
            $links['self']['href'] = '/api/categorie/' . $categorie->id_annonce;
            $categorie->links            = $links;
        }

        $categorie                     = Categorie::find($id);
        $links['self']['href'] = '/api/categorie/' . $id;
        $categorie->links              = $links;
        $categorie->annonces           = $annonces;
        
        $response->getBody()->write($categorie->toJson());
            
        return $response->withHeader('Content-Type', 'application/json');
    }
}