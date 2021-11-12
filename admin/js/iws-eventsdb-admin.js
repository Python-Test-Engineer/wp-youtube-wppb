// Built in file to boilerplate but jQuery replaced with JS.

(function () {
	window.onload = (event) => {
		// get querystring from wp-plugins/wp-admin/admin.php?page=event-management-list-event

		var urlParams = new URLSearchParams(window.location.search);
		const page = urlParams.get('page');
		// console.log('iws-events-admin.js', page);

		// if we are on event-management-list-event then we can
		// avoid console errors if another page is loaded and dom element not present
		// create one event listener on table and get id by event bubbling
		// otherwise have to remove many eventlisteners or meory leak may occur.
		if (page == 'event-management-list-event') {
			debugInfo('IF admin page determination for LIST');
			const tableEvents = document.getElementById('table_events');
			tableEvents.addEventListener('click', handleAction);
		}
		if (page == 'event-management-create-event') {
			debugInfo('IF admin page determination for CREATE');
		}
	};
})();

function handleAction(e) {
	debugInfo('in handleAction iws-eventsdb-admin.js', 'orange');
	const id = e.target.dataset.id;
	const action = e.target.dataset.action;
	console.log('%cListEvents', 'color:orange;font-size:18px;font-weight:bold');
	console.log('id', id, 'action', action);
	if (action == 'edit') {
		// alert(`edit event with id ${id}`);
		console.log(`%cdo edit...${id}`, 'color:green;font-size:18px;');
	}
	if (action == 'delete') {
		// alert(`deleting event with id ${id}`);
		console.log(`%cdo delete...${id}`, 'color:red;font-size:18px;');
	}

	// using REST API we can carry out CRUD on MySQL table and either reload page or use DOM methods to update table on succes of CRUF.
}
