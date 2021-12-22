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