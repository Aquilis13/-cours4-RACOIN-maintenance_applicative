<?php

namespace App\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use OpenApi\Annotations as OA;

use App\controller\addItem;
use App\controller\getCategorie;
use App\controller\getDepartment;

/**
 * @OA\Get(path="/add", 
 *  tags={"Application"},
 * 
 *  @OA\Response(
 *      response="200", 
 *      description="Page pour la création d'une annonce"),
 * )
 */
final class DisplayAddItemViewAction {
    
    private \Twig\Environment $twig; 
    private array $menu; 
    private string $chemin; 
    private \Slim\App $app; 
    private getCategorie $cat;
    private getDepartment $dpt;

    public function __construct(\Twig\Environment $twig, \Slim\App $app, array $menu, string $chemin, getCategorie $cat, getDepartment $dpt) {
        $this->twig = $twig; 
        $this->app = $app; 
        $this->menu = $menu; 
        $this->chemin = $chemin; 
        $this->cat = $cat;
        $this->dpt = $dpt; 
    }

    public function __invoke(Request $request, Response $response, array $args): Response {
        $ajout = new addItem();
        $ajout->addItemView($this->twig, $this->menu, $this->chemin, $this->cat->getCategories(), $this->dpt->getAllDepartments());

        return $response;
    }
}