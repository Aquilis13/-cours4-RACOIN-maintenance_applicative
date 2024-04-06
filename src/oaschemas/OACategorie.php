<?php

namespace App\oaschemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 * 
 */
class OACategorie {
    
    /**
     * @OA\Property(type="integer")
     * @var int
     * 
     */
    private int $id_categorie;

    /**
     * @OA\Property(type="string")
     * @var string
     * 
     */
    private string $nom_categorie;

    /**
     * @OA\Property(type="array")
     * @var array
     */
    private array $links;
}