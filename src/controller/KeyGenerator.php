<?php

namespace App\controller;

use App\model\ApiKey;

class KeyGenerator {

    function show(\Twig\Environment $twig, array $menu, string $chemin, $cat) : void {
        $template = $twig->load("key-generator.html.twig");

        echo $template->render(array(
            "breadcrumb" => $this->sendMenu($chemin), 
            "chemin" => $chemin, 
            "categories" => $cat
        ));
    }

    function generateKey(\Twig\Environment $twig, array $menu, string $chemin, $cat, string $nom) : void {
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

    public function sendMenu(string $chemin) : array {
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
