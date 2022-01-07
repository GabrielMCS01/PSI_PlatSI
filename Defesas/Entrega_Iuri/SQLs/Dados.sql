USE projectdb;

INSERT INTO `user` (`id`,`username`,`auth_key`,`password_hash`,`password_reset_token`,`email`,`status`,`created_at`,`updated_at`,`verification_token`) VALUES (1,'admin','kRs5VPhVgDbGSXz4cmFmq7iG-pSlDznv','$2y$13$Y3yAXe808CR3K1oKLzqOwOznVbZqyxBYSD3gfzVda3YSCdlS.65bO',NULL,'admin@admin.pt',10,1636374808,1636374808,NULL);
INSERT INTO `auth_assignment` (`item_name`,`user_id`,`created_at`) VALUES ('admin','1',1636374808);
INSERT INTO `user_info` (`primeiro_nome`, `ultimo_nome`, `user_id`) VALUES ('Administrador', 'Padrão', '1');

INSERT INTO `user` (`id`,`username`,`auth_key`,`password_hash`,`password_reset_token`,`email`,`status`,`created_at`,`updated_at`,`verification_token`) VALUES (2,'test','A9tHuhhESlLO6vissncxak0bWWNyOJnL','$2y$13$y3LwtLXEKJlgyT.00ay.reI0u6Lr7X63qt8o4jCX4LL4Y3OhRMc0y',NULL,'test@gmail.com',10,1640172013,1640172013,NULL);
INSERT INTO `auth_assignment` (`item_name`,`user_id`,`created_at`) VALUES ('user','2',1640172013);
INSERT INTO `user_info` (`primeiro_nome`, `ultimo_nome`, `user_id`) VALUES ('Gabriel','Iuri','2');

INSERT INTO `user` (`id`,`username`,`auth_key`,`password_hash`,`password_reset_token`,`email`,`status`,`created_at`,`updated_at`,`verification_token`) VALUES (3,'moderador','rH2H6lvcOmxEidKvBrJ4XsTyKXc_Qsvi','$2y$13$N2.2hz1DRd6gty8Kl15.Ku6V4q9hCYvRQHKjzlLpLNM8us144V8DG',NULL,'moderador@moderador.com',10,1640176079,1640176079,NULL);
INSERT INTO `auth_assignment` (`item_name`,`user_id`,`created_at`) VALUES ('moderador','3',1640176079);
INSERT INTO `user_info` (`primeiro_nome`, `ultimo_nome`, `user_id`) VALUES ('moderador','mod',3);

INSERT INTO `user` (`id`,`username`,`auth_key`,`password_hash`,`password_reset_token`,`email`,`status`,`created_at`,`updated_at`,`verification_token`) VALUES (4,'gabriel','wpvSoVPduEh99HYs95yZo_0P6tETHEPB','$2y$13$BIDG55tJzV7DTm9CT.A1g.1QyLZe1eFNYXsc38uOkwvzhKm/sWEl6',NULL,'gabriel@mail.pt',10,1640259753,1640259753,NULL);
INSERT INTO `auth_assignment` (`item_name`,`user_id`,`created_at`) VALUES ('user','4',1640259753);
INSERT INTO `user_info` (`primeiro_nome`, `ultimo_nome`, `user_id`) VALUES ('Gabriel','Silva',4);

INSERT INTO `user` (`id`,`username`,`auth_key`,`password_hash`,`password_reset_token`,`email`,`status`,`created_at`,`updated_at`,`verification_token`) VALUES (5,'iuri','IL4wPHi0LMCGPs5Jc3dzt7xRQjSOKbKG','$2y$13$.YVWTEbgp/zmVVgHrNIqxuLnhGnqd69emltAcizIpBTRQBFGrFT6.',NULL,'iuri@mail.pt',10,1640259816,1640259816,NULL);
INSERT INTO `auth_assignment` (`item_name`,`user_id`,`created_at`) VALUES ('user','5',1640259816);
INSERT INTO `user_info` (`primeiro_nome`, `ultimo_nome`, `user_id`) VALUES ('Iuri','Carrasqueiro',5);

INSERT INTO ciclismo (id,nome_percurso,duracao,distancia,velocidade_media,velocidade_maxima,data_treino,user_id) VALUES (1,'Percurso de teste',500,900,10.1,20.4,'2021-12-22 18:30:41',2);
INSERT INTO ciclismo (id,nome_percurso,duracao,distancia,velocidade_media,velocidade_maxima,data_treino,user_id) VALUES (2,'Percurso de Foz a torres',4379,17421,14.0958,30.537,'2021-12-12 12:24:38',2);
INSERT INTO ciclismo (id,nome_percurso,duracao,distancia,velocidade_media,velocidade_maxima,data_treino,user_id) VALUES (3,'Percurso volta',41091,7056,9.5,16.2,'2021-12-24 08:12:42',4);
INSERT INTO ciclismo (id,nome_percurso,duracao,distancia,velocidade_media,velocidade_maxima,data_treino,user_id) VALUES (4,'Percurso Torres Vedras',6012,900,10.1,20.4,'2021-12-21 14:30:01',5);
INSERT INTO ciclismo (id,nome_percurso,duracao,distancia,velocidade_media,velocidade_maxima,velocidade_grafico,rota,data_treino,user_id) VALUES (5, 'Percurso com rota e gráfico', 71, 428, 21.8457, 40.0372, '[21.224417,19.757765,15.235029,11.556545,8.203097,3.8844025,0.0,0.0,0.0,2.7374182,7.48249,14.15195,19.520958,21.268908,19.230097,19.802483,22.474035,26.775343,29.813385,31.493929,32.00445,32.39885,33.265575,34.87531,36.360416,36.559517,38.62568,39.213074,39.9193,40.037235,39.63434,37.6049,36.59412,34.742126,32.638348,30.24443,29.117117,29.066805,28.794052,27.77208,26.385626,24.503798,22.173983,21.322756,17.119686,14.727396,14.368434,14.782849,16.80632,19.02666,22.143686,24.053917,24.779722,20.985506,19.446732,16.876976,14.63836,12.962649,12.847327,12.199803,8.113976,3.779025,4.2293496,7.09468,11.209326,17.265697,21.970772,24.13636,26.846165,32.202667,37.965317]', 'gaiqiAluwsPfe@yB`DG|AEhGMz@ArCGzBObBOjAKv@IZIFCjCuA[rC????????Ln@Xn@jCn@|AeBj@_B~@eBlA}BrAiC|A{CzAcD|A}ClBcDvB{ChCcDnCgDpCoCjDaCjDaCnDcClDcCfD_CfD}B`DyBtCqBfCgB~BaBzB}A~B_B`CcBbBcAnBe@tBi@lB]zAShAMbAAdA?hAAdB\\bBt@rB|@dBhA~AbAvAdAfA~@bAz@p@r@h@l@f@l@Vb@LRFHFJ`@hAp@xBwAzDu@rBy@`CeA~CkApDwApE', '2021-12-27 15:47:35', 5);

INSERT INTO publicacao (id,createtime,ciclismo_id) VALUES (1,'2021-12-22 19:10:30',1);
INSERT INTO publicacao (id,createtime,ciclismo_id) VALUES (2,'2021-12-25 01:27:09',3);

INSERT INTO comentario (id,content,createtime,publicacao_id,user_id) VALUES (1,'comentário de teste','2021-12-22 20:13:10',1,4);
INSERT INTO comentario (id,content,createtime,publicacao_id,user_id) VALUES (2,'comentário','2021-12-23 12:15:00',1,5);
INSERT INTO comentario (id,content,createtime,publicacao_id,user_id) VALUES (3,'comentário do moderador','2021-12-22 17:15:00',1,3);
INSERT INTO comentario (id,content,createtime,publicacao_id,user_id) VALUES (4,'Bom Treino!','2021-12-26 23:11:51',2,3);

INSERT INTO gosto (id,publicacao_id,user_id) VALUES (1,1,2);
INSERT INTO gosto (id,publicacao_id,user_id) VALUES (2,1,3);
INSERT INTO gosto (id,publicacao_id,user_id) VALUES (3,1,4);
INSERT INTO gosto (id,publicacao_id,user_id) VALUES (4,2,2);