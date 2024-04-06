<?php

namespace App;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use \OpenApi\Attributes as OA;

require("../vendor/autoload.php");

#[OA\Info(
    title: "Racoin Documentation",
    version: "latest",
    description: "Liste des routes Slim disponible dans l'application.",
)]
class Routes {
    
    public function __construct($app, $twig, $menu, $chemin, $cat, $dpt) {
    
        $app->get('/openapi', function ($request, $response, $args) {
            $swagger = \OpenApi\Generator::scan(['../public/Routes.php', '../src/actions']);
            $response->getBody()->write(json_encode($swagger));
            return $response->withHeader('Content-Type', 'application/json');
        });

        $app->get('/', new \App\actions\AcceuilAction($twig, $menu, $chemin, $cat));
    
        $app->get('/item/{n}[/]', new \App\actions\DisplayItemAction($twig, $menu, $chemin, $cat));
        
        $app->get('/add[/]', new \App\actions\DisplayAddItemViewAction($twig, $app, $menu, $chemin, $cat, $dpt));
        
        $app->post('/add', new \App\actions\ProcessNewItemAction($twig, $app, $menu, $chemin));
        
        $app->get('/item/{id}/edit[/]', new \App\actions\DisplayEditItemViewAction($twig, $menu, $chemin));
        
        $app->post('/item/{id}/edit', new \App\actions\ProcessItemEditAction($twig, $app, $menu, $chemin, $cat, $dpt));
        
        $app->map(['GET, POST'], '/item/{id}/confirm[/]', new \App\actions\ConfirmItemEditAction($twig, $app, $menu, $chemin));
        
        $app->get('/search[/]', new \App\actions\DisplaySearchViewAction($app, $twig, $menu, $chemin, $cat));
        
        $app->post('/search', new \App\actions\ProcessSearchAction($app, $twig, $menu, $chemin, $cat));
        
        $app->get('/annonceur/{n}[/]', new \App\actions\DisplayAnnonceurAction($twig, $menu, $chemin, $cat));
        
        $app->get('/del/{n}[/]', new \App\actions\DisplayDeleteItemViewAction($twig, $menu, $chemin));
        
        $app->post('/del/{n}', new \App\actions\ProcessItemDeletionAction($twig, $menu, $chemin, $cat));
        
        $app->get('/cat/{n}[/]', new \App\actions\DisplayCategorieAction($twig, $menu, $chemin, $cat));
        
        $app->get('/api[/]', new \App\actions\DisplayApiViewAction($twig, $menu, $chemin, $cat));
        
        $app->get('/api/annonce/{id}[/]', new \App\actions\DisplayAnnonceByIdAction($app));
    
        $app->get('/api/annonces[/]', new \App\actions\DisplayAllAnnoncesAction($app));
    
        $app->get('/api/categorie/{id}', new \App\actions\DisplayCategorieByIdAction($app));
    
        $app->get('/api/categories[/]', new \App\actions\DisplayAllCategoriesAction($app));
    
        $app->get('/api/key[/]', new \App\actions\DisplayKeyGeneratorViewAction($app, $twig, $menu, $chemin, $cat));
    
        $app->post('/api/key', new \App\actions\GenerateNewKeyAction($app, $twig, $menu, $chemin, $cat));
        
    }
}

