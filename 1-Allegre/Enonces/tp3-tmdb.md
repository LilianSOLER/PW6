% PW-DOM  TP3  TMDB

## Utilisation de *The Movie Database*

On va utiliser [The Movie Database (TMDB)](http://www.themoviedb.org/)
un projet collaboratif (semi-ouvert) pour consulter une base de données
consacrée au cinéma et aux séries TV.
TMDB a une vitrine publique, comparable à IMDb, pour les lecteurs web standard,
et également une API de consultation et de contribution, pour alimenter différentes
applications tierces, notamment de nombreux *media centers* comme Kodi/XBMC ou
des applications comme VLC.

Vous aurez besoin d'une clé "développeur" pour accéder à l'API : 
`ebb02613ce5a2ae58fde00f4db95a9c1`, que vous pouvez tester directement
à l'url <http://api.themoviedb.org/3/movie/550?api_key=ebb02613ce5a2ae58fde00f4db95a9c1> .

Vous trouverez de la documentation aux adresses suivantes :

* [Aperçu de l'API](http://www.themoviedb.org/documentation/api)
* [Documentation développeur](http://developers.themoviedb.org/3/getting-started)


### Mise en jambes 

0. **Préalable**. 
Pour ce TP, vous devriez installer dans votre navigateur une extension permettant d'afficher clairement 
le format json, par exemple `JSONovich` pour Firefox, ou `JSONview` pour Chrome/Chromium. 

1. **Exploration**. Quel est le format de réponse ? De quel film s'agit-il ? 
Essayez avec le paramètre supplémentaire `language=fr`.

2. **Exploration CLI**. Testez également le service avec `curl` en ligne de commande, puis avec un
programme php minimal utilisant `tp3-helper.php`.

3. **Page de détail (web)**. Pour un film fourni par son identifiant (un entier), vous afficherez
une page web donnant les éléments suivants : son titre, son titre original, sa
*tagline* (si elle existe), sa description, et un lien vers la page publique TMDB.


### Les choses sérieuses

4. **Page en 3 colonnes (web)**. Améliorer la page précédente, pour afficher en 3 colonnes (dans un tableau),
les mêmes éléments, en version originale, version anglaise, et version française 
(évidemment, il peut y avoir redite si la VO est anglaise ou française). 

5. **Image (web)**. Dans la même page, ajouter une dernière ligne affichant en taille réduite l'affiche
(*poster*). Vous aurez besoin des données fournies par l'API 
[configuration](http://api.themoviedb.org/3/configuration) pour déduire l'URL et les tailles disponibles.

**Hint** Lisez les indications de [Getting started - Images](https://developers.themoviedb.org/3/getting-started/images).

6. **Requête (web)**. Trouver et afficher tous les films de la trilogie *Le Seigneur des Anneaux* 
(en vo *The Lord of the Rings*) de Peter Jackson.
S'il y a ambiguité, afficher tous les films trouvés, avec leur identifiant, leur date de sortie et
leur titre.

**Hint** : TMDB gère la notion de *collection*, qui est indiquée dans les données retournées par l'API. 
Il suffit alors de remplacer "movie" par "collection" dans l'url.

**Hint** : [search and query](https://developers.themoviedb.org/3/getting-started/search-and-query-for-details)

7. **Distribution (web)**. Trouver et afficher tous les acteurs de la série des films précédents, avec leurs rôles,
et le nombre de films où ils apparaissent.

**Hint** : il suffit d'ajouter [/credits](https://developers.themoviedb.org/3/credits) à la fin du paramètre d'interrogation.

8. **Distribution++**. Peut-on afficher tous les acteurs **qui jouent des hobbits** ? Comment ?

9. **Casting**. Dans la liste des acteurs, transformer chaque acteur en lien-rebond donnant la liste des films auxquels
il a participé, ainsi que le nom du rôle. Est-ce simple à faire ?

10. **Bande-annonce**. Intégrer à la page récapitulative d'un film un lien vers sa bande-annonce (*trailer*). 
Encore mieux, intégrer un lecteur vidéo (*embed*) dans la page, permettant de lancer la lecture.

**Hint** : [Cette discussion](https://www.themoviedb.org/talk/566f816f92514173ff014fdc) sur le forum TMDB comporte toutes les réponses.


