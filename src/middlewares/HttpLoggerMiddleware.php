<?php

namespace App\middlewares;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use App\utils\RacoinLogger;

class HttpLoggerMiddleware {

    private $today;  
    private $logFile;

    public function __invoke(Request $request, RequestHandler $handler): Response {
        $uri  = $request->getUri();
        $methode = $request->getMethod();
        $ipClient = $this->getClientIP();

        $this->today = date("Y-m-d");
        $this->logFile = "../logs/http/$this->today.log";


        // On crée le fichier s'il existe pas encore
        $logDir = dirname($this->logFile);
        if (!file_exists($logDir)) {
            mkdir($logDir, 0777, true);
        }

        // On enregistre le log dans le fichier correspondant à la date du jour dans un dossier http
        $logger = new RacoinLogger(
            "($ipClient) Send HTTP request : [$methode] $uri", 
            "info", 
            $this->logFile
        );

        // On continue le traitement de la requête
        return $handler->handle($request);
    }

    /**
     * Retourne l'ip du client
     * 
     */
    function getClientIP(){
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $clientIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $clientIP = $_SERVER['REMOTE_ADDR'];
        }

        return $clientIP;
    }
}