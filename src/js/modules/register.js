import asyncComponents from '@modules/async-components';

import Navbar from '@components/navbar';
import Sidebar from '@components/sidebar';

import Home from '@views/home';
import Typography from '@views/typography';
import Colors from '@views/colors';
import Icons from '@views/icons';
import Buttons from '@views/buttons';
import Forms from '@views/forms';
import Cards from '@views/cards';
import Tabs from '@views/tabs';
import Tables from '@views/tables';

export default function () {
	asyncComponents([
		Navbar,
		Sidebar,
		Home,
		Typography,
		Colors,
		Icons,
		Buttons,
		Forms,
		Cards,
		Tabs,
		Tables
	]);
}
