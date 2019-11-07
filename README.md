



# Laravel Context

## Concept

The basic idea is to provide your application with context specific information. 

A common use case is that of providing structured information from PHP to the JS frontend. 
It could for instance info about the current page, the logged in user, environment, translations, routes and so on.

## Installation

Using composer
```shell script
composer require morningtrain/laravel-context
```


## Usage

### Environment
Write the following in your blade file to output the environment data
```blade
{!! Context::env() !!}
```

The resulting output in the DOM
```javascript
<script>window.env={};</script>
```

In order to add information to the env variable, call the following method from any place in PHP

```php
Context::env([]);
```
