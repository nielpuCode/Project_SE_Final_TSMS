<?php
// CompComponent.php model

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompComponent extends Model
{
    use HasFactory;

    protected $fillable = ['picture', 'name', 'vendor', 'description', 'quantity', 'category', 'price'];
}
