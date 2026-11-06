# Art de Rue

Application Symfony 8.1 / PHP 8.4 minimum, avec une base MySQL/MariaDB.

## Prérequis

- PHP 8.4 minimum et Composer 2.
- Un serveur MySQL/MariaDB démarré et un utilisateur autorisé à créer la base et ses tables (ou une base vide déjà créée par un administrateur). Les migrations sont écrites pour MySQL/MariaDB.
- L’extension PHP `pdo_mysql`, ainsi que les extensions demandées par Composer. Vérifier avec `composer check-platform-reqs` après installation. Le formulaire d’image utilise également la détection MIME de PHP (`fileinfo`).
- Symfony CLI recommandé pour lancer le serveur local. Node.js et npm ne sont pas nécessaires pour cette installation : le projet utilise AssetMapper.
- Un accès Internet pendant l’installation Composer ; Bootstrap CSS et JavaScript sont chargés depuis le CDN jsDelivr dans le navigateur.

## Installation après un clonage

Exécuter toutes les commandes depuis la racine du projet. Garder les dépendances de développement : les fixtures sont disponibles dans les environnements `dev` et `test` et ne sont pas installées avec `composer install --no-dev`.

```bash
composer install
```

Créer un fichier `.env.local` (non versionné) avec les identifiants de votre base locale :

```dotenv
APP_ENV=dev
APP_SECRET=remplacer_par_une_valeur_aleatoire_locale
DATABASE_URL="mysql://utilisateur:mot_de_passe@127.0.0.1:3306/art_de_rue?serverVersion=11.8.6-MariaDB&charset=utf8mb4"
```

Générer une valeur pour `APP_SECRET` avec `php -r 'echo bin2hex(random_bytes(32)), PHP_EOL;'` et la recopier dans `.env.local`. Adapter l’utilisateur, le mot de passe, le nom de la base et la version du serveur. Encoder les caractères réservés de l’utilisateur ou du mot de passe dans l’URL (par exemple `@` devient `%40`).

Puis lancer :

```bash
php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console doctrine:fixtures:load --no-interaction
symfony serve -d
```

Ouvrir l’adresse indiquée par Symfony CLI. Sans Symfony CLI : `php -S 127.0.0.1:8000 -t public`, puis ouvrir <http://127.0.0.1:8000/>.

Si la création de la base renvoie « Access denied », demander sa création à l’administrateur MySQL/MariaDB, adapter `DATABASE_URL`, puis reprendre à la commande de migrations. Ne pas utiliser `make:migration` pour récupérer les données : les migrations existantes créent les tables et les fixtures ajoutent le catalogue.

**Attention : le chargement des fixtures efface les données de la base configurée avant de recréer le catalogue. Utiliser une base de développement dédiée.** Ne pas utiliser `--append` : les comptes existent déjà après un premier chargement.

## Comptes de démonstration

| Email | Mot de passe |
| --- | --- |
| `mail.test@gmail.com` | `123` |
| `mail.test2@gmail.com` | `123` |

Ces identifiants sont publics et réservés aux tests. Les mots de passe sont hachés par Symfony au chargement ; aucun ancien hash de compte n’est copié.
Les fixtures attribuent toutes les photos au compte mail.test@gmail.com. Seul ce compte peut donc les modifier ou les supprimer.

## Données et photos

Une seule fixture, `src/DataFixtures/AppFixtures.php`, contient l’instantané du catalogue : 2 bénévoles, 5 artistes, 8 techniques, 15 lieux, 20 œuvres et 22 photos, avec leurs descriptions, dates et associations. Les identifiants sont régénérés par la base ; les relations sont reconstruites indépendamment de leurs anciennes valeurs.

**Toutes les photos chargées par cette fixture appartiennent à `mail.test@gmail.com`.** Une fixture peut attribuer un propriétaire exactement comme le formulaire de création. Ce compte peut donc consulter, modifier et supprimer ces photos ; le second compte n’en est pas propriétaire. Les contrôleurs vérifient le propriétaire : masquer les boutons n’est pas la seule protection.

Les nouvelles photos créées depuis le site appartiennent au bénévole connecté. Les œuvres, artistes, lieux et techniques n’ont pas de propriétaire bénévole dans le modèle actuel.

Les 22 images de la fixture doivent être présentes dans `public/Photos/demo/` après le clonage : les fixtures enregistrent leurs chemins sans les télécharger. Les licences et crédits se trouvent dans `data/demo/CREDITS.md` et `public/Photos/demo/CREDITS.txt`. Les données de catalogue sont fictives, avec des photographies illustratives et certaines dates de suivi fictives signalées dans les commentaires.

Les contrôles d’accès protègent les actions et les fiches Photo. Les fichiers dans `public/Photos/` restent accessibles directement par leur URL.

Le catalogue de la fixture est un instantané : les changements faits ensuite sur le site ne mettent pas automatiquement ce fichier à jour.

Les nouveaux téléversements sont enregistrés dans `public/Photo/` (sans **s**). Ce dossier, ainsi que `var/`, doit être accessible en écriture au processus PHP. `Photo/` et `Photos/` sont deux dossiers distincts : ne pas les renommer.

## Accès au site

- `/` : accueil accessible sans connexion ; les liens de gestion du menu sont masqués pour les visiteurs.
- `/login` : connexion. Les autres routes applicatives nécessitent une connexion et redirigent les visiteurs vers cette page.
- `/artiste`, `/technique`, `/lieu`, `/oeuvre` : gestion commune aux bénévoles connectés.
- `/benevole` : liste et fiches accessibles aux bénévoles connectés ; chaque compte ne peut modifier ou supprimer que son propre compte. La création d’un bénévole nécessite également une connexion.
- `/photo` : liste limitée aux photos du compte connecté ; les routes de consultation, modification et suppression vérifient le propriétaire. Après chargement des fixtures, le premier compte voit 22 photos et le second aucune. Les images peuvent néanmoins apparaître dans l’accueil et les fiches Œuvre.
- La déconnexion redirige vers l’accueil.

## Vérifications

```bash
composer check-platform-reqs
php bin/console lint:container
php bin/console lint:twig templates/
php bin/console lint:yaml config/
php bin/console doctrine:schema:validate
php bin/phpunit
```

`doctrine:schema:validate` nécessite une base accessible et migrée. Le test actuel `tests/AppFixturesTest.php` vérifie les effectifs, les mots de passe, les relations, les propriétaires et la présence des images avec un gestionnaire Doctrine simulé : il ne purge pas de base et ne teste pas les routes HTTP.

## Fichiers à inclure dans le dépôt

Pour qu’un clonage permette cette installation, versionner le code, `composer.json`, `composer.lock`, `symfony.lock`, `config/`, `src/Migrations/`, `src/DataFixtures/`, `tests/`, `assets/`, les images de `public/Photos/demo/`, les crédits et ce README. Vérifier `git status` : un fichier encore non suivi ne sera pas récupéré par un clonage.

Ne pas versionner `.env.local`, `vendor/` ou `var/` ; `.gitignore` les exclut déjà. `.env` contient uniquement les valeurs par défaut.
