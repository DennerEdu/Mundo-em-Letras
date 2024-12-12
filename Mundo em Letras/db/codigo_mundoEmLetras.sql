CREATE DATABASE IF NOT EXISTS mundoEmLetras;

USE mundoEmLetras;

CREATE TABLE IF NOT EXISTS feedback(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(45) NOT NULL,
	email VARCHAR(255) NOT NULL,
    suggestion TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS `mundoEmLetras`.`catalogContent` (
  `isbn13` VARCHAR(13) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `tinySynopsis` TEXT NOT NULL,
  `synopsis` TEXT NOT NULL,
  `author` VARCHAR(45) NOT NULL,
  `publication` DATE NOT NULL,
  `publisher` VARCHAR(45) NOT NULL,
  `pageNumbers` INT NULL,
  `indicativeRating` INT NOT NULL,
  `price` FLOAT NOT NULL,
  `smallThumbnail` TEXT NOT NULL,
  `bookCover` TEXT NULL NULL,
  PRIMARY KEY (`isbn13`))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `mundoEmLetras`.`genres` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `genre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mundoEmLetras`.`cc_genres`
-- -----------------------------------------------------
create table cc_genres (
cc_isbn13 varchar(13),
genres_id INT,
PRIMARY KEY (cc_isbn13, genres_id),
FOREIGN KEY (cc_isbn13) REFERENCES catalogContent(isbn13),
FOREIGN KEY (genres_id) REFERENCES genres(id)
);

-- Criando a tabela de usuários
CREATE TABLE users (
    uid INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(45) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullName VARCHAR(100),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- drop table wishlist;
-- drop table readLater;
-- drop table reading;
-- drop table completed;
-- drop table favorite;
-- drop table rating;
-- drop table comments;

-- Criando as tabelas de relações entre usuários e livros
CREATE TABLE wishlist (
	users_uid INT NOT NULL,
    cc_isbn13 VARCHAR(13) NOT NULL,
    PRIMARY KEY (users_uid, cc_isbn13),
    FOREIGN KEY (users_uid) REFERENCES users(uid),
    FOREIGN KEY (cc_isbn13) REFERENCES catalogContent(isbn13)
);

CREATE TABLE readLater (
	users_uid INT NOT NULL,
    cc_isbn13 VARCHAR(13) NOT NULL,
    PRIMARY KEY (users_uid, cc_isbn13),
    FOREIGN KEY (users_uid) REFERENCES users(uid),
    FOREIGN KEY (cc_isbn13) REFERENCES catalogContent(isbn13)
);

CREATE TABLE reading (
	users_uid INT NOT NULL,
    cc_isbn13 VARCHAR(13) NOT NULL,
    PRIMARY KEY (users_uid, cc_isbn13),
    FOREIGN KEY (users_uid) REFERENCES users(uid),
    FOREIGN KEY (cc_isbn13) REFERENCES catalogContent(isbn13)
);

CREATE TABLE completed (
	users_uid INT NOT NULL,
    cc_isbn13 VARCHAR(13) NOT NULL,
    PRIMARY KEY (users_uid, cc_isbn13),
    FOREIGN KEY (users_uid) REFERENCES users(uid),
    FOREIGN KEY (cc_isbn13) REFERENCES catalogContent(isbn13)
);

CREATE TABLE favorite (
	users_uid INT NOT NULL,
    cc_isbn13 VARCHAR(13) NOT NULL,
    PRIMARY KEY (users_uid, cc_isbn13),
    FOREIGN KEY (users_uid) REFERENCES users(uid),
    FOREIGN KEY (cc_isbn13) REFERENCES catalogContent(isbn13)
);

CREATE TABLE ratings (
	users_uid INT NOT NULL,
    cc_isbn13 VARCHAR(13) NOT NULL,
    rating INT NOT NULL,
    PRIMARY KEY (users_uid, cc_isbn13),
    FOREIGN KEY (users_uid) REFERENCES users(uid),
    FOREIGN KEY (cc_isbn13) REFERENCES catalogContent(isbn13)
);

CREATE TABLE comments (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    users_uid INT NOT NULL,
    cc_isbn13 VARCHAR(13) NOT NULL,
    comment VARCHAR(255) NOT NULL,
    FOREIGN KEY (users_uid) REFERENCES users(uid),
    FOREIGN KEY (cc_isbn13) REFERENCES catalogContent(isbn13)
);

-- DROP TABLE comments;

INSERT INTO comments VALUES
(2, '9781781103685', "Adorei o livro!"),
(3, '9781781103685', "Achei o livro bem mediano");


INSERT INTO catalogContent (
    isbn13, 
    name, 
    tinySynopsis, 
    synopsis, 
    author, 
    publication, 
    publisher, 
    pageNumbers, 
    indicativeRating, 
    price, 
    smallThumbnail, 
    bookCover
)
VALUES (
    '9789895559411',  -- isbn13
    'Alice no País das Maravilhas',  -- name
    'Quem não se lembra do Coelho Branco, do Gato de Cheshire, da Lebre de Março, do Chapeleiro Maluco, da Rainha de Copas... e da incontornável Alice...? As personagens que Lewis Carroll imortalizou num clássico único para todas as idades. Viaje pelo mundo da imaginação e do nonsense onde tudo é possível!',  -- tinySynopsis
    'Quem não se lembra do Coelho Branco, do Gato de Cheshire, da Lebre de Março, do Chapeleiro Maluco, da Rainha de Copas... e da incontornável Alice...? As personagens que Lewis Carroll imortalizou num clássico único para todas as idades. Viaje pelo mundo da imaginação e do nonsense onde tudo é possível!',  -- synopsis
    'Lewis Carrol',  -- author
    '2011-11-01',  -- publication (formato DATE)
    'Leya',  -- publisher
    124,  -- pageNumbers
    4,  -- indicativeRating (usando arredondado)
    83.05,  -- price
    'http://books.google.com/books/content?id=mssBsa0Vf1UC&printsec=frontcover&img=1&zoom=2&edge=curl&imgtk=AFLRE72wQPezrf-41C9Cg-DsexTqhhxBs9jVsJWV9OX_5ktpIGVEom-kJCTiDRG0T5znfCXcTGSWzk3HN9baOzx7qIxa7g5YTPyQobVMZScDF-Q8PpOnAUE6lFkUTKtpamIQ4NchqEdn&source=gbs_api',  -- smallThumbnail
    'http://books.google.com/books/content?id=mssBsa0Vf1UC&printsec=frontcover&img=1&zoom=2&edge=curl&imgtk=AFLRE72wQPezrf-41C9Cg-DsexTqhhxBs9jVsJWV9OX_5ktpIGVEom-kJCTiDRG0T5znfCXcTGSWzk3HN9baOzx7qIxa7g5YTPyQobVMZScDF-Q8PpOnAUE6lFkUTKtpamIQ4NchqEdn&source=gbs_api'  -- bookCover
);

select * from catalogContent;

-- Inserir gêneros na tabela `genres`
INSERT INTO `mundoEmLetras`.`genres` (`genre`) 
VALUES 
('Filosófico'),
('Ficção Científica'),
('Romance'),
('Fantasia'),
('Aventura'),
('Mistério'),
('Drama');

-- Relacionar livros aos seus gêneros
INSERT INTO `mundoEmLetras`.`cc_genres` (`cc_isbn13`, `genres_id`)
VALUES 
('9781465568298', 1),  -- Novo dicionário da língua portuguesa -> Filosófico
('9781781103685', 4),  -- Harry Potter e a Pedra Filosofal -> Fantasia
('9781781103692', 4),  -- Harry Potter e a Câmara Secreta -> Fantasia
('9781781104040', 4),  -- Harry Potter e a Ordem da Fênix -> Fantasia
('9781781104057', 4),  -- Harry Potter e o enigma do Príncipe -> Fantasia
('9781781105337', 4),  -- Harry Potter e a Criança Amaldiçoada -> Fantasia
('9786587042015', 7),  -- Você morre quando esquecem seu nome -> Drama
('9788539004256', 1),  -- O poder do hábito -> Filosófico
('9788543804880', 5),  -- O dia do curinga -> Mistério
('9788543808246', 1),  -- Mindset -> Filosófico
('9788576572374', 2),  -- Duna -> Ficção Científica
('9788580864434', 3),  -- A Seleção -> Romance
('9788580866940', 3),  -- A Elite -> Romance
('9788580869910', 3),  -- A escolha -> Romance
('9788581053059', 5),  -- O Vilarejo -> Mistério
('9788581227177', 7),  -- O conto da aia -> Drama
('9788592886141', 6),  -- Odisseia -> Aventura
('9788595086326', 4),  -- O Senhor dos Anéis: As duas torres -> Fantasia
('9788595086333', 4),  -- O Senhor dos Anéis: A Sociedade do Anel -> Fantasia
('9788599662809', 1),  -- Tempo presente -> Filosófico
('9789892320953', 3),  -- A Culpa é das Estrelas -> Romance
('9789896659882', 1);  -- Sobre o autoritarismo brasileiro -> Filosófico















select * from users;



insert into favorite values 
(1, '9781781103692'),
(1, '9781781104040'),
(1, '9781781104057'),
(1, '9781781105337'),
(1, '9786587042015'),
(1, '9788539004256'),
(1, '9788543804880'),
(1, '9788543808246'),
(1, '9788576572374');

select * from feedback;
select * from catalogContent;