squiffles:
	cd src && php -f index.php > ../index.php
	mkdir -p cards
	cd src/cards && php -f index.php > ../../cards/index.php

clean:
	rm index.php
