## Nom
`CHANOT Flora`

## Racoin

Racoin est une application de vente en ligne entre particulier.

## Installation
Les commandes suivantes permettent d'installer les dépendances et de construire les fichiers statiques nécessaires au bon fonctionnement de l'application.
```bash
cp config/config.ini.dist config/config.ini
docker compose run --rm php composer install
docker compose run --rm php php sql/initdb.php
docker compose run node npm install
docker compose run node npm run build

```

## Utilisation
Pour lancer l'application, il suffit de lancer la commande suivante:
```bash
docker compose up
```

### Url pour la documentation :  
http://0.0.0.0:8080/doc

### Emplacement des fichiers de logs générés : 
`/logs`

Exemple de logs :
``` JavaScript
[2024-04-06T00:21:09.522124+00:00] racoin.logs.INFO: (172.0.0.0) Send HTTP request : [GET] http://172.168.42.80:8083/openapi [] []
[2024-04-06T00:21:35.351841+00:00] racoin.logs.INFO: (172.0.0.0) Send HTTP request : [GET] http://172.168.42.80:8083/ [] []
[2024-04-06T00:21:40.183391+00:00] racoin.logs.INFO: (172.0.0.0) Send HTTP request : [GET] http://172.168.42.80:8083/item/2 [] []
[2024-04-06T00:21:44.345586+00:00] racoin.logs.INFO: (172.0.0.0) Send HTTP request : [GET] http://172.168.42.80:8083/annonceur/2 [] []
[2024-04-06T00:21:50.080833+00:00] racoin.logs.INFO: (172.0.0.0) Send HTTP request : [GET] http://172.168.42.80:8083/search [] []
[2024-04-06T00:21:55.833071+00:00] racoin.logs.INFO: (172.0.0.0) Send HTTP request : [POST] http://172.168.42.80:8083/search [] []
[2024-04-06T00:21:58.283713+00:00] racoin.logs.INFO: (172.0.0.0) Send HTTP request : [GET] http://172.168.42.80:8083/ [] []
```