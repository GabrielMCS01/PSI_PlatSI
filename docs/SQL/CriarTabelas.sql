USE projectdb;

CREATE TABLE IF NOT EXISTS user_info(
		id INT UNSIGNED AUTO_INCREMENT,
        primeiro_nome VARCHAR(30) NOT NULL,
        ultimo_nome VARCHAR(30) NOT NULL,
        data_nascimento DATE,
        user_id INT NOT NULL UNIQUE,
	CONSTRAINT pk_userinfo_id PRIMARY KEY(id),
    CONSTRAINT fk_userinfo_id FOREIGN KEY(user_id) REFERENCES user(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS ciclismo(
		id INT UNSIGNED AUTO_INCREMENT,
		nome_percurso VARCHAR(50),
        duracao TIME NOT NULL,
        distancia FLOAT NOT NULL,
        velocidade_media FLOAT NOT NULL,
        velocidade_maxima FLOAT NOT NULL,
        velocidade_grafico JSON,
        rota JSON,
        data_treino DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        user_id INT NOT NULL,
        CONSTRAINT pk_ciclismo_id PRIMARY KEY(id),
		CONSTRAINT fk_ciclismo_id FOREIGN KEY(user_id) REFERENCES user(id)
) ENGINE=InnoDB;

 /* VELOCIDADE GRAFICO, ROTA - Colocar NOT NULL no final */