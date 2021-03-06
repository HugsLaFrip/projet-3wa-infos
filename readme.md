## Pré-requis

* PHP 7.2.5
* Composer
* Git

## Récupérer le repository

```bash
git clone https://github.com/HugsLaFrip/projet-3wa-infos.git
```

## Installer les dépendances

```bash
cd projet-3wa-infos
composer install
php bin/console assets:install
```

## Préparer la base de données

Spécifiez vos informations de connexion à votre base de données dans le fichier ***.env***

Remplacer :
  * **db_user** => identifiant de connexion à votre base de données
  * **db_password** => mot de passe de connexion à votre base de données
  * **db_name** => nom de la base de données

```bash
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7"
```

Lancez ensuite cette suite de commande pour créer et remplir votre base de données

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```

## Lancement de l'application

Démarrez votre serveur local

```bash
php -S localhost:8000 -t public
```

Ouvrez votre navigateur favori et saisissez l'URL " localhost:8000 "

Connectez-vous en tant qu'administrateur à l'aide de ces codes :
  * **Email** => admin@admin.fr
  * **Mot de passe** => Admin*12  


Enjoy !