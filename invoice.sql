-- =====================================================
-- DATABASE: invoice_db
-- Deskripsi: Struktur database aplikasi Invoice
-- (Studi kasus: PT. Bhinneka Sangkuriang Transport)
-- =====================================================

CREATE DATABASE IF NOT EXISTS invoice_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE invoice_db;

-- =====================================================
-- TABEL: settings
-- Data profil perusahaan penerbit invoice (hanya 1 baris)
-- =====================================================
CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(150) NOT NULL,
    company_address TEXT,
    company_phone VARCHAR(30),
    company_email VARCHAR(100),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO settings (company_name, company_address, company_phone, company_email)
VALUES (
    'PT. Bhinneka Sangkuriang Transport',
    'Jl. Gedebage Selatan No.121A, Cisaranten Kidul, Kec. Gedebage, Kota Bandung, Jawa Barat 40552',
    '022-1234567',
    'info@bhinnekasangkuriang.co.id'
);

-- =====================================================
-- TABEL: users
-- Data pengguna sistem (login, penandatangan invoice)
-- =====================================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    role VARCHAR(50),                -- contoh: Purchasing, Admin, Finance
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO users (name, role, username, password) VALUES
('Ilham', 'Purchasing', 'ilham', '$2y$10$hashedpasswordexample1'),
('Admin', 'Admin', 'admin', '$2y$10$hashedpasswordexample2');

-- =====================================================
-- TABEL: customers
-- Master data pelanggan
-- =====================================================
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    address TEXT,
    contact_person VARCHAR(100),     -- contoh: "Robert" (Up:)
    phone VARCHAR(30),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO customers (name, address, contact_person, phone, email) VALUES
('PT. SENTOSA', 'Jl. Bypass Cirebon', 'Robert', '0231-1234567', 'robert@sentosa.co.id');

-- =====================================================
-- TABEL: products
-- Master data barang/produk
-- =====================================================
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(20) UNIQUE NOT NULL,   -- contoh: PR01
    name VARCHAR(150) NOT NULL,
    unit VARCHAR(20) NOT NULL,          -- contoh: Pcs, Dus, Liter
    price DECIMAL(15,2) NOT NULL,       -- harga default/terbaru
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO products (code, name, unit, price) VALUES
('PR01', 'Ban Luar', 'Pcs', 2300000),
('PR02', 'Baut Ukuran 18', 'Dus', 110000),
('PR03', 'Oli Mesin', 'Liter', 125000);

-- =====================================================
-- TABEL: invoices
-- Header invoice
-- =====================================================
CREATE TABLE invoices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_number VARCHAR(50) UNIQUE NOT NULL,   -- contoh: 034/TD/XI/2024
    customer_id INT NOT NULL,
    invoice_date DATE NOT NULL,
    signed_place VARCHAR(50),                     -- contoh: Cirebon
    purchasing_user_id INT,                       -- FK ke users, penandatangan pihak 1
    customer_signer_name VARCHAR(100),             -- contoh: Robert
    total_qty DECIMAL(15,2) DEFAULT 0,
    total_amount DECIMAL(15,2) DEFAULT 0,
    status ENUM('draft','sent','paid','cancelled') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    FOREIGN KEY (purchasing_user_id) REFERENCES users(id)
);

INSERT INTO invoices (invoice_number, customer_id, invoice_date, signed_place, purchasing_user_id, customer_signer_name, total_qty, total_amount, status)
VALUES (
    '034/TD/XI/2024',
    1,
    '2024-06-25',
    'Cirebon',
    1,
    'Robert',
    34,
    25925000,
    'sent'
);

-- =====================================================
-- TABEL: invoice_items
-- Detail baris item invoice
-- Catatan: product_code, product_name, unit, price di-snapshot
-- supaya histori invoice tidak berubah jika master produk diedit
-- =====================================================
CREATE TABLE invoice_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id INT NOT NULL,
    product_id INT NOT NULL,
    product_code VARCHAR(20),
    product_name VARCHAR(150),
    unit VARCHAR(20),
    qty DECIMAL(15,2) NOT NULL,
    price DECIMAL(15,2) NOT NULL,
    total_price DECIMAL(15,2) NOT NULL,
    FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

INSERT INTO invoice_items (invoice_id, product_id, product_code, product_name, unit, qty, price, total_price) VALUES
(1, 1, 'PR01', 'Ban Luar', 'Pcs', 10, 2300000, 23000000),
(1, 2, 'PR02', 'Baut Ukuran 18', 'Dus', 5, 110000, 550000),
(1, 3, 'PR03', 'Oli Mesin', 'Liter', 19, 125000, 2375000);

-- =====================================================
-- INDEX TAMBAHAN untuk performa query
-- =====================================================
CREATE INDEX idx_invoices_customer ON invoices(customer_id);
CREATE INDEX idx_invoices_date ON invoices(invoice_date);
CREATE INDEX idx_invoice_items_invoice ON invoice_items(invoice_id);
CREATE INDEX idx_invoice_items_product ON invoice_items(product_id);