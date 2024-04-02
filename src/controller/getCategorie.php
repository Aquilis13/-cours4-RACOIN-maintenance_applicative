<?php

namespace App\controller;

use App\model\Categorie;
use App\model\Annonce;
use App\model\Photo;
use App\model\Annonceur;

class getCategorie {

    protected array $categories = array();

    public function getCategories() : array {
        return Categorie::orderBy('nom_categorie')->get()->toArray();
    }

    public function getCategorieContent(string $chemin, string $idCategorie) : void {
        $tmp = Annonce::with("Annonceur")->orderBy('id_annonce','desc')->where('id_categorie', "=", $idCategorie)->get();
        $annonce = [];
        foreach($tmp as $t) {
            $t->nb_photo = Photo::where("id_annonce", "=", $t->id_annonce)->count();
            if($t->nb_photo > 0){
                $t->url_photo = Photo::select("url_photo")
                    ->where("id_annonce", "=", $t->id_annonce)
                    ->first()->url_photo;
            }else{
                $t->url_photo = $chemin.'/img/noimg.png';
            }
            $t->nom_annonceur = Annonceur::select("nom_annonceur")
                ->where("id_annonceur", "=", $t->id_annonceur)
                ->first()->nom_annonceur;
            array_push($annonce, $t);
        }
        $this->annonce = $annonce;
    }
 
    public function displayCategorie(\Twig\Environment $twig, array $menu, string $chemin, $cat, string $idCategorie) : void {
        $template = $twig->load("index.html.twig");
        $menu = array(
            array('href' => $chemin,
                'text' => 'Acceuil'),
            array('href' => $chemin."/cat/".$idCategorie,
                'text' => Categorie::find($idCategorie)->nom_categorie)
        );

        $this->getCategorieContent($chemin, $idCategorie);
        echo $template->render(array(
            "breadcrumb" => $menu,
            "chemin" => $chemin,
            "categories" => $cat,
            "annonces" => $this->annonce));
    }
}
