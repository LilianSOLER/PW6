% PW-DOM  TP2  Antennes Wifi

# Données ouvertes de la ville de Grenoble

Technologies : csv, filtres unix, géocodage, json.

Dans cet exercice, on va utiliser la plateforme [Data Métropole](http://data.beta.metropole-grenoble.fr/)
pour récupérer des données institutionnelles et les retraiter.
Quels organismes participent à ce site ?

Récupérez le jeu de données des points d'accès wifi de la ville de Grenoble,
dans les deux formats, CSV et GeoJSON.
Pour information, vous pouvez aussi les visualiser sur 
<https://framacarte.org/en/map/points-dacces-wifi-municipaux-a-grenoble_5185>.

L'exercice se fait majoritairement en PHP ligne de commande. Vous pouvez toutefois le faire 
en mode web (apache mod\_php) si vous préférez, mais le débogage est parfois plus pénible.

## Points d'accès wifi

### Filtres Unix

0. **Visualisation texte**.
Testez le fichier avec les commandes `cat` et `less`, et vérifier l'encodage avec `file`. 
Si nécessaire, utilisez un réencodage pour votre système avec la commande 
`iconv -f latin1 -t utf8` (par exemple)
OU BIEN récupérez la variante qui vous convient le mieux dans le dossier `Données` sur Moodle.

1. **Comptage**. 
À partir du format CSV en ligne de commande, pouvez-vous évaluer le nombre de points d'accès ?
   Rappel : les filtres unix les plus utiles sont `grep`, `cut`, `sort`, `uniq`, `wc`, `head`, `tail`, `cat`.

2. **Points multiples**. Vous constatez que d'après le fichier, plusieurs emplacements sont munis de plusieurs points d'accès (par exemple les bibliothèques).
   Combien y a-t-il d'emplacements différents ? Lequel possède le plus de points d'accès, et combien ?


### Traitements PHP
3. **Comptage PHP**. Cette fois, comptez les points d'accès, mais à partir d'une routine écrite en PHP.
   Aide : utilisez la fonction [file](http://php.net/manual/fr/function.file.php) qui transforme
   un fichier texte en tableau, un élément (chaîne de caractères) par ligne.

4. **Structure de données**. 
Utilisez les fonctions CSV de PHP pour parcourir les données et créer une structure de
   données pratique, par exemple chaque ligne sera représentée par un tableau associatif de 
   clés `name`, `adr`, `lon`, `lat` (suggestion).
   Rappels : [fgetcsv](http://php.net/manual/fr/function.fgetcsv.php) 
   ou [str\_getcsv](http://php.net/manual/fr/function.str-getcsv.php) vous seront utiles, ainsi 
   que certaines fonctions de [gestion des tableaux](http://php.net/manual/fr/book.array.php).

5. **Proximité**. 
Supposons que vous soyez au centre de la place Grenette (coordonnées *lat=45.19102, lon=5.72752*).
   Affichez tous les points d'accès wifi (noms) avec leur distance, puis tous les points d'accès à moins de 200 m.
   Combien y en a-t-il ? Quel est le plus proche ?
   Le calcul de la distance se fera avec la fonction donnée dans `tp2-helpers.php`.

6. **Proximité top N**. 
Affichez maintenant les `N`=5 points d'accès les plus proches de vous. 
N est un paramètre entré manuellement.
   (en argument en ligne de commande ou par l'url si vous êtes en mode web). 
   Vous aurez probablement besoin de trier les données, en vous aidant de la fonction
   [array\_multisort](http://php.net/manual/en/function.array-multisort.php)
   (tri de tableaux multiples).

7. **Géocodage**. 
On aimerait avoir l'adresse de chaque point d'accès, mais elle n'est pas fournie 
   par le jeu de données.
   Pour pallier ce problème, on va utiliser un service de **géocodage inverse**, 
   qui renvoie une adresse à partir des coordonnées (le géocodage direct renvoie des coordonnées à partir d'une adresse).
   Vous pouvez facilement utiliser le géocodeur officiel français, qui s'appuie sur les données 
de la Poste et de l'IGN : <https://adresse.data.gouv.fr/api>

Avec ce service, nous avons affaire à une API REST classique. 
La fonction `smartcurl()` des helpers peut vous aider.
Si le géocodage inverse aboutit, ajoutez l'adresse à la liste des points d'accès.


8. **Webservice**. 
Transformez cela en webservice, qui lit les paramètres (en url) `top`, `lon`, `lat` 
et qui fournit une réponse en json constitué des `top` points d'accès les plus proches.

9. **Format json**. 
Adaptez la procédure de lecture du fichier de données pour utiliser plutôt les données au format geojson,
   mais en utilisant la même structure de données interne pour chaque ligne.
   Rappel : la fonction [json\_decode](http://php.net/manual/fr/function.json-decode.php) vous aidera grandement.

10. **Client webservice**. 
Écrivez une page web (html/php) avec un formulaire permettant de saisir 
la longitude, la latitude et le nombre de points d'accès à afficher, 
puis qui traite le formulaire en interrogeant le webservice de la question précédente.
   La page affichera le résultat sous la forme d'un tableau HTML simple (`<table>`).

   On vient ainsi de simuler l'interrogation d'un webservice distant par un serveur web/php.
   En général, la structure d'une telle application consiste en :

   * une ressource web dynamique sur un serveur distant (le webservice) ;
   * une fonction qui interroge cette ressource et la traite/l'affiche, sur le serveur local (de développement).


## Antennes GSM

On change de jeu de données, en utilisant maintenant la liste des 
[antennes GSM situées à Grenoble](http://data.metropolegrenoble.fr/ckan/dataset/l-ensemble-des-antennes-gsm).
Ce jeu ressemble au précédent, mais il est un peu plus riche.

1. **CSV Antennes**. 
Combien d'antennes sont référencées ? 
   Qu'est-ce que ce jeu contient comme informations supplémentaires par rapport aux points wifi ? 
   Quel intérêt cela présente-t-il dans le cadre d'une démarche Opendata ?

2. **Statistiques opérateurs**. 
Combien d'opérateurs sont présents dans ce jeu de données ? Combien d'antennes chacun possède-t-il ?
Pour répondre, vous pouvez utiliser l'outil que vous préférez, à condition de l'expliciter et de le justifier.

3. **KML validation**. 
Ce jeu de données est également fourni dans un le format `kmz` de Google, qui est un `kml` zippé.
Le format kml est lui-même une application de `xml`. Pouvez-vous facilement valider ce fichier, comment/pourquoi ?

4. **KML bis**. 
Que pensez-vous de ce dernier fichier en terme de facilité de lecture et d'usage ? En terme de redondance / compacité ?

5. **Top N opérateur**. 
Adaptez l'application prévue pour les points wifi afin de traiter les antennes GSM. 
Le formulaire de webservice devra tout de même prendre en compte le choix d'un opérateur, 
et affichera le top N des antennes de cet opérateur  seulement.

