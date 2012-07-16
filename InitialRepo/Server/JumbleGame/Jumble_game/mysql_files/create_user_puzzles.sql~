CREATE TABLE user_puzzles
(
	puzzle_id INT UNSIGNED NOT NULL,
	user_id INT UNSIGNED NOT NULL,
	friend_id INT UNSIGNED NOT NULL,
	maxTime INT UNSIGNED,
	isViewed bool,
	isAnswered bool,
	isPaused bool,
	expiryDate DATE,
	date_assigned DATE NOT NULL,
	date_answered DATE,
	FOREIGN KEY (user_id) REFERENCES users (user_id),
	FOREIGN KEY (puzzle_id) REFERENCES puzzles (puzzle_id),
	FOREIGN KEY (friend_id) REFERENCES users (user_id),
	PRIMARY KEY (puzzle_id),
	UNIQUE KEY (user_id, friend_id)
) ENGINE = InnoDB;

