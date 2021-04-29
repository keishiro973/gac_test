# gac_test

Installation

lancer la commande
```
composer install
```

création de la base de donnée avec les identifiant:mdp:port root:root:3306
```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```
