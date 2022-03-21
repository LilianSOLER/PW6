% PW-DOM  TP 2  stations météo ROMMA

# Réseau météo ROMMA

Technologies : API web, json, géocodage, Wikipédia, OpenEventDatabase.

Dans cet exercice, on va utiliser le service fourni par le réseau météo amateur 
[ROMMA](http://romma.fr). Réseau d'Observation Météo du Massif Alpin,
ROMMA est une association bénévole à but non lucratif.

**ATTENTION**, les données diffusées par le réseau ROMMA par webservice 
**ne sont pas "ouvertes"** au sens habituel. Pour les utiliser, nous avons
une clé unique d'identification **e50aa81fbd8e831dae** et ces données ne doivent
pas être diffusées en dehors du cadre de ce TP. 
D'autre part, seules certaines stations du réseau nous sont accessibles 
(en fonction de notre clé) ; les autres renvoient un résultat vide.

Le service est disponible à partir d'une API de ce format : 
<http://romma.fr/releves_romma_xml.php?id=e50aa81fbd8e831dae&station=72>
et les données sont fournis en Json, en **"temps réel"** ou presque : les données sont
actualisées toutes les dix minutes, ce qui est largement assez fin pour suivre les phénomènes
météorologiques (à l'exception des rafales de vent).
L'API ROMMA est donc *extrêmement simple* par rapport aux formes plus couramment rencontrées.

**Conseil** : Pour cet exercice, vous devriez installer dans votre navigateur une extension permettant
d'afficher clairement le format json, par exemple `JSONovich` pour Firefox, ou `JSONview` pour Chrome/Chromium.

Vous pouvez commencer par parcourir le site, en particulier chercher la station
la plus proche et regarder les données disponibles.


## Exploitation des données

Dans cette première partie, on exploite les données ROMMA pour en tirer un affichage synthétique
et des statistiques légères. 
Le but final est d'obtenir un affichage synthétique du type de 
[celui-ci](http://www.niceduo.info/mmdo/tp2/romma-page.php).

1. **Stations accessibles**. Les stations ont un numéro compris entre 1 et 140 (pour l'instant).
Recherchez toutes les stations "accessibles". Affichez leur nombre et la liste. 
Utilisez une fonction pour renvoyer la liste.
Que pensez-vous de la solution utilisée pour indiquer que la lecture d'une station
n'est pas autorisée, au regard du standard HTTP ?

Pour la suite, pour accélérer les requêtes et ne pas charger outre mesure le serveur Romma,
vous pouvez considérer la liste des stations interrogeables comme une constante définie dans le code.

2. **Affichage de détail**. Pour chaque station, certaines données sont fixes (nom, localisation, etc.) 
et d'autres changent régulièrement (date-heure et relevés).
Sur une page web prenant en paramètre GET un identifiant de station, affichez dans deux tables séparées simples,
à 2 colonnes, les données fixes et les données changeantes de la station.
Utilisez encore une fonction spécifique pour cela, ainsi vous pourrez
utiliser un affichage détaillée ou un affichage compact selon les besoins ultérieurs.

3. **Affichage synthétique**. Affichez une table synthétiques des données, avec en lignes 
les différentes stations accessibles et en colonnes les champs : 
*nom*, *latitude*, *longitude*, *valide*, *date*, *heure*, *température*, *pluie*, *humidité*. 
Sur le champ nom, mettez un lien vers la page d'affichage détaillée.

4. **Statistiques**. Pour chacune des trois dernières colonnes, déterminez les valeurs minimale et maximale 
pour l'ensemble des stations **valides**, et affichez-les dans la table synthétique, 
minimum sur fond bleu et maximum sur fond rouge.


## Mashups

Dans cette seconde partie, on va utiliser des services tiers pour enrichir ou qualifier
la donnée ROMMA brute et la rendre plus conviviale à l'affichage.

5. **Géolocalisation cartographique**. Pour chaque station accessible, le but est d'afficher un lien vers une carte avec
un marqueur correspondant, sur un fond de carte OpenStreetMap (OSM).
OSM fournit ce service de base, avec une url construite sur le modèle suivant (ici pour l'UFRIMA) : 
<http://www.openstreetmap.org/?mlat=45.1938&mlon=5.7687#map=15/45.1901/5.7633>.
`mlat` et `mlon` donnent les coordonnées du marqueur, et `map` indique le niveau de zoom (15) et les coordonnées du centre de la carte.
Ecrivez une fonction qui produit ce lien, que vous pouvez ensuite intégrer dans la table récapitulative et dans la table d'affichage détaillé.

6. **Géocodage**. Remarquez qu'on n'a pas toujours l'indication du nom de la commune dans le nom de la station.
Pour pallier ce problème, on va utiliser un service de **géocodage inverse**, 
qui renvoie une adresse à partir des coordonnées (le géocodage direct renvoie des coordonnées à partir d'une adresse).
Vous pouvez en utiliser facilement deux :

* le géocodeur officiel français, <https://adresse.data.gouv.fr/api>,
* le moteur de recherche [Nominatim](https://wiki.openstreetmap.org/wiki/Nominatim#Reverse_Geocoding), issu d'OpenStreetMap. 

Dans les deux cas, on a affaire à une API REST, un peu plus complexe que celle de ROMMA.
Si le géocodage inverse aboutit, ajoutez le nom de la commune dans le tableau de détail d'une station.

7. **Lien commune**. Pour les stations dont la commune est identifiable, on veut ajouter dans le tableau synthétique
le nom de la commune, et un lien vers Wikipédia avec ce nom.
Quelles difficultés peut-on rencontrer, et quelles solutions de contournement peut-on envisager ?

8. **Précision**. Toutes les stations accessibles déclarent leur localisation en latitude/longitude, mais pas toutes avec la même précision (arrondis). 
Pouvez-vous déterminer la précision de la localisation **en mètres**, et l'afficher dans la table synthétique ?
Vous pourrez utiliser la fonction de calcul (approximatif) des distances fournie dans les helpers.

<!--
## Pour aller plus loin

9. **Enregistrement**. Si l'on veut maintenant enregistrer une série de relevés pour faire un suivi
temporel, l'une des solutions est de stocker les données dans une petite base de données relationnelle.
Concevez un schéma simple pour cette base.
À quelle vitesse la base va-t-elle grossir (par exemple en Mo / jour) ?
 
10. **Export OpenEventDatabase**. Si l'export et la réutilisation des données ROMMA étaient autorisés, 
il serait intéressant d'utiliser un format standardisé.
L'une des possibilités serait d'utiliser le format OpenEventDatabase (OED), qui utilise un format Geojson
avec une surcouche spécifique, documentée sur le [wiki OED](https://github.com/openeventdatabase/backend/wiki).
Votre mission est donc d'écrire un convertisseur de format, qui à partir d'*un* relevé d'une station ROMMA
reformate les informations en OED.
-->
