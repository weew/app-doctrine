# App doctrine provider

[![Build Status](https://img.shields.io/travis/weew/php-app-doctrine.svg)](https://travis-ci.org/weew/php-app-doctrine)
[![Code Quality](https://img.shields.io/scrutinizer/g/weew/php-app-doctrine.svg)](https://scrutinizer-ci.com/g/weew/php-app-doctrine)
[![Test Coverage](https://img.shields.io/coveralls/weew/php-app-doctrine.svg)](https://coveralls.io/github/weew/php-app-doctrine)
[![Version](https://img.shields.io/packagist/v/weew/php-app-doctrine.svg)](https://packagist.org/packages/weew/php-app-doctrine)
[![Licence](https://img.shields.io/packagist/l/weew/php-app-doctrine.svg)](https://packagist.org/packages/weew/php-app-doctrine)

## Table of contents

- [Installation](#installation)
- [Introduction](#introduction)
- [Requirements](#requirements)
- [Usage](#usage)

## Installation

`composer require weew/php-app-doctrine`

## Introduction

This package integrates the [doctrine/orm](https://github.com/doctrine/doctrine2) package into the [weew/php-app](https://github.com/weew/php-app) framework.

## Requirements

To be able to use this package you must ensure certain configs are set:
- `doctrine.config` all doctrine database related stuff
- `doctrine.entities_path` path to the directory with entities
- `debug` debug mode setting

## Usage

Simply register the `DoctrineProvider` class on the application kernel:

```php
$app = new App();
$app->getKernel()->addProviders([
    DoctrineProvider::class,
]);
```
