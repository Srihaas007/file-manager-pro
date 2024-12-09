<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientColumnMetadata extends Model
{
    use HasFactory;

    protected $table = 'client_column_metadata';

    protected $fillable = [
        'column_name',
        'data_type',
        'length',
        'default',
        'is_boolean',
    ];
}
