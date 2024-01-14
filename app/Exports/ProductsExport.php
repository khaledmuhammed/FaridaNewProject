<?php

namespace App\Exports;

use App\Models\{Product};
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;

class ProductsExport implements FromCollection
{
    use Exportable;
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::where('availability' , true)->get()->map(function($p){
            return [
                $p->id, 
                $p->name,
                $p->description,
                "https://faridaflowers.com/products/{$p->id}",
                $p->getMedia("images")->first() ?  $p->getMedia("images")->first()->url : '',
                $p->quantity > 0 ? 'in stock' : 'out of stock',
                $p->price_after_discount ?? $p->original_price ,
                "faridaflowers"
            ] ;
        });
    }
}
