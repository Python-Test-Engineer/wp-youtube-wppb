We use document.getElementById('svelte') in the JS

in public/partials/svelte-tool.layout.php we use:

```
<div id="svelte" ></div>

```

In public/class-iws-eventsdb-public.php we enqueu

```
	$path_js = EVENTSDB_MANAGEMENT_TOOL_PLUGIN_URL.'svelte/build/bundle.js';
		$path_css = EVENTSDB_MANAGEMENT_TOOL_PLUGIN_URL.'svelte/build/bundle.css';

		if ( (is_page('svelte-app'))) {
			wp_enqueue_script('svelte_js', $path_js, array(), '1.0', true);
			wp_enqueue_style( 'svelte_css',$path_css, array(), $this->version, 'all' );
		}
```

We have a filter for page_template located includes/class-iws-eventsdb.php for public hooks where all admin and public hooks are registered. The function is is in class-iws-eventsdb-public.php as a function called our_own_custom_page_template()

In same file we use a filter in to redirect:

```
	if($post->post_name == "svelte-app"){

		 $page_template = EVENTSDB_MANAGEMENT_TOOL_PLUGIN_PATH."public/partials/svelte-tool-layout.php";

		 return $page_template;
		}
```

NB in includes activator the page_title = 'SVELTE' but the post_name = 'svelte-app'
