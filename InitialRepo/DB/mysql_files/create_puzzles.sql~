CREATE TABLE puzzles
(
	puzzle_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	puzzle VARCHAR(100) NOT NULL,
	solution VARCHAR(100) NOT NULL,
	hint_one VARCHAR(100),
	hint_two VARCHAR(100),
	hint_three VARCHAR(100),
	award_points INT UNSIGNED,
	comment VARCHAR(100),
	# Date of entry
	doe DATE,
	is_used BOOLEAN NOT NULL,
	PRIMARY KEY (puzzle_id),
	UNIQUE KEY (puzzle)
) ENGINE = InnoDB;
