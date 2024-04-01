<?php

namespace App\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\controller\getCategorie;

/**
 * Route : [GET] -> /api(/)
 */
final class DisplayApiViewAction {

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
        $template = $this->twig->load('api.html.twig');
        $this->menu     = array(
            array(
                'href' => $this->chemin,
                'text' => 'Acceuil'
            ),
            array(
                'href' => $this->chemin . '/api',
                'text' => 'Api'
            )
        );
        echo $template->render(array('breadcrumb' => $this->menu, 'chemin' => $this->chemin));

        return $response;
    }
}