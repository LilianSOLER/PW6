% TP1 - Exercices PHP

# TP1 - Exercices PHP

## Prise en main - diagnostic PHP (niv. 1)

Une archive de modèles `modeles.tgz` est disponible dans 
le [cours Moodle](https://im2ag-moodle.e.ujf-grenoble.fr/course/view.php?id=335) 
ou éventuellement dans le répertoire [polytech silecs](http://www.silecs.info/formations/polytech/).
Récupérer l'archive et décompressez-la (`tar -zxf` en ligne de commande).

* exécutez `info.php` dans l'environnement web (Apache et navigateur). Elle repose sur la fonction de diagnostic `phpinfo()`.
* comparez le résultat avec `php -i` en ligne de commande (CLI), notamment pour `Server API`.. 
* testez le fichier `debogage.php` dans **les deux** environnements, et modifiez-le pour mener vos propres tests.
* introduisez une erreur de syntaxe dans ce programme, et vérifiez que l'interpréteur vous renvoie bien un message d'erreur, ainsi que la ligne concernée.


## Calcul d'intérêts composés (niv. 1-2)
Le but est de proposer une calculatrice d'intérêts composés très simple.

1. Réalisez une page `calcul.html` comportant un formulaire à 3 champs : 
  *somme*, *taux* (en pourcentage), *duree* (en années), 
  traité dans une deuxième page "resultat.php" affichant la décomposition du calcul et le résultat
    * vous partirez du modèle `formulaire.html`,
    * dans `resultat.php`, vous utiliserez la variable superglobale (typée tableau associatif) `$_GET` ou `$_POST`,
    * pour rappel, la formule de calcul est "cumul = somme * ( 1 + taux/100 ) ^ duree"
    * pour le calcul, utilisez la fonction `pow()` ou l'opérateur exposant `**`
2. Testez la différence de traitement entre les méthodes GET et POST. 
   Laquelle est la plus adaptée ici, d'après les bonnes pratiques W3C ?
3. Faites la même chose en ligne de commande, en utilisant les 3 paramètres d'entrée en CLI
    * pour l'appel en CLI, la syntaxe est `$ php monscript.php (arg1) (arg2)...` 
    * dans le code, on utilise le tableau positionnel `$argv` (similaire au C)
4. Utilisez une fonction et une inclusion PHP (`require_once()`) pour structurer le calcul :
    * une fonction `cumul($somme, $taux, $duree)` dans une *bibliothèque* `libcalcul.php`,
    * deux pages `calcul.html` et `resultat.php` pour l'interface web,
    * un script `clicalcul.php` en ligne de commande.



## Un peu de style en CSS (niv. 1)

On va maintenant se servir de la norme CSS pour améliorer un peu l'affichage HTML. 
On va se baser sur les fichiers `elements.html` et  `elements.css`.

1. Copiez `elements.html` pour le modifier. Commencez par visualiser l'arbre html 
(*Ctrl + Shift + I > Inspecteur*). Quel est l'élément de niveau le plus profond ? 
à quel niveau cela correspond-t-il ? (en comptant `<html>` à 0).
2. Avec les styles CSS, ajoutez un cadre autour de la table.
3. Passez en *vert non souligné* les liens par défaut, puis 
  en *vert gras* les liens dans des énumérations `<ul>`


### Hints 

* Les sélecteurs de css : `table, tr, td` puis `li` et `a` seront utiles (seuls ou combinés).
* Les directives `border`, `color` et `background-color` pourront servir.

### Quelques mots de contexte

La hiérarchie de l'arbre html est importante. Elle sert aussi bien pour les sélecteurs CSS
que pour les requêtes DOM (Document Object Model), en PHP ou en JavaScript.
L'*Inspecteur* intégré à chaque navigateur (ou presque) vous permet de l'explorer facilement.


## Table de multiplication (niv. 1-2)

1. Affichez une table de multiplication classique de 10 lignes et 10 colonnes.
    * la boucle `for ()` est votre amie.
    * en CSS  les directives `border` et `padding` seront utiles 
2. Ajoutez la possibilité de passer en paramètres d'url (GET) le nombre de lignes et de colonnes.
    * pour rendre le paramètre *optionnel*, la fonction de test `isset()` pourra être utile
3. Ajoutez un paramètre pour permettre de surligner (fond jaune) une ligne particulière.
    * utilisez une classe CSS (par exemple `surlignee`) pour gérer *proprement* la mise en évidence. 
    * une **CSS interne** est toute indiquée, avec dans l'entête html le code `<style type="text/css">...</style>`,
    avec la directive `background-color`.



## Analyse des Caractères Unicode (niv. 2)

Le but est d'afficher une analyse "Unicode" des caractères tapés dans un formulaire ou en ligne de commande. Par exemple "A" a pour *codepoint* "U+0041" (41 en hexadécimal ou 65 en décimal).

1. Écrivez un script CLI qui affiche le code de l'initiale de chaque mot passé en argument.
    * Avec des caractères non ASCII (ce qui est l'intérêt de l'exercice) il faut utiliser les fonctions `mb_substr()`, `mb_ord()` et éventuellement `mb_internal_encoding()`  de l'extension `php-mbstring`.  MB signifie "multi-bytes".
    * parmi les modèles vous disposez d'un fichier *multiscripts.html* contenant un échantillonnage
      de textes en plusieurs *écritures*, le tout encodé en UTF-8/Unicode.
2. Faites la même chose en interface web, à partir d'un champ de formulaire (GET).
3. Les chartes unicode sont traditionnellement représentées comme des tableaux de 16 colonnes et N lignes, 
   alignés sur les codes hexadécimaux. 
   Affichez un tableau html de la ligne complète contenant un caractère donné.
4. Ajoutez au bas de chaque case le code 'U+xxxx' en petit, et un lien vers la page de référence du caractère.
    * en CSS, la directive `font-size`
    * pour exemple, [une page de référence Unicode](http://unicode.org/cldr/utility/character.jsp?a=1f60a) (par exemple 😊)
5. (niv. 3) En utilisant la commande shell `unicode` (à installer) et l'appel système PHP 
   [exec()](http://php.net/manual/fr/function.exec.php), ajoutez au *rollover* le nom normalisé du caractère pointé."
    * pour la CSS, je vous conseille d'utiliser les classes "char" pour le caractère et "extra" pour le sous-titre
    * un effet *rollover* simple s'obtient en utilisant l'attribut `title`, par exemple dans `<span title="message d'aide">support</span>`.
<!--* (niv. 3) En utilisant le webservice [wsunicode](http://vps3.silecs.info/wsunicode.php?help) fourni pour le TP, ajoutez un message *rollover* qui indique pour chaque caractère son nom normalisé.-->

### Exemple d'affichage à obtenir

<table>
<tr>
<td ><span class="char">@</span><br /><a class="extra" href="http://unicode.org/cldr/utility/character.jsp?a=0040">U+0040</a></td>
<td ><span class="char">A</span><br /><a class="extra" href="http://unicode.org/cldr/utility/character.jsp?a=0041">U+0041</a></td>
<td ><span class="char">B</span><br /><a class="extra" href="http://unicode.org/cldr/utility/character.jsp?a=0042">U+0042</a></td>
<td ><span class="char">C</span><br /><a class="extra" href="http://unicode.org/cldr/utility/character.jsp?a=0043">U+0043</a></td>
<td ><span class="char">D</span><br /><a class="extra" href="http://unicode.org/cldr/utility/character.jsp?a=0044">U+0044</a></td>
<td ><span class="char">E</span><br /><a class="extra" href="http://unicode.org/cldr/utility/character.jsp?a=0045">U+0045</a></td>
<td  class="selected" ><span class="char">F</span><br /><a class="extra" href="http://unicode.org/cldr/utility/character.jsp?a=0046">U+0046</a></td>
<td ><span class="char">G</span><br /><a class="extra" href="http://unicode.org/cldr/utility/character.jsp?a=0047">U+0047</a></td>
<td ><span class="char">H</span><br /><a class="extra" href="http://unicode.org/cldr/utility/character.jsp?a=0048">U+0048</a></td>
<td ><span class="char">I</span><br /><a class="extra" href="http://unicode.org/cldr/utility/character.jsp?a=0049">U+0049</a></td>
<td ><span class="char">J</span><br /><a class="extra" href="http://unicode.org/cldr/utility/character.jsp?a=004a">U+004a</a></td>
<td ><span class="char">K</span><br /><a class="extra" href="http://unicode.org/cldr/utility/character.jsp?a=004b">U+004b</a></td>
<td ><span class="char">L</span><br /><a class="extra" href="http://unicode.org/cldr/utility/character.jsp?a=004c">U+004c</a></td>
<td ><span class="char">M</span><br /><a class="extra" href="http://unicode.org/cldr/utility/character.jsp?a=004d">U+004d</a></td>
<td ><span class="char">N</span><br /><a class="extra" href="http://unicode.org/cldr/utility/character.jsp?a=004e">U+004e</a></td>
<td ><span class="char">O</span><br /><a class="extra" href="http://unicode.org/cldr/utility/character.jsp?a=004f">U+004f</a></td>
</tr>
</table>



### Quelques mots de contexte

Le codage des caractères en informatique a évolué à partir des années 2000. 
Initialement basé sur le code ASCII (pour l'anglais seulement), puis étendu pour correspondre à plusieurs langues européennes, il ne permettait pas de stocker des documents multilingues ou contenant plus de 256 caractères (chinois, coréen, japonais...).
On utilise maintenant le standard [Unicode](https://fr.wikipedia.org/wiki/Unicode) qui permet notamment
de cataloguer quasiment tous les caractères de toutes les langues sur Terre (y compris certaines 
langues antiques). Le point important est qu'en Unicode, chaque caractère a un *code* (de 4 à 6 chiffres
hexadécimaux), et un nom normalisé en anglais. 
Par exemple, le caractère "A" est codé *U+0041* et nommé *LATIN CAPITAL LETTER A* ; le caractère
"Ω" est codé *U+03A9* et nommé *GREEK CAPITAL LETTER OMEGA*. Même des symboles et des *emojis*
sont inclus ; par exemple 💻  est normalisé en *U+1F4BB PERSONAL COMPUTER*.

Unicode permet lui-même plusieurs *encodages* mais le seul réellement utilisé sur le web est l'*UTF-8*,
au point que certains logiciels confondent parfois Unicode et UTF-8.


## Affichage d'un tableau générique (niv. 2)

On veut écrire une fonction affichant une table html bien présentée et prenant en argument un tableau PHP
de type tableau (numérique) de tableaux (associatifs) représentant des enregistrements.
Un exemple typique est donné par le fichier `annuaire.php` stockant une version très simplifiée d'un annuaire d'établissement.
On veut afficher dans la table des titres de colonnes correspondant aux clés des tableaux associatifs.

1. Quelles sont les contraintes à imposer sur les données. Quelles sont les lignes et les colonnes ?
2. Écrire une fonction générique et l'appliquer sur les données du fichier `annuaire.php` (que vous pouvez compléter).
3. Utilisez la même fonction pour afficher la table de multiplication vue ci-dessus. Cela force à séparer le calcul de la présentation.


## Calendrier - agenda web (niv. 3)

On veut afficher un calendrier du mois en cours sous deux formes standard : en une colonne, et en un tableau.
Ensuite il sera logique de l'utiliser comme agenda pour ajouter un événement. 
On utilisera la fonction PHP `date()` et toute la documentation afférente.

1. Affichez la liste des jours du mois en cours, sur 3 colonnes : le numéro du jour, le nom du jour et une colonne vide.
2. Ajoutez le choix de l'année et du mois en paramètres (GET ou POST selon votre préférence).
3. On veut la même chose mais avec une vue tabulaire classique : 7 colonnes, de lundi à dimanche, autant de lignes que nécessaire.
Les numéros de jours sont écrits dans les cases.
4. On veut créer un mini-agenda, avec 2 champs à remplir : jour du mois, et texte "événement". Ce texte sera affiché dans la vue tabulaire au jour du mois indiqué.
5. Même question que la précédente, mais en utilisant un formulaire avec le type de champ [date](https://developer.mozilla.org/fr/docs/Web/HTML/Element/Input/date). C'est un type avancé prévu dans HTML 5 et directement géré par les navigateurs récents, mais avec quelques différences de présentation. Testez avec 2 ou 3 navigateurs différents.
6. (niv. 4) On veut stocker plusieurs événements dans le même mois. Sans base de données, ce n'est pas pérenne, mais on peut le faire la durée de la session web, avec les fonctions [de session](https://www.php.net/manual/fr/ref.session.php). À vous de jouer...


## Analyse (parsing) d'un document HTML (niv. 3)

On cherche à récupérer automatiquement les grands titres (`h2`) d'un document html *distant*, 
par exemple un article de Wikipédia, avec comme entrée une adresse URL.

1. Au préalable, examiner l'arbre du document dans le navigateur, toujours avec l'Inspecteur (Ctrl+Shift+I)
2. En CLI, réaliser un script permettant d'afficher les titres `h2` en utilisant les fonctions DOM de PHP
    * les méthodes `DOMDocument::getElementsByTagName()` et `DOMNode::textContent()` feront l'affaire.	
	Les exemples de la [page de doc PHP](http://php.net/manual/fr/domdocument.getelementsbytagname.php) sont relativement clairs.
3. Complétez en affichant les titres `h2` et `h3`, bien sûr en respectant l'ordre de la hiérarchie.
    Est-ce plus difficile, et pourquoi ?
4. Essayez de refaire la question 2 sans DOM, en utilisant des expressions régulières (`preg_match`). Qu'en pensez-vous ? 
Pour votre culture, une indication sur la bonne façon de [parser du html avec des expressions régulières](https://stackoverflow.com/questions/1732348/regex-match-open-tags-except-xhtml-self-contained-tags/1732454#1732454).


### Quelques mots de contexte

L'exercice constitue un exemple simple de [web scraping](https://en.wikipedia.org/wiki/Web_scraping).
C'est une méthode qui consiste à parcourir automatiquement le contenu d'un site classique 
(ie prévu pour la lecture humaine) et d'en extraire une synthèse, pour indexation, analyse locale ou
autre. Il faut que le contenu soit raisonnablement structuré, ce qui est possible grâce aux éléments
`h1, h2, h3`... très communs. Pour des sites très "sales" (peu respectueux des standards), le
`scraping` peut être très pénible, et obliger à écrire beaucoup de code de nettoyage.

Plusieurs techniques différentes d'analyse sont autorisés en *scraping*. Pour du html raisonnablement
propre, c'est souvent l'analyse DOM qui est le plus efficace. Dans d'autres cas, on recourt
aussi aux expressions régulières (*regexp*), mais c'est bien plus délicat à manier pour des
traitements complexes.

Pour la communication "machine" on prévoit plutôt d'utiliser des API web et des formats 
très structurés (XML, json ou autres), ce qui fera l'objet du prochain TP.


<!--
# Un peu de JavaScript (avec HTML / CSS)

# Prise en main (niv. 1)

* Testez les fonctions `alert('chaine')` et `console.log('chaine')` pour valider le fonctionnement
de JavaScript dans votre navigateur.
* Essayez les modes d'exécution suivants :
    * dans une page html, en élément `script`
    * dans une page html, en référençant un fichier `.js` externe
    * dans la barre d'adresse (!)
    * dans la ligne de commande de la *console* JavaScript

## Afficher de l'aide (niv. 2)
Le but est d'afficher un bloc d'aide "repliable" sur une page HTML. Ce bloc a un titre "Aide", et un contenu.
Par défaut, seul le titre apparaît. Si on clique dessus, le contenu apparaît également, et fonctionne en mode bascule (toggle).

* On commence par gérer l'affichage d'une bloc caché en CSS.
* On ajoute un événement JavaScript pour activer/cacher la section repliable.
    * À l'ancienne, avec l'attribut html `onclick`
    * Proprement, avec la méthode `addEventListener()`

### Hints
* En CSS, on a la directive `display:` qui peut prendre la valeur `none`.
* On utilisera évidemment le DOM JavaScript, en particulier les méthodes `document.querySelector()` et `classList.toggle()`


## Analyse Unicode dynamique (niv. 2-4)
Sur une page web dans un navigateur standard, on veut que l'utilisateur puisse sélectionner
un passage du texte et que lui soit affichée une fenêtre avec une analyse Unicode des caractères :
liste des caractères, chacun accompagné de son *codepoint* "U+xxxx". 

* L'affichage pourra se faire avec `alert()` ou avec `console.log()` pour le débogage.
* Dans un second temps, affichez la sélection ou l'analyse dans une section "Analyse" en bas de document.
* Dans un troisième temps, remplacez la sélection par le tableau-ligne de caractères Unicode fourni par PHP. Ceci demande Ajax avec échange en JSON de préférence (plus simple).


### Hints
* La méthode `document.addEventListener()` servira encore ici, sur l'événement `click`
* Le traitement pourra s'appuyer sur les méthodes `toString()`, `charCodeAt()` et `charAt()`
* Pour écrire dans un nœud sélectionné, utiliser la *propriété* innerHTML. Auparavant, il faudra sélectionner le nœud avec `document.getElementById()` ou mieux `document.querySelector()` 
* Pour la dernière question (difficile), vous pouvez vous inspirer de l'exemple `Sources/Exemples/php/phptest.js`
-->
