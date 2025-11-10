# 🚗 Car Blog - Application Fullstack Symfony & Twig

Une application complète de blog sur l'automobile développée avec **Symfony 6.4** et **Twig**, mettant en avant une interface moderne inspirée du design sur Dribbble.

## 📋 Table des matières

- [Objectif du projet](#objectif-du-projet)
- [Design](#design)
- [Fonctionnalités](#fonctionnalités)
- [Technologies utilisées](#technologies-utilisées)
- [Installation](#installation)
- [Configuration](#configuration)
- [Utilisation](#utilisation)
- [Identifiants de test](#identifiants-de-test)
- [Structure du projet](#structure-du-projet)
- [Captures d'écran](#captures-décran)

## 🎯 Objectif du projet

Développer une application complète de type blog avec Symfony 7 et Twig. L'application permet la gestion d'articles et de commentaires, inclut un système d'authentification, une interface inspirée d'un design Dribbble, et respecte les bonnes pratiques de structure et de sécurité.

## 🎨 Design

Le design de l'application est inspiré de cette maquette Dribbble :
**[Cars Blog - News & Reviews](https://dribbble.com/shots/21226299-Cars-Blog-News-Reviews)**

### Caractéristiques du design :
- ✅ Interface moderne et épurée
- ✅ Palette de couleurs vibrante (violet, bleu, vert, orange)
- ✅ Typographie Inter (Google Fonts)
- ✅ Mise en page responsive (mobile, tablette, desktop)
- ✅ Cartes d'articles avec catégories colorées
- ✅ Design cohérent sur toutes les pages

## ⚡ Fonctionnalités

### Pour tous les visiteurs
- 🏠 Page d'accueil avec articles récents
- 📰 Liste complète des articles avec pagination et tri
- 📖 Page de détail d'un article avec commentaires
- 🔍 Navigation fluide et intuitive

### Pour les utilisateurs connectés (ROLE_USER)
- 📝 Créer, éditer et supprimer ses propres articles
- 💬 Commenter les articles
- 🗑️ Supprimer ses propres commentaires
- 👤 Profil utilisateur

### Pour les administrateurs (ROLE_ADMIN)
- 🔧 Modifier et supprimer tous les articles
- 🗑️ Supprimer tous les commentaires
- 👥 Gestion complète du contenu

### Sécurité
- 🔐 Authentification par email/mot de passe
- 🛡️ Protection CSRF sur tous les formulaires
- 🔒 Contrôle d'accès par Voter
- ✅ Validation côté serveur

## 🛠 Technologies utilisées

- **Backend** : Symfony 6.4 (PHP >= 8.1)
- **Template Engine** : Twig
- **Base de données** : Doctrine ORM (MySQL / SQLite / PostgreSQL)
- **Authentification** : Symfony Security Bundle
- **Validation** : Symfony Validator
- **Frontend** : HTML5, CSS3 (vanilla, pas de framework CSS)
- **Typographie** : Google Fonts (Inter)

## 📥 Installation

### Prérequis

- PHP >= 8.1
- Composer
- MySQL / MariaDB ou SQLite
- Extension PHP : `pdo_mysql` (ou `pdo_sqlite` si vous utilisez SQLite)

### Étapes d'installation

1. **Cloner le dépôt**
```bash
git clone <URL_DU_DEPOT>
cd miniblog
```

2. **Installer les dépendances**
```bash
composer install
```

3. **Configurer la base de données**

Créez le fichier `.env.local` à la racine du projet :

**Option A - SQLite (recommandé pour le développement) :**
```bash
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
```

**Option B - MySQL :**
```bash
DATABASE_URL="mysql://root:@127.0.0.1:3306/miniblog_cars?serverVersion=8.0.32&charset=utf8mb4"
```

Si vous utilisez MySQL, assurez-vous que l'extension PHP est installée :
```bash
sudo apt-get install php-mysql
```

4. **Créer la base de données**
```bash
php bin/console doctrine:database:create
```

5. **Exécuter les migrations**
```bash
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

6. **Charger les fixtures (données de test)**
```bash
php bin/console doctrine:fixtures:load
```

Cette commande va créer :
- 1 administrateur
- 6 utilisateurs
- 12 articles sur les voitures
- Environ 30-50 commentaires

7. **Lancer le serveur de développement**
```bash
symfony serve
# ou
php -S localhost:8000 -t public
```

8. **Accéder à l'application**

Ouvrez votre navigateur et allez sur : `http://localhost:8000`

## ⚙️ Configuration

### Variables d'environnement

Le fichier `.env` contient les configurations par défaut. Créez un fichier `.env.local` pour vos configurations locales :

```bash
# Configuration de la base de données
DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"

# Environnement (dev / prod)
APP_ENV=dev
APP_SECRET=change_me_in_production
```

### Sécurité

La configuration de sécurité se trouve dans `config/packages/security.yaml` :
- Authentification par formulaire
- Protection CSRF activée
- Encodage des mots de passe : auto (bcrypt)
- Accès aux routes `/admin/*` réservé aux utilisateurs connectés

## 🎮 Utilisation

### Navigation dans l'application

1. **Page d'accueil** (`/`)
   - Affiche les 3 derniers articles
   - Section "All blog posts" avec pagination

2. **Page articles** (`/articles`)
   - Liste complète des articles
   - Tri par date ou titre
   - Pagination

3. **Détail d'un article** (`/articles/{slug}`)
   - Contenu complet de l'article
   - Commentaires
   - Formulaire pour commenter (si connecté)

4. **Connexion** (`/login`)
   - Formulaire de connexion
   - Identifiants de test fournis

5. **Gestion des articles** (`/admin/articles`)
   - Liste de vos articles
   - Créer un nouvel article
   - Éditer / Supprimer vos articles

### Créer un article

1. Connectez-vous avec un compte utilisateur
2. Cliquez sur "Mes articles" dans le menu
3. Cliquez sur "Nouvel article"
4. Remplissez le formulaire :
   - Titre (min 5 caractères)
   - Contenu (min 50 caractères)
   - Image (URL optionnelle)
   - Catégorie (optionnelle)
5. Cliquez sur "Créer l'article"

Le slug sera généré automatiquement à partir du titre.

### Commenter un article

1. Connectez-vous
2. Visitez un article
3. Scrollez jusqu'à la section commentaires
4. Remplissez le formulaire (min 10 caractères)
5. Cliquez sur "Publier le commentaire"

### Gérer les commentaires

- **Auteur du commentaire** : peut supprimer son propre commentaire
- **Administrateur** : peut supprimer tous les commentaires

## 🔑 Identifiants de test

### Administrateur
- **Email** : `admin@miniblog.com`
- **Mot de passe** : `admin123`
- **Droits** : Création, modification et suppression de tous les articles et commentaires

### Utilisateurs standards

1. **John Musk**
   - Email : `john.musk@example.com`
   - Mot de passe : `password123`

2. **Sarah Bradley**
   - Email : `sarah.bradley@example.com`
   - Mot de passe : `password123`

3. **Damian Type**
   - Email : `damian.type@example.com`
   - Mot de passe : `password123`

4. **Tesla Motors**
   - Email : `tesla.motors@example.com`
   - Mot de passe : `password123`

5. **Wade Morris**
   - Email : `wade.morris@example.com`
   - Mot de passe : `password123`

6. **Zev Klein**
   - Email : `zev.klein@example.com`
   - Mot de passe : `password123`

## 📁 Structure du projet

```
miniblog/
├── config/                  # Configuration Symfony
│   ├── packages/           # Configuration des bundles
│   └── routes/             # Configuration des routes
├── migrations/             # Migrations de base de données
├── public/                 # Dossier public (point d'entrée)
│   └── index.php          # Front controller
├── src/
│   ├── Controller/        # Contrôleurs
│   │   ├── HomeController.php
│   │   ├── ArticleController.php
│   │   ├── AdminArticleController.php
│   │   ├── CommentController.php
│   │   └── SecurityController.php
│   ├── Entity/            # Entités Doctrine
│   │   ├── User.php
│   │   ├── Article.php
│   │   └── Comment.php
│   ├── Form/              # Formulaires Symfony
│   │   ├── ArticleType.php
│   │   └── CommentType.php
│   ├── Repository/        # Repositories Doctrine
│   ├── Security/          # Sécurité (Voters)
│   │   └── Voter/
│   │       └── ArticleVoter.php
│   ├── Service/           # Services métier
│   │   └── SluggerService.php
│   └── DataFixtures/      # Fixtures (données de test)
│       └── AppFixtures.php
├── templates/             # Templates Twig
│   ├── base.html.twig    # Layout principal
│   ├── home/
│   ├── article/
│   ├── admin/
│   ├── security/
│   └── bundles/          # Pages d'erreur personnalisées
│       └── TwigBundle/
│           └── Exception/
├── .env                   # Configuration par défaut
├── composer.json          # Dépendances PHP
└── README.md             # Ce fichier
```

## 📸 Captures d'écran

### Page d'accueil
- Hero section avec formulaire d'inscription à la newsletter
- Section "Recent blog posts" avec 3 articles mis en avant
- Section "All blog posts" avec grille d'articles
- Footer complet avec liens

### Page Articles
- Liste complète avec pagination
- Système de tri (date, titre)
- Cartes d'articles avec image, titre, catégorie, auteur

### Détail d'un article
- En-tête avec titre, catégorie, date, auteur
- Image principale
- Contenu formaté
- Section auteur
- Commentaires avec possibilité d'ajouter/supprimer

### Administration
- Liste des articles de l'utilisateur
- Boutons d'actions (voir, éditer, supprimer)
- Formulaires de création/édition stylisés

### Pages d'erreur
- 404 personnalisée avec design cohérent
- 500 personnalisée
- Page d'erreur générale

## 🚀 Fonctionnalités avancées

### Système de slug automatique
Les slugs des articles sont générés automatiquement à partir du titre en utilisant le composant `String` de Symfony.

### Voter pour les permissions
Un `ArticleVoter` personnalisé contrôle les droits d'édition et de suppression :
- L'auteur peut modifier/supprimer ses articles
- Les admins peuvent tout modifier/supprimer

### Protection CSRF
Tous les formulaires sont protégés contre les attaques CSRF :
- Formulaires d'articles
- Formulaires de commentaires
- Boutons de suppression

### Validation côté serveur
Toutes les entités ont des contraintes de validation :
- `NotBlank` sur les champs obligatoires
- `Length` pour les longueurs min/max
- `Email` pour les adresses email
- Messages d'erreur en français

### Pages d'erreur personnalisées
- Template 404 stylisé
- Template 500 stylisé
- Template générique pour les autres erreurs

## 🧪 Tests

Pour tester l'application :

1. Créez un compte utilisateur ou utilisez les identifiants de test
2. Créez un article
3. Modifiez votre article
4. Ajoutez un commentaire
5. Connectez-vous en tant qu'admin et testez les droits étendus

## 📝 Bonnes pratiques respectées

- ✅ Architecture MVC avec Symfony
- ✅ Utilisation de Doctrine ORM
- ✅ Validation côté serveur
- ✅ Protection CSRF
- ✅ Authentification sécurisée
- ✅ Contrôle d'accès (Voter)
- ✅ Code PSR-4
- ✅ Templates Twig bien structurés
- ✅ Messages flash pour les retours utilisateur
- ✅ Responsive design
- ✅ Accessibilité
- ✅ Pages d'erreur personnalisées

## 📚 Ressources

- [Documentation Symfony](https://symfony.com/doc/current/index.html)
- [Documentation Twig](https://twig.symfony.com/doc/)
- [Documentation Doctrine](https://www.doctrine-project.org/projects/doctrine-orm/en/current/index.html)
- [Design Dribbble](https://dribbble.com/shots/21226299-Cars-Blog-News-Reviews)

## 👨‍💻 Auteur

Projet réalisé dans le cadre du cours Symfony - EEMI

## 📄 Licence

Ce projet est réalisé à des fins éducatives.

---

**🚗 Happy Coding! 💨**

