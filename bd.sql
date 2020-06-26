DROP TABLE comments;
DROP TABLE events;
DROP TABLE banned_words;
DROP TABLE users;
DROP TABLE roles;

CREATE OR REPLACE TABLE events 
(
    idEvent int(8) PRIMARY KEY AUTO_INCREMENT,
    title varchar(200) NOT NULL,
    eventDate date NOT NULL,
    image varchar(200) NOT NULL,
    organizer varchar(20),
    organizerLink varchar(200),
    description varchar(8000),
    is_published bit DEFAULT 0
);

INSERT INTO `events` (`title`, `eventDate`, `image`, `organizer`, `organizerLink`, `description`, `is_published`) VALUES 
('preaniversario1', '2020-01-15', 'img/eventos/preaniversario1/evento.jpg', 'Kakao Game', 'https://www.kakaogamescorp.com/', '<h4>¡LLega la superfiebre!</h4><p> Disfruta de bonificadores a la Exp. durante 3 semanas en todos los servidores. ¡Donde quieras y cuando quieras! ¡De cabeza a la aventura! </p> <p> Los bonificadores tendrán efecto continuado desde el 26 de febrero a las 9:00 (UTC) hasta el 18 de marzo a las 9:00 (UTC). </p> <p> Dichos bonificadores de Exp. se acumularán con otros efectos bonificadores como los de [Pergamino de la usura], [Pergamino bendito (100 min)], [Macuto con útiles], habilidades de mercenario, elixires y el servidor Arsha. Eso sí, los bonificadores de este evento sustituirán a los de «¡Llega la fiebre!» y a los de los servidores de Olvia. </p> <p> La bonificación a la Exp. (Combate) del evento no se aplicará a personajes por debajo del nivel 50, pero sí se aplicarán los bonificadores de Exp. (Habilidades), Exp. (Profesiones) y Obtención de objetos. </p> <p> La Exp. ganada en misiones no se verá afectada por los bonificadores anteriores. </p> <h4>Rebelión de los jefes errantes.</h4> <p> Aparición adicional de Vell. </p> <p> Obtén [Evento - Anillo brillante]. </p> <p> Podrás intercambiar [Evento - Anillo brillante] por [Pertenencias de un aventurero] con Marcella en Velia. </p> <h4>Las cuatro peticiones de Lara.</h4> <p> ¡Lara de Heidel quiere pedirte cuatro cosas! ¡Cumple las peticiones de Lara para obtener suculentas recompensas! </p> <p> Para ver más información sobre el evento: <a href="https://www.blackdesertonline.com/news/view/3653">Celebración del preaniversario</a> </p>','1'),
('preaniversario2', '2020-02-10', 'img/eventos/preaniversario2/evento.jpg', 'Kakao Game', 'https://www.kakaogamescorp.com/', '<h4>¡LLega la superfiebre!</h4><p> Disfruta de bonificadores a la Exp. durante 3 semanas en todos los servidores. ¡Donde quieras y cuando quieras! ¡De cabeza a la aventura! </p> <p> Los bonificadores tendrán efecto continuado desde el 26 de febrero a las 9:00 (UTC) hasta el 18 de marzo a las 9:00 (UTC). </p> <p> Dichos bonificadores de Exp. se acumularán con otros efectos bonificadores como los de [Pergamino de la usura], [Pergamino bendito (100 min)], [Macuto con útiles], habilidades de mercenario, elixires y el servidor Arsha. Eso sí, los bonificadores de este evento sustituirán a los de «¡Llega la fiebre!» y a los de los servidores de Olvia. </p> <p> La bonificación a la Exp. (Combate) del evento no se aplicará a personajes por debajo del nivel 50, pero sí se aplicarán los bonificadores de Exp. (Habilidades), Exp. (Profesiones) y Obtención de objetos. </p> <p> La Exp. ganada en misiones no se verá afectada por los bonificadores anteriores. </p> <h4>Rebelión de los jefes errantes.</h4> <p> Aparición adicional de Vell. </p> <p> Obtén [Evento - Anillo brillante]. </p> <p> Podrás intercambiar [Evento - Anillo brillante] por [Pertenencias de un aventurero] con Marcella en Velia. </p> <h4>Las cuatro peticiones de Lara.</h4> <p> ¡Lara de Heidel quiere pedirte cuatro cosas! ¡Cumple las peticiones de Lara para obtener suculentas recompensas! </p> <p> Para ver más información sobre el evento: <a href="https://www.blackdesertonline.com/news/view/3653">Celebración del preaniversario</a> </p>','1'),
('preaniversario3', '2020-03-03', 'img/eventos/preaniversario3/evento.jpg', 'Kakao Game', 'https://www.kakaogamescorp.com/', '<h4>¡LLega la superfiebre!</h4><p> Disfruta de bonificadores a la Exp. durante 3 semanas en todos los servidores. ¡Donde quieras y cuando quieras! ¡De cabeza a la aventura! </p> <p> Los bonificadores tendrán efecto continuado desde el 26 de febrero a las 9:00 (UTC) hasta el 18 de marzo a las 9:00 (UTC). </p> <p> Dichos bonificadores de Exp. se acumularán con otros efectos bonificadores como los de [Pergamino de la usura], [Pergamino bendito (100 min)], [Macuto con útiles], habilidades de mercenario, elixires y el servidor Arsha. Eso sí, los bonificadores de este evento sustituirán a los de «¡Llega la fiebre!» y a los de los servidores de Olvia. </p> <p> La bonificación a la Exp. (Combate) del evento no se aplicará a personajes por debajo del nivel 50, pero sí se aplicarán los bonificadores de Exp. (Habilidades), Exp. (Profesiones) y Obtención de objetos. </p> <p> La Exp. ganada en misiones no se verá afectada por los bonificadores anteriores. </p> <h4>Rebelión de los jefes errantes.</h4> <p> Aparición adicional de Vell. </p> <p> Obtén [Evento - Anillo brillante]. </p> <p> Podrás intercambiar [Evento - Anillo brillante] por [Pertenencias de un aventurero] con Marcella en Velia. </p> <h4>Las cuatro peticiones de Lara.</h4> <p> ¡Lara de Heidel quiere pedirte cuatro cosas! ¡Cumple las peticiones de Lara para obtener suculentas recompensas! </p> <p> Para ver más información sobre el evento: <a href="https://www.blackdesertonline.com/news/view/3653">Celebración del preaniversario</a> </p>','1');

CREATE OR REPLACE TABLE tags
(
    tagName varchar(30) NOT NULL,
    idEvent int(8) NOT NULL,
    PRIMARY KEY (tagName, idEvent)
);

INSERT INTO `tags` (`tagName`, `idEvent`) VALUES
('evento1', '1'),
('preaniversario', '1'),
('evento2', '2'),
('preaniversario', '2'),
('evento3', '3'),
('preaniversario', '3');

CREATE OR REPLACE TABLE roles
(
    role varchar(15) PRIMARY KEY NOT NULL
);

INSERT INTO `roles` (`role`) VALUES
('anon'),
('register'),
('moderator'),
('gestor'),
('super');

CREATE OR REPLACE TABLE users
(
    userName varchar(10) NOT NULL,
    email varchar(30) PRIMARY KEY NOT NULL,
    password varchar(100) NOT NULL,
    role varchar(15) NOT NULL,
    FOREIGN KEY(role) REFERENCES roles(role)
);

INSERT INTO `users` (`userName`, `email`, `password`, `role`) VALUES
('super', 'super@gmail.com', '$2y$10$pvdKr61BurzgVnF37Xi5T.TgtCQNJ6PDzVtpmaPb1Ow1z84cPX7Tm', 'super'),
('moderator', 'moderator@gmail.com', '$2y$10$58TgifkTG1ovrNj3/R8mROkYPjhSoaueI59Rj/Rd4rtR26hxnpD2i', 'moderator'),
('gestor', 'gestor@gmail.com', '$2y$10$B00lp.qPU14aNeJobfv/auEx5RtE75JuIZKJFOmyH/PkKreyxTCEO', 'gestor'),
('register', 'register@gmail.com', '$2y$10$fipNIq00GGtx5z0yPCDsJuSnZj5xh8DTl.Npe2UhZ2NQj0EX/Gpvu', 'register');


CREATE OR REPLACE TABLE comments
(
    idComment int(8) NOT NULL AUTO_INCREMENT,
    idEvent int(8) NOT NULL,
    commentDate date NOT NULL,
    commentTime time NOT NULL,
    email varchar(30) NOT NULL,
    comment varchar(200) NOT NULL,
    is_edited bit DEFAULT 0,
    FOREIGN KEY(idEvent) REFERENCES events(idEvent),
    FOREIGN KEY(email) REFERENCES users(email),
    PRIMARY KEY(idComment, idEvent)
);

INSERT INTO `comments` (`idEvent`, `commentDate`, `commentTime`, `email`, `comment`) VALUES 
('1', '2020/03/03', '10:32:23', 'register@gmail.com', 'Que pasada de evento!'),
('1', '2020/03/03', '13:31:01', 'moderator@gmail.com', 'Como mola!'),
('1', '2020/03/03', '19:56:45', 'gestor@gmail.com', 'Que chulada!'),
('2', '2020/03/03', '10:32:23', 'register@gmail.com', 'Que pasada de evento!'),
('2', '2020/03/03', '13:31:01', 'moderator@gmail.com', 'Como mola!'),
('2', '2020/03/03', '19:56:45', 'gestor@gmail.com', 'Que chulada!'),
('3', '2020/03/03', '10:32:23', 'register@gmail.com', 'Que pasada de evento!'),
('3', '2020/03/03', '13:31:01', 'moderator@gmail.com', 'Como mola!'),
('3', '2020/03/03', '19:56:45', 'gestor@gmail.com', 'Que chulada!');

CREATE OR REPLACE TABLE banned_words
(
    word varchar(30) NOT NULL
);

INSERT INTO `banned_words` (`word`) VALUES
('puta'),
('cabron'),
('mamon'),
('gilipollas'),
('polla'),
('coño'),
('tonto'),
('tonta'),
('bobo'),
('boba');
