<?php

namespace App\Models;

use App\Models\Concerns\MasterData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Layer extends Model
{
    use MasterData;

    protected $fillable = ['category_id', 'product_model_id', 'name', 'status'];

    public function productModel(): BelongsTo
    {
        return $this->belongsTo(ProductModel::class);
    }
}
