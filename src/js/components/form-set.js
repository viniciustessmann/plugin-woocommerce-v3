export default {
	name: 'form-set',

	type: 'component',

	props: [
		'name',
		'label',
		'value',
		'mask',
		'validation',
		'message',
		'error-message',
		'disabled'
	],

	computed: {
		_value: {
			get() {
				return this.value;
			},
			set(newValue) {
				this.$emit('input', newValue);
			}
		},

		isValid() {
			return (this.validation === undefined) ? true : this.validation;
		}
	}
};
