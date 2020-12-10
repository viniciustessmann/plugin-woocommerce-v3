import {src, dest} from 'gulp';
import newer from 'gulp-newer';
import imagemin from 'gulp-imagemin';
import rename from 'gulp-rename';
import {img} from '../paths';
import {reload} from './serve';
import renameByVersion from '../rename-by-version';

export default function imgTask (done) {
	src(img.src)
		.pipe(newer(img.dest))
		.pipe(imagemin([
			imagemin.jpegtran({progressive: true}),
			imagemin.gifsicle({interlaced: true}),
			imagemin.svgo({
				multipass: true,
				plugins: [
					{removeUselessDefs: false},
					{removeHiddenElems: false},
					{removeViewBox: false},
					{cleanupIDs: false}
				]
			})
		]))
		.pipe(rename(renameByVersion))
		.pipe(dest(img.dest))
		.on('end', reload);

	done();
};
