CREATE TABLE puzzles_to_user
(
	puzzle_id INT UNSIGNED NOT NULL,
	user_id INT UNSIGNED NOT NULL,
	friend_id INT UNSIGNED NOT NULL,
	date_assigned DATE NOT NULL,
	FOREIGN KEY (user_id) REFERENCES users (user_id),
	FOREIGN KEY (puzzle_id) REFERENCES puzzles (puzzle_id),
	FOREIGN KEY (friend_id) REFERENCES users (user_id),
	PRIMARY KEY (puzzle_id),
	UNIQUE KEY (user_id, friend_id)
) ENGINE = InnoDB;

