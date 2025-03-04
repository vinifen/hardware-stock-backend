/* user: postgres database: hardware_stock */
CREATE DATABASE hardware_stock;
\c hardware_stock

CREATE TABLE users (
	id UUID NOT NULL PRIMARY KEY,
	serial_id SERIAL NOT NULL UNIQUE,
	password VARCHAR(64) NOT NULL,
	username VARCHAR(64) UNIQUE NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE TABLE brands (
	id SERIAL PRIMARY KEY,
	name VARCHAR(60),
	user_id UUID NOT NULL,
	FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE categories (
	id SERIAL PRIMARY KEY,
	name VARCHAR(60),
	user_id UUID NOT NULL,
	FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE hardwares (
	id SERIAL PRIMARY KEY,
	name VARCHAR(200) NOT NULL,
	price DECIMAL(10, 3),  
	user_id UUID NOT NULL,
	FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
	brand_id INT,
	FOREIGN KEY (brand_id) REFERENCES brands(id),
	category_id INT,
	FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE refresh_tokens (
	id UUID NOT NULL PRIMARY KEY,
	token TEXT NOT NULL, 
	user_id UUID NOT NULL, 
	expires_at TIMESTAMP NOT NULL,  
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE 
);


