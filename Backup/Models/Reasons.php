<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Reasons extends Authenticatable
{
    protected $table = 'Reasons'; // Specify the table name

    protected $primaryKey = 'id'; // Specify the primary key

    protected $fillable = [
       'id','Reasons','Type', 'TypeDefintion', 'UserType',
    ];

    

}
