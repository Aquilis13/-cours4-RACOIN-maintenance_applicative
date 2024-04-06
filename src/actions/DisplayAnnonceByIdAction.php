<?php

namespace App\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use OpenApi\Annotations as OA;

use App\model\Categorie;
use App\model\Annonceur;
use App\model\Annonce;
use App\model\Departement;

/**
 * @OA\Get(path="/api/annonce/{id}", 
 * tags={"Api"},
 * 
 * 
 * @OA\Parameter(
 *   parameter="id",
 *   name="id",
 *   description="Identifiant d'une annonce.",
 *   @OA\Schema(
 *     type="string"
 *   ),
 *   in="path",
 *   required=true
 * ),
 * 
 * @OA\Response(
 *     response="200", 
 *     description="Données d'une annonce pour un identifiant donnée",
 *     @OA\JsonContent(type="string", description="is json")
 * ),
 * @OA\Response(response="404", description="Not Found")
 * )
 */
final class DisplayAnnonceByIdAction {

    private \Slim\App $app;

    public function __construct(\Slim\App $app) {
        $this->app = $app;
    }

    public function __invoke(Request $request, Response $response, array $args): Response {
        $id          = $args['id'];
        $annonceList = ['id_annonce', 'id_categorie as categorie', 'id_annonceur as annonceur', 'id_departement as departement', 'prix', 'date', 'titre', 'description', 'ville'];
        $return      = Annonce::select($annonceList)->find($id);

        if (isset($return)) {
            $return->categorie     = Categorie::find($return->categorie);
            $return->annonceur     = Annonceur::select('email', 'nom_annonceur', 'telephone')
                ->find($return->annonceur);
            $return->departement   = Departement::select('id_departement', 'nom_departement')->find($return->departement);
            $links                 = [];
            $links['self']['href'] = '/api/annonce/' . $return->id_annonce;
            $return->links         = $links;

            $response->getBody()->write($return->toJson());
            
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $this->app->notFound();
        }

        return $response;
    }
}