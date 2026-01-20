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

INSERT INTO products (product_id, name, description, cost, quantity_on_hand, active) VALUES
(1,'Ceramic Coffee Mug','A durable ceramic mug suitable for hot or cold beverages.',12.99,25,1),
(2,'Notebook Journal','A lined notebook ideal for journaling, note-taking, or planning.',9.49,40,1),
(3,'Ballpoint Pen Set','Set of five smooth-writing ballpoint pens in assorted colors.',6.99,60,1),
(4,'Reusable Water Bottle','Lightweight reusable water bottle with leak-resistant cap.',18.50,30,1),
(5,'Desk Organizer','Compact desk organizer for office supplies and accessories.',22.00,15,1),
(6,'Wireless Mouse','Ergonomic wireless mouse with adjustable DPI settings.',24.99,20,1),
(7,'USB-C Charging Cable','Durable USB-C charging cable compatible with most modern devices.',8.99,50,1),
(8,'Canvas Tote Bag','Reusable canvas tote bag for everyday shopping or errands.',14.75,18,1);