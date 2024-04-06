<?php

namespace App\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use OpenApi\Annotations as OA;
use App\model\Annonce;

/**
 * @OA\Get(path="/api/annonces/", 
 * tags={"Api"},
 *      
 *     @OA\Response(
 *         response="200", 
 *         description="Liste des annonces",
 *         @OA\JsonContent(
 *             type="array", 
*              @OA\Items(ref="/components/schemas/OAAnnonce"),
 *             description="Response is display in Json"
 *         )
 *     ),
 *   
 * )
 */
final class DisplayAllAnnoncesAction {

    private \Slim\App $app; 

    public function __construct(\Slim\App $app) {
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