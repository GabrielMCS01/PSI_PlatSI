USE projectdb;

CREATE TABLE IF NOT EXISTS clientes(
		id INT UNSIGNED AUTO_INCREMENT,
		username VARCHAR(40) NOT NULL,
	CONSTRAINT pk_clientes_id PRIMARY KEY(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS cupoes(
		id INT UNSIGNED AUTO_INCREMENT,
		codigo VARCHAR(20) NOT NULL,
        codigo_verificacao int NOT NULL,
        user_id INT UNSIGNED NOT NULL,
	CONSTRAINT pk_cupoes_id PRIMARY KEY(id),
    CONSTRAINT fk_cupoes_clientesid FOREIGN KEY(user_id) REFERENCES clientes(id)
) ENGINE=InnoDB;

