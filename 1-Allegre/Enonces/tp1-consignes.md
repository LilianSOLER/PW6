% TP1 Consignes

# TP 1 - HTTP, HTML, PHP - Consignes

## Déroulement des TP

Ce premier TP est destiné à vous initier aux technologies de base qu'on utilisera ensuite.
Il ne sera pas évalué, le dernier (numéro 3) le sera.
Le TP comporte plusieurs exercices de difficultés variables (indiquées). Il n'est pas
conçu pour être "terminé" mais pour que vous puissiez vous familiariser ou progresser,
et combler vos lacunes.

Vous pouvez demander de l'aide, mais essayez de chercher par vous-même avant. Les liens disponibles
dans la section documentation et les paragraphes "Hint" sont prévus pour ça.
Les Hints proposent des pistes d'aide, mais vous pouvez trouver une autre méthode qui ne les
utilise pas.
Les paragraphes de "contexte" donnent quelques indications de culture informatique générale 
liée à l'exercice du TP, que vous pouvez creuser pour mieux comprendre les tenants et aboutissants
des questions posées.


## Réalisation en pratique

Le TP se déroule **sous Linux** à la fois :

* en environnement web : exécution de PHP dans le serveur Apache, utilisation d'un navigateur sur le PC local
* en ligne de commande (CLI, *command line interface*) en partie pour PHP.

Vous devrez utiliser un éditeur de texte adapté à la programmation (vim, Gedit, Atom, etc.)


### Installation sur les machines personnelles  

Vous utiliserez vos machines personnelles pour effectuer le TP. L'enseignant ne fournira aucune aide "système"
sur les machines personnelles. *Vous devez installer les dépendances nécessaires à l'avance
et vous assurer que toutes les composantes fonctionnent*. 

Les paquets (Debian ou Ubuntu) à installer : 

* `apache2`, `libapache2-mod-php`, `php-cli`, 
* les extensions php  `php-curl`, `php-mbstring`,
* la commande auxiliaire `unicode`.

Selon l'ancienneté de votre système, les paquets PHP seront en version 
7.x ou 8.0, mais cela n'a aucun impact sur la suite.

Vérifiez que <http://localhost> sert bien la page d'accueil par défaut d'Apache.

### Configuration Apache et PHP

Activez les messages d'erreur dans votre configuration PHP/Apache :

Dans le fichier `/etc/php/7.0/apache2/php.ini` (ou équivalent) configurez les lignes suivantes 
selon leur valeur de **Développement** (et non de production) :

```
error_reporting = E_ALL
display_errors = On
display_startup_errors = On
log_errors = On
```

Puis redémarrez Apache :
```
sudo service apache2 restart
sudo service apache2 status
```

Enfin, examinez le fichier de log : `/var/log/apache2/error.log`, qui contient 

* les logs d'erreur Apache (toujours) ;
* les logs d'erreur PHP, selon la configuration.

**Si vous n'avez pas le droit** de modifier la configuration Apache/PHP (cas très peu probable), 
vous mettrez en début de *chaque* fichier php les deux directives :

```
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
```

Pour lier Apache à votre répertoire local, la façon la plus simple est de créer un lien symbolique
dans le répertoire racine d'Apache, généralement `/var/www/html` (sous Debian/Ubuntu).
Cela se fait par exemple avec les commandes (à adapter) :

```
mkdir ~/PW         # dans votre répertoire personnel
cd /var/www/html
sudo ln -s ~/PW
```
Notez que le tilda **~** sous un shell unix représente le chemin de votre répertoire personnel.
Puis visualisez dans un navigateur l'url <http://localhost/PW>.


# Documentation

* [W3Schools](http://www.w3schools.com/), documentation orientée débutants, simple, mais parfois approximative
* [Référence W3C HTML5](http://www.w3.org/TR/html5/)
* [Documentation PHP officielle](http://php.net/docs.php)

<!--
* [Mozilla Developer Network (MDN)](https://developer.mozilla.org/en-US/), documentation multi-sujets, bon niveau
* [L'API Javascript DOM (MDN)](https://developer.mozilla.org/en-US/docs/Web/API/Document_Object_Model)
* [L'API web JavaScript (MDN)](https://developer.mozilla.org/en-US/docs/Web/API)
-->


