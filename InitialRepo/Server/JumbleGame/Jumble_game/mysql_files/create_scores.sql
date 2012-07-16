CREATE TABLE scores
(
	user_id INT UNSIGNED NOT NULL,
	score  INT UNSIGNED NOT NULL,
	FOREIGN KEY (user_id) REFERENCES users (user_id),
	PRIMARY KEY (user_id)
) ENGINE = InnoDB;
