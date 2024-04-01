<?php

namespace controller;

use model\ApiKey;

class KeyGenerator {

    function show($twig, $menu, $chemin, $cat) {
        $template = $twig->load("key-generator.html.twig");

        echo $template->render(array(
            "breadcrumb" => $this->sendMenu($chemin), 
            "chemin" => $chemin, 
            "categories" => $cat
        ));
    }

    function generateKey($twig, $menu, $chemin, $cat, $nom) {
        $nospace_nom = str_replace(' ', '', $nom);

        if($nospace_nom === '') {
            $template = $twig->load("key-generator-error.html.twig");

            echo $template->render(array(
                "breadcrumb" => $this->sendMenu($chemin), 
                "chemin" => $chemin, 
                "categories" => $cat
            ));
        } else {
            $template = $twig->load("key-generator-result.html.twig");

            // Génere clé unique de 13 caractères
            $key = uniqid();
            // Ajouter clé dans la base
            $apikey = new ApiKey();

            $apikey->id_apikey = $key;
            $apikey->name_key = htmlentities($nom);
            $apikey->save();

            echo $template->render(array(
                "breadcrumb" => $this->sendMenu($chemin), 
                "chemin" => $chemin, 
                "categories" => $cat, 
                "key" => $key));
        }

    }

    public function sendMenu($chemin){
        return array(
            array(
                'href' => $chemin,
                'text' => 'Acceuil'
            ),
            array(
                'href' => $chemin."/search",
                'text' => "Recherche"
            )
        );
    }
}

?>
