# Core Web App - Core Module

## Installation

```bash
composer require gerizal/core-module dev-master
```

## Hooks

To use action and filter hooks, please follow these steps:

Open <strong>config/app.php</strong> file and add this to the providers array:

```php
Modules\Core\Providers\CwaHookServiceProvider::class,
```

Next, add this to the aliases array:

```php
'CwaHooks' => Modules\Core\Facades\CwaHooks::class,
```

If you open the <strong>Providers/CwaHookServiceProvider.php</strong>, there are action and filter hook for testing. To use those hooks, you can try something like this:

```php
\CwaHooks::action('cwa.test.action.hook', 'awesome');
\CwaHooks::filter('cwa.test.filter.hook', 'awesome');
```

To test the hooks via <strong>blade template</strong>, you can try something like this:

```php
@action('cwa.test.action.hook', 'awesome')
@filter('cwa.test.filter.hook', 'awesome')
```

<strong>Hooks Development</strong>

Right now, the action and filter hooks are just for testing. For future development, if there is some hooks that needs to be implemented in Core Web App, the main file to add hooks (both action and filter) will be in <strong>Providers/CwaHookServiceProvider.php</strong>.