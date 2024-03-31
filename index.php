<?php
require 'vendor/autoload.php';

use controller\getCategorie;
use controller\getDepartment;
use controller\index;
use controller\item;
use db\connection;

use model\Annonce;
use model\Categorie;
use model\Annonceur;
use model\Departement;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


connection::createConn();

// Initialisation de Slim
$app = new App([
    'settings' => [
        'displayErrorDetails' => true,
    ],
]);

// Initialisation de Twig
$loader = new FilesystemLoader(__DIR__ . '/template');
$twig   = new Environment($loader);

// Ajout d'un middleware pour le trailing slash
$app->add(function (Request $request, Response $response, $next) {
    $uri  = $request->getUri();
    $path = $uri->getPath();
    if ($path != '/' && str_ends_with($path, '/')) {
        $uri = $uri->withPath(substr($path, 0, -1));
        if ($request->getMethod() == 'GET') {
            return $response->withRedirect((string)$uri, 301);
        } else {
            return $next($request->withUri($uri), $response);
        }
    }
    return $next($request, $response);
});


if (!isset($_SESSION)) {
    session_start();
    $_SESSION['formStarted'] = true;
}

if (!isset($_SESSION['token'])) {
    $token                  = md5(uniqid(rand(), TRUE));
    $_SESSION['token']      = $token;
    $_SESSION['token_time'] = time();
} else {
    $token = $_SESSION['token'];
}

$menu = [
    [
        'href' => './index.php',
        'text' => 'Accueil'
    ]
];

$chemin = dirname($_SERVER['SCRIPT_NAME']);

$cat = new getCategorie();
$dpt = new getDepartment();

$app->get('/', new actions\AcceuilAction($twig, $menu, $chemin, $cat));

$app->get('/item/{n}', new actions\DisplayItemAction($twig, $menu, $chemin, $cat));

$app->get('/add', new actions\DisplayAddItemViewAction($twig, $app, $menu, $chemin, $cat, $dpt));

$app->post('/add', new actions\ProcessNewItemAction($twig, $app, $menu, $chemin));

$app->get('/item/{id}/edit', new actions\DisplayEditItemViewAction($twig, $app, $menu, $chemin));

$app->post('/item/{id}/edit', new actions\ProcessItemEditAction($twig, $app, $menu, $chemin, $cat, $dpt));

$app->map(['GET, POST'], '/item/{id}/confirm', new actions\ConfirmItemEditAction($twig, $app, $menu, $chemin));

$app->get('/search', new actions\DisplaySearchViewAction($app, $twig, $menu, $chemin, $cat));

$app->post('/search', new actions\ProcessSearchAction($app, $twig, $menu, $chemin, $cat));

$app->get('/annonceur/{n}', new actions\DisplayAnnonceurAction($twig, $menu, $chemin, $cat));

$app->get('/del/{n}', new actions\DisplayDeleteItemViewAction($twig, $menu, $chemin));

$app->post('/del/{n}', new actions\ProcessItemDeletionAction($twig, $menu, $chemin, $cat));

$app->get('/cat/{n}', new actions\DisplayCategorieAction($twig, $menu, $chemin, $cat));

$app->get('/api(/)', new actions\DisplayApiViewAction($twig, $menu, $chemin, $cat));

$app->group('/api', function () use ($app, $twig, $menu, $chemin, $cat) {

    $app->group('/annonce', function () use ($app) {
        $app->get('/{id}', new actions\DisplayAnnonceByIdAction($app));
    });

    $app->group('/annonces(/)', function () use ($app) {
        $app->get('/', new actions\DisplayAllAnnoncesAction($app));
    });

    $app->group('/categorie', function () use ($app) {
        $app->get('/{id}', new actions\DisplayCategorieByIdAction($app));
    });

    $app->group('/categories(/)', function () use ($app) {
        $app->get('/', new actions\DisplayAllCategoriesAction($app));
    });

    $app->get('/key', new actions\DisplayKeyGeneratorViewAction($app, $twig, $menu, $chemin, $cat));

    $app->post('/key', new actions\GenerateNewKeyAction($app, $twig, $menu, $chemin, $cat));
});


$app->run();
