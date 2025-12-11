SHELL=/bin/bash

all: templated bundled

templated: home cards resumes submodules

home: squiffles.css
	cd src && php -f index.php > ../index.html

cards: squiffles.css
	mkdir -p cards
	cd src/cards && php -f index.php > ../../cards/index.html

resumes: squiffles.css
	mkdir -p resume
	cd src/resume && php -f index.php > ../../resume/index.html
	mkdir -p resume-service
	cd src/resume && php -f index_service.php > ../../resume-service/index.html
	mkdir -p resume-web
	cd src/resume && php -f index_web.php > ../../resume-web/index.html

squiffles.css: src/fishbot.py src/squiffles.css
	cat src/squiffles.css <(python3 src/fishbot.py) | postcss --use autoprefixer > squiffles.css

submodules:
	cd css && make
	cd ct3d && make
	cd slides && make

bundled:
	cd tracker && npm install && npm run build
	cd vacuum && npm install && npm run build

clean:
	rm -rf cards index.html resume resume-service resume-web squiffles.css
