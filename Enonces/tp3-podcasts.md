% PW-DOM  TP 3  Podcasts

## Analyse d'un flux RSS de podcast

### Mise en jambes

On va explorer un podcast audio, et pour cela utiliser une bibliothèque
très simple [rss-php](https://github.com/dg/rss-php) qui est une surcouche
au parser XML standard.
NB : plutôt que d'utiliser `rss-php` on pourrait tout faire au niveau XML
mais ce serait un peu plus long et plus fastidieux.

Comme tous les langages de haut niveau, PHP inclut un système 
centralisé d'installation des bibliothèques/dépendances. Pour
PHP, c'est [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos)
qui s'est imposé.


Dans la suite, on va donner les exemples sur le podcast intitulé ***La Méthode Scientifique***
(`MethSci`), de France Culture disponible à 
[cette adresse](http://radiofrance-podcast.net/podcast09/rss_14312.xml).
Vous pouvez utiliser n'importe quel autre podcast
de votre préférence, pourvu qu'il comporte des champs équivalents.
Dans Firefox, jusqu'à la version 64, les flux RSS sont interprétés nativement
sous le terme *Live Bookmarks*. Dans les versions plus récentes, et dans Chrome,
il est conseillé d'installer une extension pour les gérer comme 
[*podStation*](https://chrome.google.com/webstore/detail/podstation-podcast-player/bpcagekijmfcocgjlnnhpdogbplajjfn)
ou [*Feed Preview*](https://addons.mozilla.org/en-US/firefox/addon/feed-preview/).

Les podcasts de Radio France (France Inter, France Culture...)
ont l'avantage d'être très bien indexés et de respecter les normes, mais vous 
pouvez en utiliser d'autres, par exemple les abonnements *Soundcloud*, etc.


0. **Dépendances**. On commence par installer les dépendances nécessaires.

S'il n'est pas déjà présent, il vous faut d'abord installer un nouveau paquet PHP gérant les fonctions dédiées au XML, `php-xml` :

```
sudo apt install php-xml
sudo service apache2 restart
sudo service apache2 status    # on vérifie le délai sur la ligne Active:
```

Vous allez installer *Composer*, selon 
[les directives données en lien](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos) 
et ensuite installer `rss-php` via Composer.

```
# d'abord récupérer le script 'installer'
php installer
sudo mv composer.phar /usr/local/bin/composer  #installation globale
cd Podcaster        # votre répertoire de travail à créer si besoin
composer require dg/rss-php
```

Notez ce que *Composer* a fait dans votre répertoire de travail : fichiers/répertoires
ajoutés ou modifiés, etc.

Testez la bibliothèque en exécutant simplement le bout de code fourni
par [la micro-documentation](https://github.com/dg/rss-php#usage) de rss-php. 
*Composer* permet d'utiliser un mécanisme d'autoloading, mais nous
allons simplement utiliser le `require_once` traditionnel.
Il faudra simplement ajouter en début de fichier php la directive : 

```
require_once('vendor/dg/rss-php/src/Feed.php');
```


1. **Tableau des podcasts**. Pour la prise en main de `rss-php`, vous devez simplement 
afficher un tableau html de la liste des épisodes d'un podcast, un épisode par ligne,
avec les colonnes suivantes :

* Date
* Titre (incluant un lien html vers la page cible et une description visible au survol avec `<title>`)
* Lecture un lecteur audio selon la norme Html5 (vue en cours) permettant l'écoute directe du fichier MP3
* Durée
* Média : un simple lien pour télécharger le fichier MP3 (et non l'écouter)

<!--Voici un exemple du rendu désiré :-->


### Les choses sérieuses

2. **Intercalaire hebdomadaire**. 
Le podcast `MethSci` est quotidien, avec une structure hebdomadaire, du lundi au vendredi.
Le but ici est simplement d'ajouter au tableau de la question précédente des lignes
intercalaires pour séparer la semaine. Chaque ligne ne contiendra qu'une seule cellule,
indiquant le numéro de la semaine dans l'année.

**Hint** la fonction php `date()` vous fournira les calculs nécessaires et 
en html l'attribut `colspan` sur  `<td>` ou `<th>` permettra la présentation
demandée.

**Hint+** il est conseillé dès maintenant d'établir une bonne structure de données
des podcasts permettant de travailler proprement sur le stockage *et* la présentation
des épisodes.

3. **Tableau hebdomadaire**. On demande cette fois un format compact hebdomadaire,
chaque ligne représentant *une semaine*, les cinq épisodes représentés en ligne. 
Chaque colonne représentera un jour de la semaine (de lundi à vendredi), chaque cellule
donnera la date, le titre (lien) et un lecteur mp3 de format compact (sans contrôle).

<!--Voici un exemple du rendu désiré :-->


4. **Plusieurs podcasts** (difficile).
Avec le tableau de la question 2, configurez deux ou trois podcasts différents
et adaptez l'affichage pour mixer les sources dans le même tableau, en respectant
(si possible) l'ordre chronologique.
Même question avec le "tableau hebdomadaire" de la quesion 3.
Quelles sont les difficultés rencontrées ? Devez-vous faire des compromis ou
imposer des contraintes pour les contourner ?


### Manipulation des mp3 

5. **Attributs du mp3**. 
Téléchargez un épisode mp3 du podcast étudié.
Quel est le bitrate standard du podcast ? mono ou stéréo ?

**Hint** Vous pouvez répondre en ligne de commande avec `mp3info` ou `id3v2`, ou 
en PHP avec la bibliothèque [getID3](http://getid3.sourceforge.net/).

6. **Réencodage**  
On va essayer de réduire le bitrate du fichier mp3 
pour en stocker plus sur un baladeur de petite capacité.
Réencodez un fichier mp3 téléchargé en 32 kbps (CBR) mono, à l'aide 
de [lame](http://lame.sourceforge.net/index.php) en ligne de commande
(paquets Debian et Ubuntu standard).


### Interaction avec le fil Twitter

7. **Liens twitter** 
L'équipe de l'émission *La Méthode Scientifique* utilise Twitter en direct
pour ajouter des informations, graphiques, liens, etc. 
Le fil twitter créé chaque jour est rappelé sur la page de description de l'émission,
avec cette information :
*Retrouvez aussi les sources de cette émission sur le fil Twitter de La Méthode scientifique*
Peut-on récupérer automatiquement ce lien en analysant la page ? 
Il reste alors à modifier le tableau hebdomadaire pour y intégrer le lien.

8. **Liens twitter dans le mp3**
Peut-on directement intégrer le lien vers le fil twitter dans le fichier mp3 considéré ?
Quelles conventions et quelles limitations cela impose ?


9. **Pour aller plus loin : API Twitter**
Twitter fournit une [API web](https://developer.twitter.com/en/docs/basics/getting-started) 
qui permet de récupérer et chercher des tweets de façon très puissante.
Cependant une clé développeur et un mécanisme d'authentification forte rendent l'API 
Twitter trop complexe pour le cadre de ce TP. Mais vous pouvez vous y intéresser à titre personnel.


