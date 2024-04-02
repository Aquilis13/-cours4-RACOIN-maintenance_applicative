<?php

namespace App\controller;

use App\model\Departement;

class getDepartment {

    protected array $departments = array();

    public function getAllDepartments() : array {
        return Departement::orderBy('nom_departement')->get()->toArray();
    }
}