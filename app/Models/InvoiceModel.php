<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceModel extends Model
{
    protected $table            = 'invoices';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'invoice_number', 
        'customer_id', 
        'invoice_date', 
        'signed_place', 
        'purchasing_user_id', 
        'customer_signer_name', 
        'total_qty', 
        'total_amount', 
        'status'
    ];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // Helper to get detailed invoice data
    public function getInvoiceDetails($id = null)
    {
        $builder = $this->db->table($this->table)
            ->select('invoices.*, customers.name as customer_name, customers.address as customer_address, customers.contact_person as customer_cp, customers.phone as customer_phone, customers.email as customer_email, users.name as user_name, users.role as user_role')
            ->join('customers', 'customers.id = invoices.customer_id', 'left')
            ->join('users', 'users.id = invoices.purchasing_user_id', 'left');

        if ($id !== null) {
            return $builder->where('invoices.id', $id)->get()->getRowArray();
        }

        return $builder->orderBy('invoices.invoice_date', 'DESC')->get()->getResultArray();
    }
}
