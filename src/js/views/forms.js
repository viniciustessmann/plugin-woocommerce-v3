import asyncComponents from '@modules/async-components';
import formValidator from '@mixins/form-validator';
import maskFormat from '@mixins/mask-format';
import FormSet from '@components/form-set';
import Field from '@components/field';
import Combobox from '@components/combobox';
import Checkbox from '@components/checkbox';
import Toggle from '@components/toggle';
import Radio from '@components/radio';
import Datepicker from '@components/datepicker';

asyncComponents([
	FormSet,
	Field,
	Combobox,
	Checkbox,
	Toggle,
	Radio,
	Datepicker
]);

export default {
	name: 'forms',

	type: 'view',

	mixins: [formValidator, maskFormat],

	data() {
		return {
			fieldInput: null,
			fieldTextarea: null,
			combobox: null,
			checkbox: null,
			toggle: null,
			radio: null,
			minDate: null,
			maxDate: null,
			datepicker: null
		}
	}
};
