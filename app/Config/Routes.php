<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Authentication Routes
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('logout', 'Auth::logout');

// Secure Admin Panel Routes
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('dashboard', 'Dashboard::index');
    
    // Settings CRUD (single row profile update)
    $routes->get('settings', 'Settings::index');
    $routes->post('settings/update', 'Settings::update');
    
    // Users CRUD
    $routes->get('users', 'Users::index');
    $routes->get('users/create', 'Users::create');
    $routes->post('users/store', 'Users::store');
    $routes->get('users/edit/(:num)', 'Users::edit/$1');
    $routes->post('users/update/(:num)', 'Users::update/$1');
    $routes->get('users/delete/(:num)', 'Users::delete/$1');
    
    // Customers CRUD
    $routes->get('customers', 'Customers::index');
    $routes->get('customers/create', 'Customers::create');
    $routes->post('customers/store', 'Customers::store');
    $routes->get('customers/edit/(:num)', 'Customers::edit/$1');
    $routes->post('customers/update/(:num)', 'Customers::update/$1');
    $routes->get('customers/delete/(:num)', 'Customers::delete/$1');
    
    // Products CRUD
    $routes->get('products', 'Products::index');
    $routes->get('products/create', 'Products::create');
    $routes->post('products/store', 'Products::store');
    $routes->get('products/edit/(:num)', 'Products::edit/$1');
    $routes->post('products/update/(:num)', 'Products::update/$1');
    $routes->get('products/delete/(:num)', 'Products::delete/$1');
    
    // Invoices / Transactions CRUD
    $routes->get('invoices', 'Invoices::index');
    $routes->get('invoices/create', 'Invoices::create');
    $routes->post('invoices/store', 'Invoices::store');
    $routes->get('invoices/edit/(:num)', 'Invoices::edit/$1');
    $routes->post('invoices/update/(:num)', 'Invoices::update/$1');
    $routes->get('invoices/delete/(:num)', 'Invoices::delete/$1');
    $routes->get('invoices/detail/(:num)', 'Invoices::detail/$1');
    $routes->get('invoices/print/(:num)', 'Invoices::print/$1');
    $routes->get('invoices/update-status/(:num)/(:any)', 'Invoices::updateStatus/$1/$2');
});
