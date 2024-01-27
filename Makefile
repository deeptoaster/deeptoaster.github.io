squiffles:
	cd src && php -f index.php > ../index.html
	postcss src/squiffles.css --use autoprefixer > squiffles.css
	mkdir -p cards
	cd src/cards && php -f index.php > ../../cards/index.html
	mkdir -p resume
	cd src/resume && php -f index.php > ../../resume/index.html
	mkdir -p resume-service
	cd src/resume && php -f index_service.php > ../../resume-service/index.html
	mkdir -p resume-web
	cd src/resume && php -f index_web.php > ../../resume-web/index.html
	cd css && make
	cd slides && make
	cd tracker && npm install && npm run build
	cd vacuum && npm install && npm run build

clean:
	rm -rf cards index.html resume resume-service resume-web squiffles.css
