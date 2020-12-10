import axios from 'axios';

export default function (components) {
	for (let i = 0; i < components.length; i++) {
		// For the sake of curiosity: Immediately Invoked Function Expression
		(function iife(component) {
			Vue.component(component.name, (resolve) => {
				axios.get(`/${component.type}s/${component.name}.html`).then((response) => {
					component.template = response.data;
					resolve(component);
				});
			});
		})(components[i]);
	}
}
