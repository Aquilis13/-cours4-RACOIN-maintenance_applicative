<?php

namespace actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use controller\viewAnnonceur;

/**
 * Route : [GET] -> /annonceur/{n}
 */
final class DisplayAnnonceurAction {

    private $twig; 
    private $menu; 
    private $chemin; 
    private $cat;

    public function __construct($twig, $menu, $chemin, $cat) {
        $this->twig = $twig; 
        $this->menu = $menu; 
        $this->chemin = $chemin; 
        $this->cat = $cat; 
    }

    public function __invoke(Request $request, Response $response, array $args): Response {
        $numeroAnnoneur = $args['n'];
        $annonceur = new viewAnnonceur();
        $annonceur->afficherAnnonceur($this->twig, $this->menu, $this->chemin, $numeroAnnoneur, $this->cat->getCategories());

        return $response;
    }
}