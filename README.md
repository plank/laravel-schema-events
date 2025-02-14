<p align="center"><a href="https://plank.co"><img src="art/schema-events.png" width="100%"></a></p>

<p align="center">
<a href="https://packagist.org/packages/plank/schema-events"><img src="https://img.shields.io/packagist/php-v/plank/schema-events?color=%23fae370&label=php&logo=php&logoColor=%23fff" alt="PHP Version Support"></a>
<a href="https://laravel.com/docs/11.x/releases#support-policy"><img src="https://img.shields.io/badge/laravel-10.x,%2011.x-%2343d399?color=%23f1ede9&logo=laravel&logoColor=%23ffffff" alt="PHP Version Support"></a>
<a href="https://github.com/plank/schema-events/actions?query=workflow%3Arun-tests"><img src="https://img.shields.io/github/actions/workflow/status/plank/schema-events/run-tests.yml?branch=main&&color=%23bfc9bd&label=run-tests&logo=github&logoColor=%23fff" alt="GitHub Workflow Status"></a>
<a href="https://codeclimate.com/github/plank/schema-events/test_coverage"><img src="https://img.shields.io/codeclimate/coverage/plank/schema-events?color=%23ff9376&label=test%20coverage&logo=code-climate&logoColor=%23fff" /></a>
<a href="https://codeclimate.com/github/plank/schema-events/maintainability"><img src="https://img.shields.io/codeclimate/maintainability/plank/schema-events?color=%23528cff&label=maintainablility&logo=code-climate&logoColor=%23fff" /></a>
</p>

# Laravel Schema Events

Track and respond to database schema changes in your Laravel application through a simple event system.

## Table of Contents

- [Installation](#installation)
- [Quick Start](#quick-start)
- [Configuration](#configuration)
- [Usage](#usage)
  - [Available Events](#available-events)
  - [Event Properties](#event-properties)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)
- [Security Vulnerabilities](#security-vulnerabilities)
- [About Plank](#about-plank)

## Installation

You can install the package via composer:

```bash
composer require plank/laravel-schema-events
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="schema-events-config"
```

## Quick Start

1. Install the package
2. Set up an event listener:

```php
<?php

namespace App\Listeners;

use Plank\LaravelSchemaEvents\Events\TableCreated;

class LogTableCreation
{
    public function handle(TableCreated $event)
    {
        \Log::info("Table {$event->table} was created with columns: " . implode(', ', $event->columns->toArray()));
    }
}
```

3. Register your listener in `EventServiceProvider.php`:

```php
protected $listen = [
    TableCreated::class => [
        LogTableCreation::class,
    ],
];
```

## Configuration

The configuration file allows you to customize:

- Which migration events to listen for
- Which commands are tracked for different schema operations

```php
return [
    'listeners' => [
        'ran' => MigrationRan::class,
        'finished' => MigrationsFinished::class,
    ],
    
    'commands' => [
        'renamed_columns' => ['renameColumn'],
        'dropped_columns' => ['dropColumn'],
        'added_indexes' => [
            'primary',
            'unique',
            'index',
            'fulltext',
            'spatialIndex',
        ],
        // ... additional commands
    ],
];
```

## Usage

### Available Events

The package provides four main events:

1. `TableCreated` - Emitted when a new table is created
2. `TableChanged` - Emitted when an existing table is modified
3. `TableDropped` - Emitted when a table is dropped
4. `TableRenamed` - Emitted when a table is renamed

### Event Properties

Each event includes basic connection information:
- `connection` - The name of the database connection
- `databaseName` - The name of the database
- `driverName` - The database driver being used

#### TableCreated Event
```php
public readonly string $table;
public readonly Collection $columns;      // Added columns
public readonly Collection $indexes;      // Added indexes
public readonly Collection $foreignKeys;  // Added foreign keys
```

#### TableChanged Event
```php
public readonly string $table;
public readonly Collection $addedColumns;
public readonly Collection $droppedColumns;
public readonly Collection $renamedColumns;     // Contains [from => x, to => y]
public readonly Collection $modifiedColumns;
public readonly Collection $addedIndexes;
public readonly Collection $droppedIndexes;
public readonly Collection $renamedIndexes;     // Contains [from => x, to => y]
public readonly Collection $addedForeignKeys;
public readonly Collection $droppedForeignKeys;
```

#### TableDropped Event
```php
public readonly string $table;
```

#### TableRenamed Event
```php
public readonly string $from;
public readonly string $to;
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Kurt Friars](https://github.com/kfriars)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## About Plank

[Plank](https://plankdesign.com) is a web development agency based in Montreal, QC, Canada. We specialize in developing custom content management systems and web applications.

Learn more about us on [our website](https://plankdesign.com).