USE projectdb;

INSERT INTO `user` (`id`,`username`,`auth_key`,`password_hash`,`password_reset_token`,`email`,`status`,`created_at`,`updated_at`,`verification_token`) VALUES (1,'admin','kRs5VPhVgDbGSXz4cmFmq7iG-pSlDznv','$2y$13$Y3yAXe808CR3K1oKLzqOwOznVbZqyxBYSD3gfzVda3YSCdlS.65bO',NULL,'admin@admin.pt',10,1636374808,1636374808,NULL);
INSERT INTO `auth_assignment` (`item_name`,`user_id`,`created_at`) VALUES ('admin','1',1636374808);