INSERT INTO user (name, email, passhash) 
	VALUES ("user1", "user1@email.com", "pass1");

INSERT INTO user (name, email, passhash) 
	VALUES ("user2", "user2@email.com", "pass2");

INSERT INTO novel (title, author)
	VALUES ("A Novel", "John Smith");

INSERT INTO novel (title, author)
	VALUES ("A Second Novel", "John Smith");

INSERT INTO novel (title, author)
	VALUES ("A Completely Different Novel", "Toby Brand");

INSERT INTO novel (title, author)
	VALUES ("A Novella", "George McMann");

INSERT INTO user_novel (userid, novelid)
	VALUES (1, 1);

INSERT INTO user_novel (userid, novelid)
	VALUES (1, 2);

INSERT INTO user_novel (userid, novelid)
	VALUES (2, 3);

INSERT INTO chapter (numeral, title, time, setting, precis, synopsis, notes, color, novelid)
	VALUES(
		1,
		"Chapter One",
		"123 AD, a Wednesday",
		"A church beside a river",
		"Lorem ipsum dolor sit amet",
		"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec placerat leo. Praesent aliquet at magna a ultrices. Sed sed odio nisi. In faucibus rutrum felis, mattis tincidunt dui eleifend vitae. Nunc tincidunt diam elit, quis pellentesque magna semper eget. Sed id laoreet lorem. Phasellus iaculis ut sapien sit amet ultricies. Aliquam at mauris nec arcu porta tempor sit amet eu purus. Fusce tincidunt libero vitae risus dictum, a scelerisque neque eleifend. Suspendisse fringilla nulla at ligula tincidunt, at cursus tellus rhoncus. Maecenas faucibus, neque id tempor sagittis, erat dolor rutrum elit, pretium sodales lectus urna eu neque.",
		"",
		"#ff0000",
		1
	);

INSERT INTO chapter (numeral, title, time, setting, precis, synopsis, notes, color, novelid)
	VALUES(
		2,
		"Chapter Two",
		"124 AD, a Thursday",
		"A church beside a river",
		"Lorem ipsum dolor sit amet",
		"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec placerat leo. Praesent aliquet at magna a ultrices. Sed sed odio nisi. In faucibus rutrum felis, mattis tincidunt dui eleifend vitae. Nunc tincidunt diam elit, quis pellentesque magna semper eget. Sed id laoreet lorem. Phasellus iaculis ut sapien sit amet ultricies. Aliquam at mauris nec arcu porta tempor sit amet eu purus. Fusce tincidunt libero vitae risus dictum, a scelerisque neque eleifend. Suspendisse fringilla nulla at ligula tincidunt, at cursus tellus rhoncus. Maecenas faucibus, neque id tempor sagittis, erat dolor rutrum elit, pretium sodales lectus urna eu neque.",
		"",
		"#ff0000",
		1
	);

INSERT INTO chapter (numeral, title, time, setting, precis, synopsis, notes, color, novelid)
	VALUES(
		3,
		"Chapter Three",
		"125 AD, a Friday",
		"A church beside a river",
		"Lorem ipsum dolor sit amet",
		"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec placerat leo. Praesent aliquet at magna a ultrices. Sed sed odio nisi. In faucibus rutrum felis, mattis tincidunt dui eleifend vitae. Nunc tincidunt diam elit, quis pellentesque magna semper eget. Sed id laoreet lorem. Phasellus iaculis ut sapien sit amet ultricies. Aliquam at mauris nec arcu porta tempor sit amet eu purus. Fusce tincidunt libero vitae risus dictum, a scelerisque neque eleifend. Suspendisse fringilla nulla at ligula tincidunt, at cursus tellus rhoncus. Maecenas faucibus, neque id tempor sagittis, erat dolor rutrum elit, pretium sodales lectus urna eu neque.",
		"",
		"#ff0000",
		1
	);

INSERT INTO chapter (numeral, title, time, setting, precis, synopsis, notes, color, novelid)
	VALUES(
		1,
		"Chapter One",
		"123 BC, a Wednesday",
		"The innards of a dinosaur skeleton",
		"Lorem ipsum dolor sit amet",
		"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec placerat leo. Praesent aliquet at magna a ultrices. Sed sed odio nisi. In faucibus rutrum felis, mattis tincidunt dui eleifend vitae. Nunc tincidunt diam elit, quis pellentesque magna semper eget. Sed id laoreet lorem. Phasellus iaculis ut sapien sit amet ultricies. Aliquam at mauris nec arcu porta tempor sit amet eu purus. Fusce tincidunt libero vitae risus dictum, a scelerisque neque eleifend. Suspendisse fringilla nulla at ligula tincidunt, at cursus tellus rhoncus. Maecenas faucibus, neque id tempor sagittis, erat dolor rutrum elit, pretium sodales lectus urna eu neque.",
		"",
		"#00ff00",
		1
	);

INSERT INTO chapter (numeral, title, time, setting, precis, synopsis, notes, color, novelid)
	VALUES(
		2,
		"Chapter Two",
		"124 BC, a Thursday",
		"The innards of a dinosaur skeleton",
		"Lorem ipsum dolor sit amet",
		"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec placerat leo. Praesent aliquet at magna a ultrices. Sed sed odio nisi. In faucibus rutrum felis, mattis tincidunt dui eleifend vitae. Nunc tincidunt diam elit, quis pellentesque magna semper eget. Sed id laoreet lorem. Phasellus iaculis ut sapien sit amet ultricies. Aliquam at mauris nec arcu porta tempor sit amet eu purus. Fusce tincidunt libero vitae risus dictum, a scelerisque neque eleifend. Suspendisse fringilla nulla at ligula tincidunt, at cursus tellus rhoncus. Maecenas faucibus, neque id tempor sagittis, erat dolor rutrum elit, pretium sodales lectus urna eu neque.",
		"",
		"#00ff00",
		1
	);

INSERT INTO chapter (numeral, title, time, setting, precis, synopsis, notes, color, novelid)
	VALUES(
		3,
		"Chapter Three",
		"125 BC, a Friday",
		"The innards of a dinosaur skeleton",
		"Lorem ipsum dolor sit amet",
		"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec placerat leo. Praesent aliquet at magna a ultrices. Sed sed odio nisi. In faucibus rutrum felis, mattis tincidunt dui eleifend vitae. Nunc tincidunt diam elit, quis pellentesque magna semper eget. Sed id laoreet lorem. Phasellus iaculis ut sapien sit amet ultricies. Aliquam at mauris nec arcu porta tempor sit amet eu purus. Fusce tincidunt libero vitae risus dictum, a scelerisque neque eleifend. Suspendisse fringilla nulla at ligula tincidunt, at cursus tellus rhoncus. Maecenas faucibus, neque id tempor sagittis, erat dolor rutrum elit, pretium sodales lectus urna eu neque.",
		"",
		"#00ff00",
		2
	);



