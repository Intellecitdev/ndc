<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    use LogsActivity;

    protected $fillable = ['short', 'name', 'order', 'status'];

    protected function casts(): array
    {
        return ['status' => 'boolean'];
    }
}
