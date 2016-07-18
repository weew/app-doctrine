# App doctrine provider

[![Build Status](https://img.shields.io/travis/weew/app-doctrine.svg)](https://travis-ci.org/weew/app-doctrine)
[![Code Quality](https://img.shields.io/scrutinizer/g/weew/app-doctrine.svg)](https://scrutinizer-ci.com/g/weew/app-doctrine)
[![Test Coverage](https://img.shields.io/coveralls/weew/app-doctrine.svg)](https://coveralls.io/github/weew/app-doctrine)
[![Version](https://img.shields.io/packagist/v/weew/app-doctrine.svg)](https://packagist.org/packages/weew/app-doctrine)
[![Licence](https://img.shields.io/packagist/l/weew/app-doctrine.svg)](https://packagist.org/packages/weew/app-doctrine)

## Table of contents

- [Installation](#installation)
- [Introduction](#introduction)
- [Usage](#usage)
- [Example config](#example-config)
- [Doctrine console](#doctrine-console)

## Installation

`composer require weew/app-doctrine`

## Introduction

This package integrates [doctrine/orm](https://github.com/doctrine/doctrine2) and [doctrine/migrations](https://github.com/doctrine/migrations) into the [weew/app](https://github.com/weew/app) framework.

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
doctrine:
  debug: true

  cache_path: path/to/cache
  proxy_classes_path: path/to/proxies
  metadata_format: "yaml" or "annotations"

  # required if metadata_format is "annotations"
  entities_paths:
    path/to/entities: Namespace\To\Entities

  # required if metadata_format is "yaml"
  entities_mappings:
    app:
      path: path/to/entities
      namespace: Some\Entities
    bundle:
      path: path/to/bundle/entities
      namespace: Other\Entities

  config:
    driver: pdo_mysql
    host: database_hostname
    dbname: database_name
    user: database_user
    password: database_password

  migrations:
    namespace: migrations/namespace
    path: migrations/directory/path
    table: migrations_table_name
```

## Doctrine console

You can run doctrine console tool like this:

```php
$doctrineProvider->runConsoleRunner();
```
