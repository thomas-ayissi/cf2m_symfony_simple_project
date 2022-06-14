# simpleprojectlts


Projet depuis la version LTS

## Installation

        symfony new simpleprojectlts --webapp --version=lts

## Création du contrôleur

        php bin/console make:controller

On choisit PublicController, puis on met le lien vers la racine `src/Controller/PublicController.php`

        ...
        #[Route('/', name: 'homepage')]
    public function index(): Response
        ...

### Lancement du serveur

        symfony serve -d

On peut voir le site ici: 

https://127.0.0.1:8000/

### Création du fichier de configuration

On enregistre .env en .env.local

Pour passer du mode dev à prod :

        .env.local
        ...
        # APP_ENV=dev en
        APP_ENV=prod

Pour voir les routes:

        php bin/console debug:router

## Création d'une entité

Seront nos 'objets' traités comme des tables en SQL (+= mapping de table)

        php bin/console make:entity

## DB

Dans .env.local, on fait un lien vers le serveur de données:

        DATABASE_URL="mysql://root:@127.0.0.1:3307/simpleprojectlts?charset=utf8mb4"

Dans l'invite de commande, on crée la DB : 

        php bin/console doctrine:database:create

Elle est créée

### Première migration

Création du fichier de migration :

        php bin/console make:migration

crée par exemple `migrations/Version20220614141804.php`

Pour migrer (!pertes de données possibles) :

        php bin/console doctrine:migrations:migrate

Pour vérifier si on est à jour:

        php bin/console doctrine:migrations:up-to-date