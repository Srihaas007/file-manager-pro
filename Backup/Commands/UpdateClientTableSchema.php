<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class UpdateClientTableSchema extends Command
{
    protected $signature = 'schema:update-client-table';
    protected $description = 'Update client table schema based on client_column_metadata';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Retrieve column metadata
        $columns = DB::table('client_column_metadata')->get();

        foreach ($columns as $column) {
            if (!Schema::hasColumn('client', $column->column_name)) {
                Schema::table('client', function (Blueprint $table) use ($column) {
                    $columnType = $this->mapDataType($column->data_type, $column->is_boolean);
                    $length = $column->length ? $column->length : null;

                    // Add new column
                    $newColumn = $table->$columnType($column->column_name, $length);

                    // Apply nullable constraint
                    if ($column->nullable) {
                        $newColumn->nullable();
                    } else {
                        $newColumn->nullable(false);
                    }

                    // Apply default value if specified
                    if ($column->data_type === 'integer') {
                        if ($column->default_int !== null) {
                            $newColumn->default((int) $column->default_int);
                        } else {
                            $newColumn->default(0); // Default value for nullable integer columns
                        }
                    } else {
                        if ($column->default !== null && $column->default !== '') {
                            $newColumn->default($column->default);
                        }
                    }
                });
            }
        }

        $this->info('Client table schema updated successfully.');
    }


    private function mapDataType($type, $isBoolean)
    {
        if ($isBoolean) {
            return 'boolean';
        }

        switch ($type) {
            case 'string':
                return 'string';
            case 'integer':
                return 'integer';
            case 'boolean':
                return 'boolean';
            default:
                throw new \Exception("Unsupported data type: $type");
        }
    }
}
