<?php

namespace App\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\controller\index;
use OpenApi\Annotations as OA;

use App\controller\getCategorie;

/**
 * @OA\Get(path="/", 
 *   tags={"Application"},
 *   @OA\Response(response="200", description="Page d'accueil")
 * )
 */
final class AcceuilAction {
 
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
        $index = new index();
        $index->displayAllAnnonce($this->twig, $this->menu, $this->chemin, $this->cat->getCategories());

        return $response;
    }
}