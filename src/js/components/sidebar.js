import {routes} from '@router';

export class Sidebar {
	constructor() {
		this.elementSelector = '.sidebar';
		this.itemSelector = `${this.elementSelector}__item`;
		this.togglerSelector = `${this.elementSelector}__toggler`;
		this.subSelector = `${this.elementSelector}__sub`;
		this.elementOpenClass = `${this.elementSelector}--open`.substr(1);
		this.itemOpenClass = `${this.itemSelector}--open`.substr(1);
		this.open = false;

		this.$element = document.querySelector(this.elementSelector);
		this.$toggler = this.$element.querySelector(this.togglerSelector);
		this.$items = this.$element.querySelectorAll(this.itemSelector);
	}

	elementToggle(state = !this.open) {
		const action = state ? 'add' : 'remove';

		this.open = state;
		this.$element.classList[action](this.elementOpenClass);
	}

	elementOpen() {
		this.elementToggle(true);
	}

	elementClose() {
		this.elementToggle(false);
	}

	subToggle($item) {
		$item.classList.toggle(this.itemOpenClass);
	}

	subClose() {
		this.$items.forEach(($item) => {
			$item.classList.remove(this.itemOpenClass);
		});
	}

	get matchResolution() {
		return window.matchMedia('(max-width: 960px)').matches;
	}

	get handlers() {
		return {
			$toggler: {
				click: () => {
					this.elementToggle();

					if (!this.open) {
						this.subClose();
					}
				}
			},

			$items: {
				click: ($item) => {
					if (!$item.querySelector(this.subSelector) || !this.matchResolution) {
						return;
					}

					if (!this.open) {
						this.elementOpen();
					}

					this.subToggle($item);
				}
			},

			window: {
				click: (e) => {
					if (this.$element.contains(e.target) || !this.open) {
						return;
					}

					this.elementClose();
					this.subClose();
				},

				resize: () => {
					this.elementClose();
					this.subClose();
				}
			}
		};
	}

	bind() {
		this.$toggler.addEventListener('click', this.handlers.$toggler.click, false);
		window.addEventListener('click', this.handlers.window.click, false);
		window.addEventListener('resize', this.handlers.window.resize, false);
		this.$items.forEach(($item) => {
			$item.addEventListener('click', this.handlers.$items.click.bind(this, $item), false);
		});
	}

	init() {
		this.bind();
	}
}

export default {
	name: 'sidebar',

	type: 'component',

	mounted() {
		this.$nextTick(function () {
			const sidebar = new Sidebar(this.$el.children[0]);

			sidebar.init();
		});
	},

	data() {
		return {routes};
	}
};
