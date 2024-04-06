<?php

namespace App\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use OpenApi\Annotations as OA;
use App\controller\item;

/**
 * @OA\Get(path="/item/{id}/edit", 
 * tags={"Application"},
 * 
 * @OA\Parameter(
 *   parameter="n",
 *   name="n",
 *   description="Numéro d'une annonce'",
 *   @OA\Schema(
 *     type="string"
 *   ),
 *   in="path",
 *   required=true
 * ),
 * @OA\Response(response="200", description="Permet d'aller modifier une annonce."),
 * @OA\Response(response="404", description="Not Found")
 * )
 */
final class DisplayEditItemViewAction {

    private \Twig\Environment $twig; 
    private array $menu; 
    private string $chemin;

    public function __construct(\Twig\Environment $twig, array $menu, string $chemin) {
        $this->twig = $twig; 
        $this->menu = $menu; 
        $this->chemin = $chemin; 
    }

    public function __invoke(Request $request, Response $response, array $args): Response {
        $id   = $args['id'];
        $item = new item();
        $item->modifyGet($this->twig, $this->menu, $this->chemin, $id);

        return $response;
    }
}