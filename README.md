<img src="logo.png" width="300">


> O framework front-end da [Melhor Envio](https://www.melhorenvio.com.br).


Running
-------

You can run the app locally by running these following commands:

### Available Gulp commands

#### Default - `yarn start` or `npm start`

Run this commnad to compile and watch files running on [localhost:3000](http://localhost:3000)


#### Build - `yarn run build` or `npm run build`

Run this command to only compile files


#### Clean - `yarn run clean` or `npm run clean`

Run this command to delete the `public/` folder (same as `rm -rf public`)


Structure
---------

When you have all installed, the structure will look like this:

```
gulpfile.babel.js/
├── tasks/
│   └── *.js
├── index.js
└── paths.js
node_modules/
src/
├── copy/
│   ├── fonts/
│   │   └── *.{eot|svg|ttf|woff}
│   └── **/*
├── css/
│   ├── components/
│   │   └── *.styl
│   ├── core/
│   │   └── *.styl
│   └── style.styl
├── html/
│   ├── app/
│   │   ├── components/
│   │   │   └── *.pug
│   │   └── views/
│   │       └── *.pug
│   ├── components/
│   │   └── *.pug
│   ├── includes/
│   │   └── *.pug
│   ├── layouts/
│   │   └── *.pug
│   └── index.pug
├── img/
│   ├── backgrounds/
│   │   └── *.{jpg|png|svg}
│   ├── favicons/
│   │   └── *.{png|svg}
│   ├── sprite/
│   │   └── *.svg
│   └── *.{jpg|png|svg}
└── js/
    ├── app/
    │   ├── index.js
    │   └── *.js
    ├── modules/
    │   └── *.js
    └── app.js
.babelrc
.editorconfig
.env
.eslintrc
.gitattributes
.gitignore
.pug-lintrc
.stylintrc
content.json
logo.png
package.json
README.md
```


License
-------

© 2019 [Melhor Envio](https://www.melhorenvio.com.br)
