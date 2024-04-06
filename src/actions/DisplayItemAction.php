<?php

namespace App\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use OpenApi\Annotations as OA;
use App\controller\item;
use App\controller\getCategorie;

/**
 * @OA\Get(path="/item/{n}", 
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
 * @OA\Response(response="200", description="Detail d'une annonce."),
 * @OA\Response(response="404", description="Not Found")
 * )
 */
final class DisplayItemAction {

    private \Twig\Environment $twig; 
    private array $menu; 
    private string $chemin; 
    private getCategorie $cat;

    public function __construct(\Twig\Environment $twig, array $menu, string $chemin, getCategorie $cat) {
        $this->twig = $twig; 
        $this->menu = $menu; 
        $this->chemin = $chemin; 
        $this->cat = $cat; 
    }

    public function __invoke(Request $request, Response $response, array $args): Response {
        $numeroItem    = $args['n'];
        $item = new item();
        $item->afficherItem($this->twig, $this->menu, $this->chemin, $numeroItem, $this->cat->getCategories());

        return $response;
    }
}