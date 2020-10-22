squiffles:
	cd src && php -f index.php > ../index.html
	mkdir -p cards
	cd src/cards && php -f index.php > ../../cards/index.html

clean:
	rm -rf index.html cards
