Mantis Toolkit
===============

> A small set of useful mixins and functions

[![npm version](https://badge.fury.io/js/mantis-toolkit.svg)](http://badge.fury.io/js/mantis-toolkit)

<p align="center">
  <img title="Mantis Toolkit" src="mantis-toolkit.png" width="200" />
</p>

---


Installation
------------

The installation can be done in 3 steps:

- **Step 1**

	Install via NPM:

	```sh
	$ npm i --save mantis-toolkit
	```

- **Step 2**

	You can use this plugin in different ways, but all consist of passing the plugin to the [`.use`](http://stylus-lang.com/docs/js.html#usefn) method of Stylus.
	For this example, I'll use it with [Gulp](http://gulpjs.com/) in a ES6 enviornment.

	```javascript
	import gulp from 'gulp';
	import stylus from 'gulp-stylus';
	import toolkit from 'mantis-toolkit';

	gulp.task('css', () =>
		gulp.src('path-to-source.styl')
			.pipe(stylus({
				use: [
					toolkit()
				]
			}))
			.pipe(gulp.dest('path-to-dest/'))
	);
	```

- **Step 3**

	Now just import the plugin into your `.styl` file as you already know.

	```styl
	@import 'mantis-toolkit'
	```


License
-------

© 2020 [Acauã Montiel](http://acauamontiel.com.br)

[MIT License](http://acaua.mit-license.org/)
