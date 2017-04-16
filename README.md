# Dbmover\PgsqlTables
PostgreSQL-specific table migration plugin for DbMover

## Installation
```sh
$ composer require dbmover/pgsql-tables
```

    This package is part of the `dbmover/pgsql` meta-package.

## Usage
See `dbmover/core`.

## Caveats
Temporary tables aren't supported; what would they even be doing in your schema?

## Todo
Only generate the necessary statements, e.g. don't `SET NOT NULL` if a column
is already marked as such.

## Contributing
See `dbmover/core`.

