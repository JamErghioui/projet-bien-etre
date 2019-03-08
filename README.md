# Bien-Être
Symfony 4 : Annuaire

Réalisation d’une application où des prestataires de services peuvent s’inscrire gratuitement et mettre en avant leurs services dans le domaine du bien-être.

## Setup :

1. composer install (cmd)
2. Configuration DATABASE_URL in .env
3. bin/console doctrine:database:create (cmd)
4. bin/console make:migration (cmd)
5. bin/console doctrine:migrations:migrate (cmd)
6. bin/console doctrine:fixtures:load (cmd)

## Comptes

| Level         | Email           | Mot de passe  |
| :-----------: |:---------------:| :------------:|
| Admin         | admin@admin.com | admin         |

## Fonctionnalités :

> 1.1

1. Consulter la description d'un service
2. Rechercher des prestataires
3. Consulter la fiche signalétique d'un prestataire
4. Consulter les catégories de services d'un prestataire

> 1.2

1. S'inscrirre
2. Confirmer l'inscription
3. S'authentifier

> 1.3

1. Gérer fiche Internaute
2. Gérer fiche Prestataire
3. Tenir à jour sa liste de catégories de services
4. Ajouter un stage

> 3

1. Laisser un commentaire
2. S'inscrire à la newsletter
