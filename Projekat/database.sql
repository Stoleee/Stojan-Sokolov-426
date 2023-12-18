CREATE DATABASE IF NOT EXISTS cinema;
USE cinema;

CREATE TABLE IF NOT EXISTS `user` (
		`id` INT NOT NULL AUTO_INCREMENT,
		`email` VARCHAR(55) NOT NULL UNIQUE,
		`password` VARCHAR(50) NOT NULL,
		`type` 	ENUM("admin", "manager","customer"),
		PRIMARY KEY(id)	
) ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS `admin` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(65) NOT NULL,
	`surname` VARCHAR(65) NOT NULL,
	user_id INT,
	PRIMARY KEY(id),
	CONSTRAINT `fk_user_admin`
	FOREIGN KEY(`user_id`) REFERENCES `user` (id)
	ON DELETE SET NULL
	ON UPDATE CASCADE
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `manager` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(65) NOT NULL,
	`surname` VARCHAR(65) NOT NULL,
	user_id INT,
	PRIMARY KEY(id),
	CONSTRAINT `fk_user_manager`
	FOREIGN KEY(`user_id`) REFERENCES `user` (id)
	ON DELETE SET NULL
	ON UPDATE CASCADE
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `customer` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(65) NOT NULL,
	`surname` VARCHAR(65) NOT NULL,
	user_id INT,
	PRIMARY KEY(id),
	CONSTRAINT `fk_user_customer`
	FOREIGN KEY(`user_id`) REFERENCES `user` (id)
	ON DELETE SET NULL
	ON UPDATE CASCADE
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `movies` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(75) NOT NULL,
	`picture` VARCHAR(200) NOT NULL,
	`duration` VARCHAR(15) NOT NULL,
	`genre` VARCHAR(50) NOT NULL,
	`date` DATE NOT NULL,
	`price`  INT NOT NULL,
	`content` VARCHAR(2000) NOT NULL,
	`max_tickets` INT NOT NULL,
	PRIMARY KEY(id)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `reserved tickets`(
	`id` INT NOT NULL AUTO_INCREMENT,
	`movie_id` INT NOT NULL,
	`customer_id` INT NOT NULL,
	 PRIMARY KEY (`id`),
	CONSTRAINT `fk_customer_reserved_ticket_id`
	FOREIGN KEY (customer_id) REFERENCES `customer` (id)
	ON DELETE RESTRICT
	ON UPDATE CASCADE,
	CONSTRAINT `fk_reserved_tickets_id`
	FOREIGN KEY (movie_id) REFERENCES `movies` (id)
	ON DELETE RESTRICT
	ON UPDATE CASCADE
)ENGINE=InnoDB;



CREATE TABLE IF NOT EXISTS `comment` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `comment` TEXT(750) NOT NULL,
  `customer_id` INT NOT NULL,
  `movie_id` INT, 
  `created` DATE NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_comment_customer1`
    FOREIGN KEY (`customer_id`)
    REFERENCES `customer` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
	CONSTRAINT `fk_comment_movie1`
    FOREIGN KEY (`movie_id`)
    REFERENCES `movies` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)ENGINE = InnoDB;



INSERT INTO `user`( `email`, `password`, `type`) VALUES 
('customer@gmail.com','12345','customer'),
('manager@gmail.com','12345','manager'),
('admin@gmail.com','12345','admin');

INSERT INTO `customer`( `name`, `surname`, `user_id`) VALUES 
('Petar','Petrovic','1');

INSERT INTO `manager`(`name`, `surname`, `user_id`) VALUES 
('Nikola','Nikolic','2');

INSERT INTO `admin`( `name`, `surname`, `user_id`) VALUES 
('Stojan','Sokolov','3');


INSERT INTO `movies`(`title`,`picture`,`duration`,`genre`,`date`,`price`,`content`,`max_tickets`) VALUES
("Donnie Brasco", "donnie.png","126 min","action","2023-11-10",500,"An FBI undercover agent infiltrates the
mob and finds himself identifying more with the mafia life, at the expense of his regular one.",50),
("Bourne Ultimatum","born.png","93 min","action","2023-11-11",450,"Jason Bourne dodges a ruthless C.I.A. 
official and his Agents from a new assassination program while searching for the origins of his life as a trained killer.",45),
 ("Spiderman","Spiderman.png","121 min","fantasy","2023-11-12",400,"In SPIDER-MAN, Toby Maguire stars as Peter Parker, 
 a brilliant and sensitive high school student who's so deeply in love with his next-door neighbor Mary Jane (Kirsten Dunst)
  that he can barely bring himself to say hello to her. On a school field trip, he's bitten by a genetically engineered spider; 
  the next morning he wakes up with some distinctly arachnid-like qualities.",40),
 ("Undisputed 3","boyka.png","119 min","action","2023-11-13",350,"Sequel to the 2002 film. This time,
 Heavyweight Champ George Iceman Chambers is sent to a Russian Jail on trumped-up drug charges",50),
 ("The Lord of the Rings","lord.png","205 min","fantasy","2023-11-14",600,"A meek Hobbit from the Shire and eight
 companions set out on a journey to destroy the powerful One Ring and save Middle-earth from the Dark Lord Sauron.",55),
 ("The Conjuring","conjuring.png","131 min","horror","2023-11-14",600,"Paranormal investigators Ed and Lorraine 
 Warren work to help a family terrorized by a dark presence in their farmhouse.",35);
 
 
INSERT INTO `comment`( `comment`, `customer_id`,`movie_id`, `created`) VALUES 
('Great movie!!!','1','1','2022-10-11'), 
('Best movie ever!!!','1','2','2022-10-11'),
('I LOVE ITTT!!!','1','3','2022-10-11');

INSERT INTO `reserved tickets`(`movie_id`,`customer_id`) VALUES 
('1','1');










 






