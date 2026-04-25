-- Starting schema inferred from the PHP application.
-- Review and adapt before applying to an existing production database.

CREATE DATABASE IF NOT EXISTS pos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pos;

CREATE TABLE IF NOT EXISTS user (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  address VARCHAR(255) DEFAULT '',
  phone_number VARCHAR(50) DEFAULT '',
  role_id INT NOT NULL DEFAULT 1
);

CREATE TABLE IF NOT EXISTS client (
  client_id INT AUTO_INCREMENT PRIMARY KEY,
  balance_usd DECIMAL(12,2) NOT NULL DEFAULT 0,
  name VARCHAR(255) NOT NULL,
  MOF VARCHAR(100) DEFAULT '',
  address VARCHAR(255) DEFAULT '',
  phone_number VARCHAR(50) DEFAULT '',
  discount DECIMAL(8,2) NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS supplier (
  supplier_id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  location VARCHAR(255) DEFAULT '',
  phone_number VARCHAR(50) DEFAULT '',
  email VARCHAR(255) DEFAULT '',
  balance_usd DECIMAL(12,2) NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS item (
  item_id INT AUTO_INCREMENT PRIMARY KEY,
  item_code VARCHAR(100) NOT NULL UNIQUE,
  name VARCHAR(255) NOT NULL,
  buying_price DECIMAL(12,4) NOT NULL DEFAULT 0,
  selling_price DECIMAL(12,4) NOT NULL DEFAULT 0,
  size VARCHAR(100) DEFAULT '',
  diameter VARCHAR(100) DEFAULT '',
  brand VARCHAR(100) DEFAULT '',
  material VARCHAR(100) DEFAULT '',
  description TEXT,
  country_of_origin VARCHAR(100) DEFAULT '',
  stock INT NOT NULL DEFAULT 0,
  ministry_code VARCHAR(100) DEFAULT ''
);

CREATE TABLE IF NOT EXISTS sell_cart (
  cart_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS purchase_cart (
  cart_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS items_in_sell_cart (
  items_in_cart_id INT AUTO_INCREMENT PRIMARY KEY,
  cart_id INT NOT NULL,
  item_id INT NOT NULL,
  quantity INT NOT NULL DEFAULT 1,
  price DECIMAL(12,4) NOT NULL DEFAULT 0,
  FOREIGN KEY (cart_id) REFERENCES sell_cart(cart_id) ON DELETE CASCADE,
  FOREIGN KEY (item_id) REFERENCES item(item_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS items_in_purchase_cart (
  items_in_cart_id INT AUTO_INCREMENT PRIMARY KEY,
  cart_id INT NOT NULL,
  item_id INT NOT NULL,
  quantity INT NOT NULL DEFAULT 1,
  price DECIMAL(12,4) NOT NULL DEFAULT 0,
  FOREIGN KEY (cart_id) REFERENCES purchase_cart(cart_id) ON DELETE CASCADE,
  FOREIGN KEY (item_id) REFERENCES item(item_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS sell_invoice (
  invoice_id INT AUTO_INCREMENT PRIMARY KEY,
  invoice_group VARCHAR(100) NOT NULL,
  client_id INT NULL,
  invoice_date_of_sale DATETIME NOT NULL,
  amount_paid DECIMAL(12,2) NOT NULL DEFAULT 0,
  FOREIGN KEY (client_id) REFERENCES client(client_id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS purchase_invoice (
  invoice_id INT AUTO_INCREMENT PRIMARY KEY,
  invoice_group VARCHAR(100) NOT NULL,
  supplier_id INT NULL,
  invoice_date_of_sale DATETIME NOT NULL,
  amount_paid DECIMAL(12,2) NOT NULL DEFAULT 0,
  FOREIGN KEY (supplier_id) REFERENCES supplier(supplier_id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS sell (
  sell_id INT AUTO_INCREMENT PRIMARY KEY,
  client_id INT NULL,
  item_code VARCHAR(100) NOT NULL,
  price DECIMAL(12,4) NOT NULL DEFAULT 0,
  date_of_sale DATETIME NULL,
  payment_type VARCHAR(50) DEFAULT '',
  amount DECIMAL(12,2) NOT NULL DEFAULT 0,
  quantity INT NOT NULL DEFAULT 1,
  invoice_group VARCHAR(100) DEFAULT '',
  FOREIGN KEY (client_id) REFERENCES client(client_id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS purchase (
  purchase_id INT AUTO_INCREMENT PRIMARY KEY,
  supplier_id INT NULL,
  item_code VARCHAR(100) NOT NULL,
  price_per_item DECIMAL(12,4) NOT NULL DEFAULT 0,
  date_of_purchase DATETIME NULL,
  amount DECIMAL(12,2) NOT NULL DEFAULT 0,
  quantity INT NOT NULL DEFAULT 1,
  user_id INT NULL,
  invoice_group VARCHAR(100) DEFAULT '',
  FOREIGN KEY (supplier_id) REFERENCES supplier(supplier_id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS balance (
  balance_id INT AUTO_INCREMENT PRIMARY KEY,
  amount DECIMAL(12,2) NOT NULL DEFAULT 0,
  currency VARCHAR(10) NOT NULL DEFAULT 'USD',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS logo (
  logo_id INT AUTO_INCREMENT PRIMARY KEY,
  logo_name VARCHAR(255) NOT NULL,
  directory VARCHAR(255) NOT NULL
);
