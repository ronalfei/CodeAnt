all: 
	ctags -R --php-kinds=+cidfv --fields=+iaS --extra=+q --exclude=*.js

ctags:
	ctags -R --php-kinds=+cidfv --fields=+iaS --extra=+q --exclude=*.js

who:
	echo $(shell hostname)
