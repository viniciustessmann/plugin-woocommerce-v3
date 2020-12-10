console.time('Initialize'); // eslint-disable-line no-console
import '@babel/polyfill';
import App from '@app/index.js';
import main from '@components/main';

const app = new App(),
	vm = new Vue(main());

app.init(() => {
	vm.$mount('#app');
	console.timeEnd('Initialize'); // eslint-disable-line no-console
});
