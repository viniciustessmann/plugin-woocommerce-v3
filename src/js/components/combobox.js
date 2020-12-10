import FormSet from '@components/form-set';

export default {
	name: 'combobox',

	type: 'component',

	extends: FormSet,

	props: ['options'],

	computed: {
		selectedName() {
			const selected = this.options.find((option) => {
				return option.id === this._value;
			});

			return (selected) ? selected.name : null;
		}
	},

	data() {
		return {
			open: false
		};
	}
};
