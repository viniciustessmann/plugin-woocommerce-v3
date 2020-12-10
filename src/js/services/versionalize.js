import {version} from '@root/package.json';

export function versionalize(string) {
	let fullPath = string.split('.');

	fullPath.splice(1, 0, version.replace(/\./g, '-'));

	return fullPath.join('.').replace('.', '-');
}
