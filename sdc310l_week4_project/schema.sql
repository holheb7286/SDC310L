-- Use existing database
USE sdc310l_hebert;

CREATE TABLE IF NOT EXISTS products (
  product_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  description TEXT NOT NULL,
  cost DECIMAL(10,2) NOT NULL,
  quantity_on_hand INT(10) UNSIGNED NOT NULL,
  active TINYINT(4) NOT NULL,
  PRIMARY KEY (product_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS cart_items (
  cart_item_id INT(11) NOT NULL AUTO_INCREMENT,
  session_id VARCHAR(128) NOT NULL,
  product_id INT(10) UNSIGNED NOT NULL,
  quantity INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (cart_item_id),
  UNIQUE KEY uq_session_product (session_id, product_id)
) ENGINE=InnoDB;

-- Optional foreign key (add after confirming types match)
ALTER TABLE cart_items
  ADD CONSTRAINT fk_cart_product
  FOREIGN KEY (product_id) REFERENCES products(product_id)
  ON DELETE RESTRICT;