<?php

// app/Models/CartItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['user_id', 'comp_component_id', 'quantity'];

    public function component()
    {
        return $this->belongsTo(CompComponent::class, 'comp_component_id');
    }
}

