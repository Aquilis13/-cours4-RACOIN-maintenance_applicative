<?php
require 'vendor/autoload.php';

use App\controller\getCategorie;
use App\controller\getDepartment;
use App\controller\index;
use App\controller\item;
use App\db\connection;

use App\model\Annonce;
use App\model\Categorie;
use App\model\Annonceur;
use App\model\Departement;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Slim\Factory\AppFactory;
use DI\ContainerBuilder;

use App\middlewares\TrailingSlashMiddleware;
use App\middlewares\HttpLoggerMiddleware;

use App\Routes;

connection::createConn();


$builder = new ContainerBuilder();
$builder->addDefinitions([
    'displayErrorDetails' => true,
]);

$c=$builder->build();
$app = AppFactory::createFromContainer($c);

// Initialisation de Twig
$loader = new FilesystemLoader(__DIR__ . '/template');
$twig   = new Environment($loader);

// Ajout d'un middleware pour le trailing slash
$app->add(new TrailingSlashMiddleware());
$app->add(new HttpLoggerMiddleware());

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

// Les routes sont importer ici
new Routes($app, $twig, $menu, $chemin, $cat, $dpt);

$app->run();
