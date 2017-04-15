<?php

/**
 * @package Dbmover
 * @subpackage Pgsql
 * @subpackage Tables
 */

namespace Dbmover\Pgsql\Tables;

use Dbmover\Tables;
use Dbmover\Core\Loader;
use PDO;

class Plugin extends Tables\Plugin
{
    protected $columns;

    public function __construct(Loader $loader)
    {
        parent::__construct($loader);
        $this->columns = $this->loader->getPdo()->prepare(
            "SELECT
                column_name,
                column_default,
                is_nullable,
                data_type column_type
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE ((TABLE_CATALOG = ? AND TABLE_SCHEMA = 'public') OR TABLE_SCHEMA = ?)
                AND TABLE_NAME = ?
            ORDER BY ORDINAL_POSITION ASC");
    }

    protected function modifyColumn(string $table, string $column, array $definition) : string
    {
        $sql = '';
        $sql .= "ALTER TABLE $table ALTER COLUMN $column TYPE {$definition['column_type']};";
        if (strlen($definition['column_default'])) {
            $sql .= "ALTER TABLE $table ALTER COLUMN $column SET DEFAULT {$definition['_default']};";
        } else {
            $sql .= "ALTER TABLE $table ALTER COLUMN $column DROP DEFAULT;";
        }
        if ($definition['is_nullable']) {
            $sql .= "ALTER TABLE $table ALTER COLUMN $column DROP NOT NULL;";
        } else {
            $sql .= "ALTER TABLE $table ALTER COLUMN $column SET NOT NULL;";
        }
        return $sql;
    }
}

