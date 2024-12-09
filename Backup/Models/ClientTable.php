<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientTable extends Model
{
    use HasFactory;

    // Specify the table name if it does not follow the convention
    protected $table = 'clients_tables';

    protected $fillable = ['client_id', 'table_name'];

    public function columns()
    {
        return $this->hasMany(Column::class);
    }

    public function metadataTables()
    {
        return $this->hasMany(MetadataTable::class);
    }
}

