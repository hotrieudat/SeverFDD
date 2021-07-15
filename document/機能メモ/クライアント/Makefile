ALL: encryption_operation.html setup_pyside_env.html binary_format.html
binary_format.html: ./binary_format/normal.svg ./binary_format/offline.svg
%.html: %.md
	pandoc -f markdown_github -t html5 -c style.css $< > $@
