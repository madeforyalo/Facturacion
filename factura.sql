CREATE DATABASE facturas;
USE facturas;

CREATE TABLE facturas (
    fac_id INT AUTO_INCREMENT PRIMARY KEY,
    fac_emision DATE NOT NULL,
    fac_monto DECIMAL(10, 2) NOT NULL,
    fac_vencimiento DATE NOT NULL
);

select * from facturas;

CREATE TABLE interes(
	int_id INT PRIMARY KEY AUTO_INCREMENT,
    int_1 INT(2),
    int_dia1 INT(5),
    int_2 INT(2),
    int_dia2 INT(5),
    int_3 INT(2),
    int_dia3 INT(5)
);