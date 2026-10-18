<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use LogsActivity;

    protected $fillable = ['code', 'name', 'address', 'type', 'order', 'status'];

    protected function casts(): array
    {
        return ['status' => 'boolean'];
    }
}
