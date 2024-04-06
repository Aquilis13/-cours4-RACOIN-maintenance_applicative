<?php

namespace App\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use OpenApi\Annotations as OA;
use App\model\Categorie;

/**
 * @OA\Get(path="/api/categories/", 
 * tags={"Api"},
 * 
 *     @OA\Response(
 *         response="200", 
 *         description="Liste des catégories d'annonces",
 *         @OA\JsonContent(
 *             type="array", 
 *             @OA\Items(ref="components/schemas/OACategorie"),
 *             description="Response is display in Json"
 *         )
 *     ),
 *   
 * )
 */
final class DisplayAllCategoriesAction {

    private \Slim\App $app;

    public function __construct(\Slim\App $app) {
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