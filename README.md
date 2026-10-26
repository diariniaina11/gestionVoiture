# Gestion de voitures

Application PHP de gestion des personnes et des voitures, avec une base de
données MySQL/MariaDB. Le script `gestionvoiture.sql` contient le schéma et
des données d’exemple.

## Gestion du cache

Le cache des données est géré par la classe `cacheDonnees`, dans
`Modele/Repository/cacheDonnees.php`. Il évite de relancer certaines lectures
SQL lorsque les mêmes listes sont demandées plusieurs fois.

### Technologie utilisée

Le mécanisme privilégie **APCu**, l’extension de cache en mémoire de PHP, si
elle est installée et activée. Il n’utilise pas Redis ni Memcached. Si APCu
n’est pas disponible, le cache bascule sur la **session PHP** (`$_SESSION`).
Ce mode de secours conserve les résultats pour la session de l’utilisateur ;
il ne constitue donc pas un cache partagé entre tous les utilisateurs.

### Fonctionnement

La méthode `remember` reçoit une clé et une fonction qui charge les données :

1. Elle recherche d’abord la clé dans APCu ou, à défaut, dans la session.
2. Si une valeur non expirée existe, elle la retourne sans exécuter la requête
   SQL.
3. En cas d’absence ou d’expiration, elle exécute la fonction de chargement,
   mémorise le résultat, puis le retourne.
4. Les entrées expirent après **60 secondes** (`DUREE_VIE`).

Les listes actuellement mises en cache sont :

- `personnes`, chargée par `transactionPersonne::getAll()`.
- `voitures`, chargée par `transactionVoiture::getAll()`.

Après une insertion ou une mise à jour réussie d’une personne, la liste des
personnes est invalidée. Après une suppression réussie, les listes des
personnes et des voitures sont invalidées, car la suppression d’une personne
peut également supprimer ses voitures (contrainte de clé étrangère avec
suppression en cascade). Une insertion réussie de voiture invalide la liste des
voitures.

L’expiration après 60 secondes est une limite de validité ; les opérations de
modification invalident aussi explicitement les données concernées afin que la
prochaine lecture recharge les valeurs à jour.

### Cache des fichiers statiques

À part ce cache de données PHP, `View/Voiture/.htaccess` applique aux images,
fichiers CSS et JavaScript l’en-tête HTTP
`Cache-Control: no-cache, must-revalidate`. Cela demande au navigateur de
revalider ces ressources avant de les réutiliser ; ce n’est pas le cache APCu
et ce réglage ne met pas les listes SQL en cache.

## Installation locale

1. Placez le projet dans le répertoire de votre serveur PHP (par exemple
   `htdocs` sous XAMPP).
2. Importez `gestionvoiture.sql` dans MySQL/MariaDB.
3. Vérifiez les paramètres de connexion dans
   `Modele/Repository/Connexion/connexion.php` (par défaut : hôte `localhost`,
   base `gestionvoiture`, utilisateur `root`, mot de passe vide).
4. Ouvrez le projet depuis votre serveur web.

Pour utiliser APCu, installez et activez l’extension APCu dans la configuration
PHP du serveur. Sans cette extension, l’application utilise automatiquement le
cache de session.
