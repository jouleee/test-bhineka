<?php

namespace App\Controllers;

use App\Models\InvoiceModel;
use App\Models\CustomerModel;
use App\Models\ProductModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $invoiceModel = new InvoiceModel();
        $customerModel = new CustomerModel();
        $productModel = new ProductModel();
        $userModel = new UserModel();

        // Calculate KPIs
        $totalRevenue = $invoiceModel->where('status', 'paid')->selectSum('total_amount')->first();
        $totalInvoices = $invoiceModel->countAllResults();
        $totalCustomers = $customerModel->countAllResults();
        $totalProducts = $productModel->countAllResults();

        // Fetch recent invoices
        $recentInvoices = $invoiceModel->getInvoiceDetails();
        $recentInvoices = array_slice($recentInvoices, 0, 5); // get top 5

        $data = [
            'total_revenue'   => $totalRevenue['total_amount'] ?? 0,
            'total_invoices'  => $totalInvoices,
            'total_customers' => $totalCustomers,
            'total_products'  => $totalProducts,
            'recent_invoices' => $recentInvoices,
        ];

        return view('dashboard/index', $data);
    }
}
