squiffles:
	cd src && php -f index.php > ../index.html
	postcss src/squiffles.css --use autoprefixer > squiffles.css
	mkdir -p cards
	cd src/cards && php -f index.php > ../../cards/index.html
	cd css && make
	cd slides && make

clean:
	rm -rf cards index.html squiffles.css
