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

## Installation du template

En utilisant le dossier `datas/template`

On divise les pages dans `templates` en modifiant légèrement `templates/base.html.twig` (les premières lignes pour correspondre au thème).

! Il faut laisser les blocs qui seront remplis par Webpack-Encore depuis le dossier `assets`

        {% block stylesheets %}
            {{ encore_entry_link_tags('app') }}
        {% endblock %}

        {% block javascripts %}
            {{ encore_entry_script_tags('app') }}
        {% endblock %}

On a créé `templates/public/public.template.html.twig`, enfant de `templates/base.html.twig`, pour pouvoir y copier le code dans des blocs depuis `datas/template/index.html`

Puis on liera `templates/public/index.html.twig` comme enfant de `templates/public/public.template.html.twig` et on changera le block `content`

### Gestion des fichiers front-end

On pourrait mettre les fichiers directement dans le dossier publique, près du contrôleur frontal, mais on va tenter d'utiliser Webpack pour le faire.

Dans le dossier `assets` on va placer les fichier css et js du template

On a donc `assets/scripts.js` et `assets/styles/styles.css` en plus dans le dossier

Ensuite on va les rajouter dans

        assets/app.js
        ...
        // any CSS you import will output into a single css file (app.css in this case)
        import './styles/app.css';
        import './styles/styles.css';
        
        // start the Stimulus application
        import './bootstrap';
        import './scripts';
        ...

On va tenter de compiler avec un

        npm run build

Les fichiers front-end sont créés dans le dossier `public/build`

Vous pouvez toujours rajouter des dossiers et fichiers manuellement dans `public` en cas de bug, on par facilité.

La bonne pratique étant d'utiliser des CDN (Content Delivery Network) publiques (et forts utilisés), car ils sont sur des serveurs puissants et peuvent se trouver dans le cache du navigateur des utilisateurs (venant d'autres sites). Ils ne sont pas comptés dans le temps de chargement d'une page par Google.

### template pour login

On fait hériter `templates/security/login.html.twig` de notre template, on change le block `body` par `content`

Lien bootstrap :

https://getbootstrap.com/docs/5.2/forms/overview/#content

Pour rester connecté (dans la base de donnée) :

https://symfony.com/doc/current/security/remember_me.html

Donc dans `config/packages/security.yaml`:

        main:
            # ...
            remember_me:
                secret:   '%kernel.secret%' # required
                lifetime: 604800 # 1 week in seconds
                token_provider:
                    doctrine: true

Dans `src/Security/LoginAuthenticator.php` :

        ...
        use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
        ...
        public function authenticate(Request $request): Passport
    {
        $username = $request->request->get('username', '');

        $request->getSession()->set(Security::LAST_USERNAME, $username);

        return new Passport(
            new UserBadge($username),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
                new RememberMeBadge(),
            ]
        );
    }
        

Puis:

        php bin/console doctrine:migrations:diff

        php bin/console doctrine:migrations:migrate

Et dans notre menu connecté/déconnecté `templates/public/public.template.html.twig`

        {% if is_granted('IS_AUTHENTICATED_FULLY') or is_granted('IS_AUTHENTICATED_REMEMBERED') %}