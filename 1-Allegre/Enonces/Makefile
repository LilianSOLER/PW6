PDOPTS = --standalone  --from markdown  --to html  --css include/tp.css \
--template include/template.html -V lang=fr


clean:
	rm tp1-consignes.html tp1-exos.html \
	tp2-consignes.html tp2-romma.html tp2-antennes.html \
	tp3-consignes.html tp3-tmdb.html tp3-podcasts.html

# depends: ./include/tp.css ./include/unicode.css ./include/template.html
#	cat include/tp.css

tp1: tp1-consignes.html tp1-exos.html

tp1-consignes.html: tp1-consignes.md 
	pandoc  ${PDOPTS}  tp1-consignes.md > tp1-consignes.html

tp1-exos.html: tp1-exos.md
	pandoc  ${PDOPTS} --css include/unicode.css tp1-exos.md > tp1-exos.html


tp2: tp2-consignes.md  tp2-antennes.md  tp2-romma.md
	pandoc  ${PDOPTS} tp2-consignes.md > tp2-consignes.html
	pandoc  ${PDOPTS} tp2-antennes.md > tp2-antennes.html
	pandoc  ${PDOPTS} tp2-romma.md > tp2-romma.html

tp3: tp3-consignes.md  tp3-tmdb.md  tp3-podcasts.md  
	pandoc ${PDOPTS} tp3-consignes.md > tp3-consignes.html
	pandoc ${PDOPTS} tp3-tmdb.md > tp3-tmdb.html
	pandoc ${PDOPTS} tp3-podcasts.md > tp3-podcasts.html


tp1zip: tp1.html include/tp.css include/unicode.css
	zip tp1.zip tp1.html tp.css unicode.css

