CREATE DATABASE pets_adocao;

USE pets_adocao;

CREATE TABLE animals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    species VARCHAR(50) NOT NULL,
    breed VARCHAR(50) NOT NULL,
    age INT NOT NULL,
    sex VARCHAR(10) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) NOT NULL,
    location VARCHAR(100) NOT NULL,
    contact_info VARCHAR(100) NOT NULL
);
