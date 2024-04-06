<?php

namespace App\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use OpenApi\Annotations as OA;
use App\controller\getCategorie;

/**
 * @OA\Get(path="/cat/{n}", 
 * tags={"Application"},
 * 
 * @OA\Parameter(
 *   parameter="n",
 *   name="n",
 *   description="Numero de la categorie",
 *   @OA\Schema(
 *     type="string"
 *   ),
 *   in="path",
 *   required=true
 * ),
 * @OA\Response(response="200", description="Affiche les annonces d'une catégorie."),
 * @OA\Response(response="404", description="Not Found")
 * )
 */
final class DisplayCategorieAction {

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
        $numeroCategorie = $args['n'];
        $categorie = new getCategorie();
        $categorie->displayCategorie($this->twig, $this->menu, $this->chemin, $this->cat->getCategories(), $numeroCategorie);

        return $response;
    }
}