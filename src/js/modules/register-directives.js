export default function (directives) {
	for (let i = 0; i < directives.length; i++) {
		Vue.directive(directives[i].name, directives[i]);
	}
}
