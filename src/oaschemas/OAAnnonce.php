<?php

namespace App\oaschemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema()
 * 
 */
class OAAnnonce {
    
    /**
     * @OA\Property(type="integer")
     * @var int
     * 
     */
    public int $id_annonce;
    
    /**
     * @OA\Property(type="float")
     * @var float
     * 
     */
    public float $prix;
    
    /**
     * @OA\Property(type="string")
     * @var string
     * 
     */
    public string $titre;
    
    /**
     * @OA\Property(type="string")
     * @var string
     * 
     */
    public string $ville;
}