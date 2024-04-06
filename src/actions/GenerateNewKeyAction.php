<?php

namespace App\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use OpenApi\Annotations as OA;
use App\controller\KeyGenerator;
use App\controller\getCategorie;

/**
 * @OA\Post(path="/api/key", 
 * tags={"Api"},
 * 
 *   @OA\Response(
 *          response="200", 
 *          description="Génère une clé API",
 *          @OA\JsonContent(type="string", description="is json")
 *   ),
 *   @OA\Response(response="404", description="Not Found")
 * )
 */
final class GenerateNewKeyAction {

    private \Slim\App $app; 
    private \Twig\Environment $twig; 
    private array $menu; 
    private string $chemin; 
    private getCategorie $cat;

    public function __construct(\Slim\App $app, \Twig\Environment $twig, array $menu, string $chemin, getCategorie $cat) {
        $this->app = $app; 
        $this->twig = $twig; 
        $this->menu = $menu; 
        $this->chemin = $chemin; 
        $this->cat = $cat; 
    }

    public function __invoke(Request $request, Response $response, array $args): Response {
        $nom = $_POST['nom'];

        $kg = new KeyGenerator();
        $kg->generateKey($this->twig, $this->menu, $this->chemin, $this->cat->getCategories(), $nom);

        return $response;
    }
}