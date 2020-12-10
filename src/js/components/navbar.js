export class Navbar {
	constructor($element) {
		this.elementSelector = '.navbar';
		this.menuSelector = `${this.elementSelector}__menu`;
		this.elementOpenClass = `${this.elementSelector}--open`.substr(1);
		this.open = false;

		this.$element = $element;
		this.$menu = this.$element.querySelector(this.menuSelector);
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

	get handlers() {
		return {
			$menu: {
				click: () => {
					this.elementToggle();
				}
			},

			window: {
				click: (e) => {
					if (this.$element.contains(e.target) || !this.open) {
						return;
					}

					this.elementClose();
				}
			}
		};
	}

	bind() {
		if (this.$menu) {
			this.$menu.addEventListener('click', this.handlers.$menu.click, false);
		}
		window.addEventListener('click', this.handlers.window.click, false);
	}

	init() {
		this.bind();
	}
}

export default {
	name: 'navbar',

	type: 'component',

	mounted: function () {
		this.$nextTick(function () {
			const navbar = new Navbar(this.$el);

			navbar.init();
		});
	}
};
