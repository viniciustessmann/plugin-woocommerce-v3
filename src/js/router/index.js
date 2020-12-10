import register from '@modules/register';

register();

Vue.use(VueRouter);

export const routes = [
	{
		path: '/',
		name: 'home',
		component: Vue.component('home'),
		meta: {
			title: 'Home'
		}
	},
	{
		path: '/typography',
		name: 'typography',
		component: Vue.component('typography'),
		meta: {
			title: 'Typography'
		}
	},
	{
		path: '/colors',
		name: 'colors',
		component: Vue.component('colors'),
		meta: {
			title: 'Colors'
		}
	},
	{
		path: '/icons',
		name: 'icons',
		component: Vue.component('icons'),
		meta: {
			title: 'Icons'
		}
	},
	{
		path: '/buttons',
		name: 'buttons',
		component: Vue.component('buttons'),
		meta: {
			title: 'Buttons'
		}
	},
	{
		path: '/forms',
		name: 'forms',
		component: Vue.component('forms'),
		meta: {
			title: 'Forms'
		}
	},
	{
		path: '/cards',
		name: 'cards',
		component: Vue.component('cards'),
		meta: {
			title: 'Cards'
		}
	},
	{
		path: '/tabs',
		name: 'tabs',
		component: Vue.component('tabs'),
		meta: {
			title: 'Tabs'
		}
	},
	{
		path: '/tables',
		name: 'tables',
		component: Vue.component('tables'),
		meta: {
			title: 'Tables'
		}
	}
];

const router = new VueRouter({
	mode: 'history',

	scrollBehavior() {
		return {
			x: 0,
			y: 0
		};
	},

	routes
});

export default router;
