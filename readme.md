## TBB WILLFRID DONGMO
shopPeinture est un site de presentaion de peinture
## Environnement de developpement
### Prés-requis

* PHP 7.4
* Composer
* Symfony CLI
* Docker
* Docker-compose
vous pouvez verifier les prés-requis (sauf Docker et Docker-compose) avec la commande suivantes (de la CLI Symfony):

```bash
docker-compose up -d
symfony serve -d
```
## Lancer des tests
``bash
php bin/phpunit --testdox
``