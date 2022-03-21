% PW-DOM  Compte rendu de TP

# Compte-rendu de TP

Sujet choisi : 

## Participants 

* Un
* Deux
* ...

## Points d'accès wifi

### Filtres Unix

#### 0.Visualisation texte:
* cat file

#### 1.Comptage:
* cat data/borneswifi_EPSG4326_20171004.csv | wc -l

* cat borneswifi_EPSG4326_20171004_utf8.csv | cut -d, -f2 | uniq -c | sort -r

#### 2.Points multiples:
* cat borneswifi_EPSG4326_20171004_utf8.csv | cut -d, -f2 | uniq -c | sort -r | head -n 1




