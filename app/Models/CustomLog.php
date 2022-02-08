<?php

namespace App\Models;

use danielme85\LaravelLogToDB\Models\LogToDbCreateObject;
use Illuminate\Database\Eloquent\Model;

class CustomLog extends Model
{
    use LogToDbCreateObject;

    protected $table = 'log';
    protected $connection = 'mysql';
    
}