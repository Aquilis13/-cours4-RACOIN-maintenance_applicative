<?php

namespace actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use model\Categorie;
use model\Annonceur;
use model\Departement;

/**
 * Route : [GET] -> /api/annonce/{id}
 */
final class DisplayAnnonceByIdAction {

    private $app;

    public function __construct($app) {
        $this->app = $app;
    }

    public function __invoke(Request $request, Response $response, array $args): Response {
        $id          = $args['id'];
        $annonceList = ['id_annonce', 'id_categorie as categorie', 'id_annonceur as annonceur', 'id_departement as departement', 'prix', 'date', 'titre', 'description', 'ville'];
        $return      = Annonce::select($annonceList)->find($id);

        if (isset($return)) {
            $response->headers->set('Content-Type', 'application/json');
            $return->categorie     = Categorie::find($return->categorie);
            $return->annonceur     = Annonceur::select('email', 'nom_annonceur', 'telephone')
                ->find($return->annonceur);
            $return->departement   = Departement::select('id_departement', 'nom_departement')->find($return->departement);
            $links                 = [];
            $links['self']['href'] = '/api/annonce/' . $return->id_annonce;
            $return->links         = $links;
            echo $return->toJson();
        } else {
            $this->app->notFound();
        }

        return $response;
    }
}