export default {
	computed: {
		validForm() {
			return !this.$v.$invalid;
		},

		showErrors() {
			return this.$v.$dirty;
		}
	},

	methods: {
		validateForm() {
			let $field;

			this.$v.$touch();

			window.setTimeout(() => {
				$field = document.querySelector('.form--error');

				if ($field) {
					$field.querySelector('input, textarea, select').focus();
					window.scrollTo(0, window.scrollY - 80);
				}
			}, 100);

			return this.validForm;
		},

		validField(v) {
			return this.showErrors && v;
		}
	}
};
