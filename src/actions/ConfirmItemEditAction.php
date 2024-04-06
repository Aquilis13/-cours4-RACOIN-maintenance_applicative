<?php

namespace App\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(path="/item/{id}/confirm",
 * tags={"Application"},
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
 *     description="Confirmation de l'édition d'une annonce pour un identifiant donné"
 * ),
 * @OA\Response(response="404", description="Not Found")
 * )
 */

 /** 
 * @OA\Post(path="/item/{id}/confirm",
 * tags={"Application"},
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
 *     description="Confirmation de l'édition d'une annonce pour un identifiant donné"
 * ),
 * @OA\Response(response="404", description="Not Found")
 * )
 */
final class ConfirmItemEditAction {
 
    private \Twig\Environment $twig; 
    private array $menu; 
    private string $chemin; 
    private \Slim\App $app;

    public function __construct(\Twig\Environment $twig, \Slim\App $app, array $menu, string $chemin) {
        $this->twig = $twig; 
        $this->menu = $menu; 
        $this->chemin = $chemin; 
        $this->app = $app; 
    }

    public function __invoke(Request $request, Response $response, array $args): Response {
        $id   = $args['id'];
        $allPostVars = $request->getParsedBody();
        $item        = new item();
        $item->edit($this->twig, $this->menu, $this->chemin, $this->id, $allPostVars);

        return $response;
    }
}