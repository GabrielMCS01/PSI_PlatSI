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
        duracao INT NOT NULL,
        distancia INT NOT NULL,
        velocidade_media FLOAT NOT NULL,
        velocidade_maxima FLOAT NOT NULL,
        velocidade_grafico JSON,
        rota MEDIUMTEXT,
        data_treino DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        user_id INT NOT NULL,
        CONSTRAINT pk_ciclismo_id PRIMARY KEY(id),
		CONSTRAINT fk_ciclismo_id FOREIGN KEY(user_id) REFERENCES user(id)
) ENGINE=InnoDB;

CREATE TABLE `publicacao` (
  `id` int primary key auto_increment,
  `createtime` datetime default current_timestamp,
  `ciclismo_id` int unsigned not null UNIQUE,
  constraint fk_publi_idciclismo foreign key(ciclismo_id) references ciclismo(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `gosto` (
  `id` int primary key auto_increment,
  `publicacao_id` int not null,
  `user_id` int not null,
  constraint fk_gosto_idpubli foreign key(publicacao_id) references publicacao(id),
  constraint fk_gosto_iduser  foreign key(user_id) references user(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `comentario` (
  `id` int primary key auto_increment,
  `content` text NOT NULL,
  `createtime` datetime default current_timestamp,
  `publicacao_id` int not null,
  `user_id` int not null,
  CONSTRAINT fk_come_idpost FOREIGN KEY(publicacao_id) REFERENCES publicacao(id),
  constraint fk_come_iduser foreign key(user_id)	references user(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

 /* VELOCIDADE GRAFICO, ROTA - Colocar NOT NULL no final */