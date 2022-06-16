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

## Création des utilisateurs

Pour créer une table utilisateur (pas obligation d'être une table) avec des permissions:

        php bin/console make:user

Voir user dans :

https://symfony.com/doc/current/security.html

Création de `src/Entity/TheUsers.php` et modification de `config/packages/security.yaml`

On peut le modifier avant la migration avec 

        php bin/console make:entity TheUsers

Puis faire la migration:

        php bin/console make:migration

        php bin/console doctrine:migrations:migrate

## création de l'authentification

        php bin/console make:auth

avec login et logout

### création d'un utilisateur

        php bin/console security:hash-password

Puis on insert dans la table the_user

### connexion

On va sur /login

On peut se connecter avec util1 / util1 pour avoir le rôle ROLE_USER

Dans la DB que vous pouvez importer ( `datas/simpleprojectlts-v1.sql` )

## Jointure entre articles et utilisateurs

        php bin/console make:entity TheArticles

Puis on a choisi ManyToOne vers TheUsers

### On va bloquer l'accès au dossier admin

Dans `config/packages/security.yaml` on va permettre aux admins d'accéder au dossier `admin` et `profile`, les simples utilisateurs juste au `profile`, donc inaccessibles aux utilisateurs non connectés

        ...
            # Easy way to control access for large sections of your site
            # Note: Only the *first* access control that matches will be used
    access_control:
         access_control:
        - { path: ^/admin, roles: ROLE_ADMIN }
        - { path: ^/profile, roles: [ROLE_ADMIN, ROLE_USER] }
        ...

Menu, si on est identifié ou pas, USER ou ADMIN, on peut le vérifier en Twig

        
        templates/public/index.html.twig

        ...
        <li><a href="{{ path('homepage') }}">Accueil</a></li>
        {% if is_granted('IS_AUTHENTICATED_FULLY') %}
            {% if is_granted('ROLE_ADMIN') %}
                <li><a href="/admin">administration</a></li>
            {% endif %}
            <li><a href="/profile">profil</a></li>
            <li><a href="{{ path('app_logout') }}">Logout</a></li>
        {% else %}
            <li><a href="{{ path('app_login') }}">Connect</a></li>
        {% endif %}