# Picolo
Picolo is a skeleton for Silex microframework.

## Requirements
 * PHP >= 5.3

## Installation
```
composer create-project hlynx/picolo <project_name>
```

For production from htdocs/.htaccess delete line
```
SetEnv APP_ENV dev
```

## Structure

### /app/Application.php
Applications class

### /app/bootstrap.php
A place to include providers (database support, twig support, user management support, ...)

### /config/
A place for config files (project settings, routing)

### /src/
This folder should contain code of your application.
Paths to files should be the same as their namespaces.

### /templates/
A place for html templates

### /htdocs/
Folder where your web server sholuld be pointed.
APP_ENV - default value is `prod`
APP_ENV = dev - value for development
