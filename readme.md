## Pré-requis

* PHP 7.2.5
* Composer


## Installer les dépendances

```bash
composer install
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

Démarrer votre serveur local

```bash
php -S localhost:8000 -t public
```

Ouvrez votre navigateur favori et saisissez l'URL " localhost:8000 "
Enjoy !