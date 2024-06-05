create database users_lv;

CREATE TABLE users (
	id int PRIMARY KEY AUTO_INCREMENT,
    name varchar (30) not null,
    surname varchar (30) not null,
    email varchar(255) UNIQUE not null,
    username varchar (255) UNIQUE not null,
    password varchar (255) not null
) Engine = 'InnoDB';


CREATE TABLE categories (
    id int PRIMARY KEY AUTO_INCREMENT,
    name varchar(30)
) Engine = 'InnoDB';


CREATE TABLE products (
    id int PRIMARY KEY AUTO_INCREMENT,
    name varchar(50),
    description text,
    img varchar(50),
    category int not null,
    price decimal (10, 2),
    FOREIGN KEY (category) references categories(id)
) Engine = 'InnoDB';

create TABLE cart (
    id int PRIMARY KEY AUTO_INCREMENT,
    client_id int,
    FOREIGN KEY(client_id) references users(id)
) Engine = 'InnoDB';

create TABLE cart_item (
    id int PRIMARY KEY AUTO_INCREMENT,
    product_id int not null,
    cart_id int not null,
    quantity int not null,
    FOREIGN KEY(product_id) references products(id),
    FOREIGN KEY(cart_id) references cart(id)
) Engine = 'InnoDB';