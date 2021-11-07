This is react login for front side Event Tool page that is created on plugin install.

It is enqueued in public/class-iws-eventsdb-public.php and uses a div with id of root-react in the react folder.

pulbic/paritals/event-tool-layout.php has HTML with a div with this id so the react app injects itself here.

It needs a filter our_own_custom_page_template() in public/class-iws-eventsdb-public.php to filter the page_template and return the plugin tremplate not the theme's.

When we activate plugin a page event-tool is created that is then redirected via the page_template filter to the template page in react
