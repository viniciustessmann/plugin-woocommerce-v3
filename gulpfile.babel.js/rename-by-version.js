import {version} from '../package.json';

export default function (path) {
	if (!path.extname || path.dirname === 'favicons') {
		return;
	}

	path.basename += `-${version.replace(/\./g, '-')}`;
}
