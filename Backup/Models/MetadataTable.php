<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetadataTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'column_name', 'data_type', 'length', 'is_boolean', 'nullable',
        'default', 'default_int', 'true_value', 'false_value',
        'client_id', 'table_id', 'table_name','client_column_name'
    ];

    public function clientTable()
    {
        return $this->belongsTo(ClientTable::class, 'table_id');
    }
}
