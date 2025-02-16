/* user: postgres database: hardware_stock */
CREATE DATABASE hardware_stock;
\c hardware_stock


CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    public_id CHAR(36) UNIQUE NOT NULL,
    password VARCHAR(50) NOT NULL,
    username VARCHAR(60) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);


CREATE TABLE brands (
	id SERIAL PRIMARY KEY,
	name VARCHAR (60),
	users_id INT NOT NULL,
	FOREIGN KEY (users_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE categories (
	id SERIAL PRIMARY KEY,
	name VARCHAR (60),
	users_id INT NOT NULL,
	FOREIGN KEY (users_id) REFERENCES users(id) ON DELETE CASCADE
);



CREATE TABLE hardwares (
	id SERIAL PRIMARY KEY,
	name VARCHAR(200) NOT NULL,
	price VARCHAR(15),
	users_id INT NOT NULL,
	FOREIGN KEY (users_id) REFERENCES users(id) ON DELETE CASCADE,
	brands_id INT,
	FOREIGN KEY (brands_id) REFERENCES brands(id) ,
	categories_id INT,
	FOREIGN KEY (categories_id) REFERENCES categories(id)
);

CREATE TABLE refresh_tokens (
    id SERIAL PRIMARY KEY,
    public_id CHAR(36) UNIQUE NOT NULL,
    token TEXT NOT NULL, 
    user_id INT NOT NULL, 
    expires_at TIMESTAMP NOT NULL,  
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE 
);
