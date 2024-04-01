<?php

namespace controller;

use model\Annonce;
use model\Categorie;

class Search {

    function show($twig, $menu, $chemin, $cat) {
        $template = $twig->load("search.html.twig");
        $menu = array(
            array('href' => $chemin,
                'text' => 'Acceuil'),
            array('href' => $chemin."/search",
                'text' => "Recherche")
        );
        echo $template->render(array(
            "breadcrumb" => $menu, 
            "chemin" => $chemin, 
            "categories" => $cat
        ));
    }

    function research($array, $twig, $menu, $chemin, $cat) {
        $template = $twig->load("index.html.twig");
        $menu = array(
            array('href' => $chemin,
                'text' => 'Acceuil'),
            array('href' => $chemin."/search",
                'text' => "Résultats de la recherche")
        );

        $nospace_mc = str_replace(' ', '', $array['motclef']);
        $nospace_cp = str_replace(' ', '', $array['codepostal']);


        $query = Annonce::select();

        if( ($nospace_mc === "") &&
            ($nospace_cp === "") &&
            (($array['categorie'] === "Toutes catégories" || $array['categorie'] === "-----")) &&
            ($array['prix-min'] === "Min") &&
            ( ($array['prix-max'] === "Max") || ($array['prix-max'] === "nolimit") ) ) {
            $annonce = Annonce::all();

        } else {
            // Si 'nospace_mc' n'est pas vide, 
            // on ajoute une condition à la requête pour rechercher 'motclef' dans 'description'
            $query->when($nospace_mc !== "", function ($query) use ($array) {
                return $query->where('description', 'like', '%'.$array['motclef'].'%');
            });
            
            // Si 'nospace_cp' n'est pas vide, 
            // on ajoute une condition à la requête pour que 'ville' soit égale à 'codepostal'
            $query->when($nospace_cp !== "", function ($query) use ($array) {
                return $query->where('ville', '=', $array['codepostal']);
            });
            
            // Si 'categorie' n'est ni égale à "Toutes catégories" ni égal à "-----", 
            // on ajoute une condition à la requête pour que 'id_categorie' soit égale à 'categorie'
            $query->when($array['categorie'] !== "Toutes catégories" && $array['categorie'] !== "-----", function ($query) use ($array) {
                $categ = Categorie::select('id_categorie')->where('id_categorie', '=', $array['categorie'])->first()->id_categorie;
                return $query->where('id_categorie', '=', $categ);
            });
            
            // Si 'prix-min' n'est pas égale à "Min" ou 'prix-max' n'est pas égale à "Max", 
            $query->when($array['prix-min'] !== "Min" || $array['prix-max'] !== "Max", function ($query) use ($array) {
                // on ajoute une condition à la requête pour que 'prix' soit entre 'prix-min' et 'prix-max',
                if($array['prix-max'] !== "nolimit") {
                    return $query->whereBetween('prix', array($array['prix-min'], $array['prix-max']));
                
                // ou supérieur à 'prix-min' si 'prix-max' est "nolimit"
                } else {
                    return $query->where('prix', '>=', $array['prix-min']);
                }
            });
            
            // Si 'prix-max' n'est ni égale à "Max" ni égale à"nolimit", 
            // on ajoute une condition à la requête pour que 'prix' soit inférieur ou égal à 'prix-max'
            $query->when($array['prix-max'] !== "Max" && $array['prix-max'] !== "nolimit", function ($query) use ($array) {
                return $query->where('prix', '<=', $array['prix-max']);
            });

            // Si 'prix-min' est différent de "Min", 
            // on ajoute une condition à la requête pour que 'prix' soit supérieur ou égal à 'prix-min'
            $query->when($array['prix-min'] !== "Min", function ($query) use ($array) {
                return $query->where('prix', '>=', $array['prix-min']);
            });

            $annonce = $query->get();
        }

        echo $template->render(array(
            "breadcrumb" => $menu, 
            "chemin" => $chemin, 
            "annonces" => $annonce, 
            "categories" => $cat)
        );

    }

}

?>
