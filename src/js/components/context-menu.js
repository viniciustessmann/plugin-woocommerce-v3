export default class ContextMenu {
	constructor($element) {
		this.elementSelector = '.context-menu';
		this.triggerSelector = `${this.elementSelector}__trigger`;
		this.elementOpenClass = `${this.elementSelector}--open`.substr(1);
		this.open = false;

		this.$element = $element;
		this.$trigger = this.$element.querySelector(this.triggerSelector);
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
			$trigger: {
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
				},

				keydown: (e) => {
					if (e.key !== 'Escape' || !this.open) {
						return;
					}

					this.elementClose();
				}
			}
		};
	}

	bind() {
		if (this.$trigger) {
			this.$trigger.addEventListener('click', this.handlers.$trigger.click, false);
		}

		window.addEventListener('click', this.handlers.window.click, false);
		window.addEventListener('keydown', this.handlers.window.keydown, false);
	}

	init() {
		this.bind();
	}
}
