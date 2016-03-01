# App doctrine provider

[![Build Status](https://img.shields.io/travis/weew/php-app-doctrine.svg)](https://travis-ci.org/weew/php-app-doctrine)
[![Code Quality](https://img.shields.io/scrutinizer/g/weew/php-app-doctrine.svg)](https://scrutinizer-ci.com/g/weew/php-app-doctrine)
[![Test Coverage](https://img.shields.io/coveralls/weew/php-app-doctrine.svg)](https://coveralls.io/github/weew/php-app-doctrine)
[![Version](https://img.shields.io/packagist/v/weew/php-app-doctrine.svg)](https://packagist.org/packages/weew/php-app-doctrine)
[![Licence](https://img.shields.io/packagist/l/weew/php-app-doctrine.svg)](https://packagist.org/packages/weew/php-app-doctrine)

## Table of contents

- [Installation](#installation)
- [Introduction](#introduction)
- [Usage](#usage)
- [Example config](#example-config)
- [Doctrine console](#doctrine-console)

## Installation

`composer require weew/php-app-doctrine`

## Introduction

This package integrates [doctrine/orm](https://github.com/doctrine/doctrine2) and [doctrine/migrations](https://github.com/doctrine/migrations) into the [weew/php-app](https://github.com/weew/php-app) framework.

## Usage

Simply register the `DoctrineProvider` class on the application kernel:

```php
$app = new App();
$app->getKernel()->addProviders([
    DoctrineProvider::class,
]);
```

## Example config

This is how your config *might* look like in yaml:

```yaml
    debug: true

    doctrine:
        entities_path: "path/to/entities"
        cache_path: "path/to/cache"

        config:
            driver: "pdo_mysql"
            host: "database_hostname"
            dbname: "database_name"
            user: "database_user"
            password: "database_password"

        migrations:
            namespace: "migrations/namespace"
            path: "migrations/directory/path"
            table: "migrations_table_name"
```

## Doctrine console

You can run doctrine console tool like this:

```php
$doctrineProvider->runConsoleRunner();
```
