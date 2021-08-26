## TBB WILLFRID DONGMO
shopPeinture est un site de presentaion de peinture
## Environnement de developpement
### Prés-requis

* PHP 7.4
* Composer
* Symfony CLI
* Docker
* Docker-compose
* node js et npm 
vous pouvez verifier les prés-requis (sauf Docker et Docker-compose) avec la commande suivantes (de la CLI Symfony):

```bash
composer install
npm rund build
docker-compose up -d
symfony serve -d
```
## Lancer des tests
``bash
php bin/phpunit --testdox
``

##  npm install sass-loader@^12.0.0 sass --save-dev