CREATE TABLE friends
(
	user_id INT UNSIGNED NOT NULL,
	friend_id INT UNSIGNED NOT NULL,
	isConfirmed boolean,
	isIgnored boolean,
	FOREIGN KEY (user_id) REFERENCES users (user_id),
	FOREIGN KEY (friend_id) REFERENCES users (user_id),
	PRIMARY KEY (user_id, friend_id),
	UNIQUE KEY (friend_id, user_id)
) ENGINE = InnoDB;

