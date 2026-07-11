<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceItemModel extends Model
{
    protected $table            = 'invoice_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'invoice_id', 
        'product_id', 
        'product_code', 
        'product_name', 
        'unit', 
        'qty', 
        'price', 
        'total_price'
    ];
}
