import dayjs from 'dayjs';
import isSameOrBefore from 'dayjs/plugin/isSameOrBefore'
import isSameOrAfter from 'dayjs/plugin/isSameOrAfter'
import isBetween from 'dayjs/plugin/isBetween'
import FormSet from '@components/form-set';

dayjs.extend(isSameOrBefore);
dayjs.extend(isSameOrAfter);
dayjs.extend(isBetween);

export default {
	name: 'datepicker',

	type: 'component',

	extends: FormSet,

	props: ['minDate', 'maxDate'],

	computed: {
		initialDate() {
			if (this.currentDate) {
				return this.currentDate;
			}

			if (this.value) {
				return dayjs(this.value);
			}

			return this.today;
		},

		navLabel() {
			const current = this.initialDate,
				decade = this.getDecade(current.year());

			switch (this.mode) {
				case 'day':
					return `${this.monthNames[current.month()]}, ${current.year()}`;
					break;

				case 'month':
					return current.year();
					break;

				case 'year':
					return `${decade} - ${decade + this.monthsLength - 1}`;
					break;
			}
		},

		days() {
			const current = this.initialDate,
				startDay = current.startOf('month').day(),
				currentDays = this.getCurrentDays(current);

			let days = currentDays;

			if (startDay) {
				days = this.getPastDays(current, startDay).concat(currentDays);
			}

			if (days.length < this.daysLength) {
				days = days.concat(this.getNextDays(current, this.daysLength - days.length));
			}

			return days;
		},

		months() {
			const months = []

			this.monthNames.forEach((i, index) => {
				const month = {};

				month.text = i.substr(0, 3);
				month.index = index;
				month.isCurrent = this.isCurrentMonth(index);

				months.push(month);
			});

			return months;
		},

		years() {
			const years = [],
				decade = this.getDecade(parseInt(this.initialDate.format('YYYY')));

			for (let i = 0; i < this.yearsLength; i++) {
				const year = {},
					yearText = decade + i;

				year.text = yearText;
				year.isCurrent = this.isCurrentYear(yearText);

				years.push(year)
			}

			return years;
		},

		selectedDate() {

			return (this.value) ? dayjs(this.value).format(this.prettyFormat) : '';
		}
	},

	data() {
		return {
			open: false,
			weekHeaders: 'DSTQQSS'.split(''),
			monthNames: 'Janeiro Fevereiro Março Abril Maio Junho Julho Agosto Setembro Outubro Novembro Dezembro'.split(' '), // eslint-disable-line max-len
			daysLength: 42,
			monthsLength: 12,
			yearsLength: 12,
			today: dayjs(),
			defaultFormat: 'YYYY-MM-DD',
			prettyFormat: 'DD/MM/YYYY',
			dayFormat: 'D',
			currentDate: null,
			selected: null,
			mode: 'day'
		};
	},

	methods: {
		toggle(event) {
			if (this.$refs.datepicker.contains(event.target)) {
				return;
			}

			this.open = !this.open;
		},

		isToday(date) {
			return dayjs(this.today.format(this.defaultFormat)).isSame(date.format(this.defaultFormat));
		},

		isCurrentMonth(month) {
			return this.initialDate.month() === month;
		},

		isCurrentYear(year) {
			return this.initialDate.year() === year;
		},

		isSelected(date) {
			const d = this.selected || this.value;

			return dayjs(d || 0).isSame(date.format(this.defaultFormat), 'day');
		},

		isInRange(date) {
			if (!this.minDate && !this.maxDate) {
				return true;
			}

			if (this.minDate && !this.maxDate) {
				return date.isSameOrAfter(this.minDate);
			}

			if (!this.minDate && this.maxDate) {
				return date.isSameOrBefore(this.maxDate);
			}

			return date.isBetween(
				this.minDate, this.maxDate, null, '['
			);
		},

		setMode(mode = this.mode) {
			this.mode = mode;
		},

		setDay(date, past = false, next = false) {
			const day = {};

			day.text = date.format(this.dayFormat);
			day.date = date.format(this.defaultFormat);
			day.isToday = this.isToday(date);
			day.isSelected = this.isSelected(date);
			day.isInRange = this.isInRange(date);
			day.isPast = past;
			day.isNext = next;

			return day;
		},

		getCurrentDays(current) {
			const length = current.daysInMonth(),
				currentMonth = current.startOf('month'),
				days = [];

			for (let i = 0; i < length; i++) {
				days.push(this.setDay(currentMonth.add(i, 'day')));
			}

			return days;
		},

		getPastDays(current, startDay) {
			const pastMonth = current.add(-1, 'month'),
				endOfMonth = pastMonth.endOf('month'),
				days = [];

			for (let i = startDay - 1; i >= 0; i--) {
				days.push(this.setDay(endOfMonth.add(i * -1, 'day'), true));
			}

			return days;
		},

		getNextDays(current, remaining) {
			const nextMonth = current.add(1, 'month'),
				days = [];

			for (let i = 0; i < remaining; i++) {
				days.push(this.setDay(nextMonth.startOf('month').add(i, 'day'), false, true));
			}

			return days;
		},

		getDecade(year) {
			return Math.ceil((year - 9) / 10) * 10;
		},

		nav(direction) {
			let step = direction === 'prev' ? -1 : 1,
				unit = 'month';

			if (this.mode === 'month') {
				unit = 'year';
			}

			if (this.mode === 'year') {
				step *= 10;
				unit = 'year';
			}

			this.currentDate = dayjs(this.initialDate).add(step, unit);
		},

		changeMode() {
			switch (this.mode) {
				case 'day':
					this.setMode('month');
					break;

				case 'month':
					this.setMode('year');
					break;

				case 'year':
					this.setMode('day');
					break;
			}
		},

		selectDate(date) {
			this._value = this.selected = date;
			this.open = false;
		},

		selectMonth(index) {
			this.currentDate = this.initialDate.set('month', index);
			this.setMode('day');
		},

		selectYear(year) {
			this.currentDate = this.initialDate.set('year', year);
			this.setMode('month');
		}
	}
};
