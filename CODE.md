DELETE FROM `boiler_posts` WHERE `post_name` = 'js-app';
DELETE FROM `boiler_posts` WHERE `post_name` = 'react';
DELETE FROM `boiler_posts` WHERE `post_name` = 'svelte-app';

```
SELECT * FROM `boiler_posts` WHERE `post_name` IN ('react', 'svelte-app','js-app')
```