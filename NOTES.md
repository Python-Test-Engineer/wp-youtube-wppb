We register rest routes in admin/class-iws-eventsdb-admin.php after placing

```
$this->loader->add_action( 'rest_api_init', $plugin_admin, 'create_rest_routes' );
```

in define_admin_hooks() in includes/class-iws-eventsdb.php

For public we use page_emplate filter and use public/parials/event-tool-layout with appropriate div to render react in.

In class-iws-eventsdb-public.php we enqueue the react script there

```
	// If we are on page-react-login.php or in plguin at event-toolthen load the react bundle
		$path = EVENTSDB_MANAGEMENT_TOOL_PLUGIN_URL.'react/build/index.js';
		if (is_page('react-login') || (is_page('event_tool'))) {
			wp_enqueue_script('react-login',$path, array('wp-element'), '1.0', true);
		}
```

page react-login is outside of plugin. event_tool is page we create dynamiclly on plugin activation.
