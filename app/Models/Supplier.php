<?php

namespace App\Models;

use App\Models\Concerns\MasterData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use MasterData;

    protected $fillable = ['code', 'name', 'contact_person', 'contact_no', 'email', 'address', 'status'];

}
