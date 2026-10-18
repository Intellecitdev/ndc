<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpFilter extends Model
{
    protected $fillable = ['ip_address', 'type', 'reason', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}
