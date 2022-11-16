# TRIBU

*Meet, Visit, Share it, Repeat*

Tribu est le réseau social pour les français expatriés.  
Quand on part pour un autre pays, il peut être difficile de retrouver une vie sociale.  
Grâce à cette appli web, retrouvez les lieux d’intérêt de la communauté, rencontrez les français déjà installés et leurs connaissances, accueillez les nouveaux arrivants,
Démarrez votre nouvelle vie !

## Installation
1. Lancer `composer install`
2. Créer et configuer configurer le `.env.local`
  - login et mot de passe d'Adminer/PhpAdmin
  - verifier la verison de mysql ```mysql --version```
  - ```DATABASE_URL="mysql://login:password@127.0.0.1:3306/tribu?serverVersion=10.3.25-MariaDB&charset=utf8mb4"```
3. Lancer les commandes:
  - `bin/console doctrine:database:create`
  - `bin/console doctrine:migrations:migrate`
  - `bin/console doctrine:fixtures:load`
4. Lancer JWT token avec la commande qui genere les clés SSL
  - `bin/console lexik:jwt:generate-keypair`
