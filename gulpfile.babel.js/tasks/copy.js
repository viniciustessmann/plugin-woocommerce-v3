import {src, dest} from 'gulp';
import newer from 'gulp-newer';
import replace from 'gulp-replace';
import {copy} from '../paths';
import {reload} from './serve';
import content from '../../content.json';

export default function copyTask(done) {
	src(copy.src)
		.pipe(newer(copy.dest))
		.pipe(dest(copy.dest))
		.on('end', () => {
			src(copy.manifest)
				.pipe(replace('{title}', content.meta.title))
				.pipe(replace('{shortName}', content.meta.shortName))
				.pipe(replace('{themeColor}', content.meta.themeColor))
				.pipe(dest(copy.dest))
				.on('end', reload);
		});

	done();
};
