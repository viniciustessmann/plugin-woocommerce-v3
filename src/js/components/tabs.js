export default class {
	constructor($element) {
		this.elementSelector = '.tabs';
		this.buttonSelector = `${this.elementSelector}__button`;
		this.contentSelector = `${this.elementSelector}__content`;
		this.buttonActiveClass = `${this.buttonSelector}--active`.substr(1);
		this.contentActiveClass = `${this.contentSelector}--active`.substr(1);

		this.$element = $element;
		this.$buttons = Array.from(this.$element.querySelectorAll(this.buttonSelector));
		this.$contents = this.$element.querySelectorAll(this.contentSelector);
	}

	active(index) {
		this.deactiveAll();
		this.$buttons[index].classList.add(this.buttonActiveClass);
		this.$contents[index].classList.add(this.contentActiveClass);
	}

	deactiveAll() {
		this.$buttons.forEach(($button) => {
			$button.classList.remove(this.buttonActiveClass);
		});
		this.$contents.forEach(($content) => {
			$content.classList.remove(this.contentActiveClass);
		});
	}

	get handlers() {
		return {
			$buttons: {
				click: (e) => {
					this.active(this.$buttons.indexOf(e.target));
				}
			}
		};
	}

	bind() {
		this.$buttons.forEach(($button) => {
			$button.addEventListener('click', this.handlers.$buttons.click, false);
		});
	}

	init() {
		this.active(0);
		this.bind();
	}
}
