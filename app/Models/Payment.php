<?php
// Models/Payment.php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'cart_id', 'comp_component_id'];

    public function cartItems()
    {
        return $this->belongsTo(CartItem::class, 'cart_id');
    }
}
