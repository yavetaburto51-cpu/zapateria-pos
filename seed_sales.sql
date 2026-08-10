START TRANSACTION;

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (1, 2000.00, '2026-07-20 09:15:00', '2026-07-20 09:15:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 1, 1, 2000.00, '2026-07-20 09:15:00', '2026-07-20 09:15:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (2, 1300.00, '2026-07-21 11:10:00', '2026-07-21 11:10:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 2, 2, 650.00, '2026-07-21 11:10:00', '2026-07-21 11:10:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (3, 129.99, '2026-07-22 13:40:00', '2026-07-22 13:40:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 3, 1, 129.99, '2026-07-22 13:40:00', '2026-07-22 13:40:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (4, 279.98, '2026-07-23 16:05:00', '2026-07-23 16:05:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 4, 2, 139.99, '2026-07-23 16:05:00', '2026-07-23 16:05:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (5, 209.97, '2026-07-24 18:20:00', '2026-07-24 18:20:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 5, 3, 69.99, '2026-07-24 18:20:00', '2026-07-24 18:20:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (1, 4000.00, '2026-07-25 08:35:00', '2026-07-25 08:35:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 1, 2, 2000.00, '2026-07-25 08:35:00', '2026-07-25 08:35:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (2, 650.00, '2026-07-26 10:50:00', '2026-07-26 10:50:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 2, 1, 650.00, '2026-07-26 10:50:00', '2026-07-26 10:50:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (3, 259.98, '2026-07-26 15:15:00', '2026-07-26 15:15:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 3, 2, 129.99, '2026-07-26 15:15:00', '2026-07-26 15:15:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (4, 139.99, '2026-07-26 19:30:00', '2026-07-26 19:30:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 4, 1, 139.99, '2026-07-26 19:30:00', '2026-07-26 19:30:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (5, 279.96, '2026-07-26 21:45:00', '2026-07-26 21:45:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 5, 4, 69.99, '2026-07-26 21:45:00', '2026-07-26 21:45:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (1, 2000.00, '2026-07-27 09:00:00', '2026-07-27 09:00:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 1, 1, 2000.00, '2026-07-27 09:00:00', '2026-07-27 09:00:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (2, 1950.00, '2026-07-28 12:20:00', '2026-07-28 12:20:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 2, 3, 650.00, '2026-07-28 12:20:00', '2026-07-28 12:20:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (3, 129.99, '2026-07-29 14:40:00', '2026-07-29 14:40:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 3, 1, 129.99, '2026-07-29 14:40:00', '2026-07-29 14:40:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (4, 419.97, '2026-07-30 17:10:00', '2026-07-30 17:10:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 4, 3, 139.99, '2026-07-30 17:10:00', '2026-07-30 17:10:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (5, 139.98, '2026-07-31 19:25:00', '2026-07-31 19:25:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 5, 2, 69.99, '2026-07-31 19:25:00', '2026-07-31 19:25:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (1, 2000.00, '2026-08-01 08:05:00', '2026-08-01 08:05:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 1, 1, 2000.00, '2026-08-01 08:05:00', '2026-08-01 08:05:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (2, 1300.00, '2026-08-01 11:55:00', '2026-08-01 11:55:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 2, 2, 650.00, '2026-08-01 11:55:00', '2026-08-01 11:55:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (3, 389.97, '2026-08-02 14:30:00', '2026-08-02 14:30:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 3, 3, 129.99, '2026-08-02 14:30:00', '2026-08-02 14:30:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (4, 279.98, '2026-08-02 16:50:00', '2026-08-02 16:50:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 4, 2, 139.99, '2026-08-02 16:50:00', '2026-08-02 16:50:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (5, 349.95, '2026-08-02 20:15:00', '2026-08-02 20:15:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 5, 5, 69.99, '2026-08-02 20:15:00', '2026-08-02 20:15:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (1, 4000.00, '2026-08-03 09:30:00', '2026-08-03 09:30:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 1, 2, 2000.00, '2026-08-03 09:30:00', '2026-08-03 09:30:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (2, 650.00, '2026-08-04 10:45:00', '2026-08-04 10:45:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 2, 1, 650.00, '2026-08-04 10:45:00', '2026-08-04 10:45:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (3, 259.98, '2026-08-05 13:15:00', '2026-08-05 13:15:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 3, 2, 129.99, '2026-08-05 13:15:00', '2026-08-05 13:15:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (4, 139.99, '2026-08-06 15:40:00', '2026-08-06 15:40:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 4, 1, 139.99, '2026-08-06 15:40:00', '2026-08-06 15:40:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (5, 209.97, '2026-08-07 18:00:00', '2026-08-07 18:00:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 5, 3, 69.99, '2026-08-07 18:00:00', '2026-08-07 18:00:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (1, 2000.00, '2026-08-07 21:10:00', '2026-08-07 21:10:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 1, 1, 2000.00, '2026-08-07 21:10:00', '2026-08-07 21:10:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (2, 1300.00, '2026-08-08 08:20:00', '2026-08-08 08:20:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 2, 2, 650.00, '2026-08-08 08:20:00', '2026-08-08 08:20:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (3, 129.99, '2026-08-09 12:35:00', '2026-08-09 12:35:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 3, 1, 129.99, '2026-08-09 12:35:00', '2026-08-09 12:35:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (4, 279.98, '2026-08-09 16:45:00', '2026-08-09 16:45:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 4, 2, 139.99, '2026-08-09 16:45:00', '2026-08-09 16:45:00');

INSERT INTO sales (user_id, total, created_at, updated_at) VALUES (5, 279.96, '2026-08-09 20:55:00', '2026-08-09 20:55:00');
SET @sale_id = LAST_INSERT_ID();
INSERT INTO sale_details (sale_id, product_id, quantity, price, created_at, updated_at) VALUES (@sale_id, 5, 4, 69.99, '2026-08-09 20:55:00', '2026-08-09 20:55:00');

COMMIT;
