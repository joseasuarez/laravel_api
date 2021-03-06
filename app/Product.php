<?php

namespace App;

use App\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    const PRODUCTO_DISPONIBLE ="disponible";
    const PRODUCTO_NO_DISPONIBLE ="no disponible";

    protected $hidden = [
        'pivot'
    ];

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id',
    ];

    protected $dates = ['deleted_at'];

    public $transformer = ProductTransformer::class;

    public function estaDisponible(){
        return $this->status == Product::PRODUCTO_DISPONIBLE;
    }
    public function seller(){
        return $this->belongsTo(Seller::class);
    }
    public function transactions(){
        return $this->hasMany(Transaction::class);
    }
    public function categories(){
        return $this->belongsToMany(Category::class);
    }

}
