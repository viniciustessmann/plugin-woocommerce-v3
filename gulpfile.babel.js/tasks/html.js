import fs from 'fs';
import {src, dest} from 'gulp';
import plumber from 'gulp-plumber';
import pug from 'gulp-pug';
import pugLinter from 'gulp-pug-linter';
import pugLintStylish from 'puglint-stylish';
import {prod, hostname} from '../index';
import {html} from '../paths';
import {reload} from './serve';
import {version} from '../../package.json';
import content from '../../content.json';

export default function htmlTask (done) {
	if (!prod) {
		src(html.watch)
			.pipe(pugLinter({
				reporter: pugLintStylish
			}));
	}

	src(html.src)
		.pipe(plumber())
		.pipe(pug({
			pretty: !prod,
			locals: {
				version,
				hostname,
				$: content,
				icons: fs.readdirSync(`${__dirname}/../../src/img/sprite`)
			}
		}))
		.pipe(dest(html.dest))
		.on('end', reload);

	done();
};
