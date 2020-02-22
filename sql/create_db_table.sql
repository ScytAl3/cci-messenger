#------------------------------------------------------------
#                        Script MySQL.
#------------------------------------------------------------
#-- creation de la base de donnees si elle n existe pas
CREATE DATABASE IF NOT EXISTS db_chat;
#-- on precise que l on va utiliser cette datbase pour creer les tables
USE db_chat;

#------------------------------------------------------------
# Table: USERS
#------------------------------------------------------------

CREATE TABLE users (
    userId                     int                       not null  Auto_increment,
    userLastName        varchar(75)         not null,
    userFirstName       varchar(75)         not null,    
    userPseudo              varchar(25)         not null,
    userEmail               varchar(100)       not null,
    userPassword         varchar(255)         not null,
    userSalt                    varchar(255)         not null,
    userPicture               varchar(100)         not null,
    CONSTRAINT users_PK PRIMARY KEY (userId),
    UNIQUE KEY unique_email (userEmail),
    UNIQUE KEY unique_pseudo (userPseudo)
) ENGINE=InnoDB;

#------------------------------------------------------------
# Table: MESSAGING
#------------------------------------------------------------

CREATE TABLE messaging (
    messagingId                     int         not null  Auto_increment,
    receiverId                         int        not null,
    senderId                            int      not null,
    CONSTRAINT messaging_PK PRIMARY KEY (messagingId),
    FOREIGN KEY (receiverId) REFERENCES users(userId),
    FOREIGN KEY (senderId) REFERENCES users(userId)
) ENGINE=InnoDB;

#------------------------------------------------------------
# Table: MESSAGES
#------------------------------------------------------------

CREATE TABLE messages (
    messagesId                  int                      not null Auto_increment,
    messagingId                int                      not null,
    create_at                    datetime               not null,
    messageBody           varchar(255)         not null,
    CONSTRAINT messages_PK PRIMARY KEY (messagesId),
    FOREIGN KEY (messagingId) REFERENCES messaging(messagingId)
) ENGINE=InnoDB;

#-----------------------------------------------------------
#                     JEU DE DONNEES
#-----------------------------------------------------------
#-----------------------------------------------------------
# Table: USERS - Data
#-----------------------------------------------------------

INSERT INTO 
    users(userLastName, userFirstName, userPseudo, userEmail, userPassword, userSalt, userPicture) 
VALUES 
    ('Doe', 'John', 'whoami', 'j.doe@cci.fr', '54e4feb636204d1e5fcf49fb202946db', 'b7c8cb5b20beb2733470a65bb59722de', 'jdoe.jpg'),              -- az3rty
    ( 'Jobs', 'Steve', 'in the sky', 'amazing@rip.com', '1f1c153c6717024f825a862901f9c3bc', '476e62fcde5fcaa1e7fc2629da120ce9', 'sjobs.jpg'),                  -- 4pple 
    ('Tuttle', 'Archibald', 'heating engineer', 'harry.tuttle@br.com', '78169d67d449272b6bad1438b75bf4fe', '1641b4d0b9a50afbadb3cedf983c9cd1', 'atuttle.jpg'),    -- Ninj4
    ('Bismuth', 'Paul', 'carla B', 'ns-2017@lr.fr', 'b4f56e6dca3905a5b3f4e73058ba2ab2', '5e406044172b4831cf110e63b51f0b47', 'pbismuth.jpg'),                   -- Sark0
    ('Balkany', 'Patrick', 'robin des bois', 'la-sante@gouv.fr', '4fcf95ce8284291469466c0b2aecaed8', '61a722aee2cc2e539778622bc7ee7c4d', 'pbalkany.jpg'),             -- money
    ('Abagnale', 'Frank', 'im a pilote','catch.me@noop.fr', 'a87f2462177f71232e05bd00f68675ef', '5d969f98d53259fe94d0245eb8d3ac26', 'fabagnale.jpg');          -- c4tchM3

#-----------------------------------------------------------
# Table: MESSAGING - Data
#-----------------------------------------------------------
INSERT INTO
    messaging(`receiverId`, `senderId`)
VALUES
    (1, 4),         -- messagingId 01
    (4, 1),         -- messagingId 02
    (4, 1),         -- messagingId 03
    (1, 4),         -- messagingId 04
    (1, 6),         -- messagingId 05
    (4, 2),         -- messagingId 06
    (1, 2),         -- messagingId 07
    (2, 6),         -- messagingId 08
    (2, 6),         -- messagingId 09
    (3, 1),         -- messagingId 10
    (1, 3);         -- messagingId 11

#-----------------------------------------------------------
# Table: MESSAGES - Data
#-----------------------------------------------------------
INSERT INTO
    messages(`messagingId`, `create_at`, `messageBody`)
VALUES
    (1, '2020-02-20 13:29:09', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.'),
    (2, '2020-02-20 13:35:49', 'Atque, voluptatem?'),
    (3, '2020-02-20 13:35:57', 'Velit qui nobis odio consectetur saepe, voluptates laboriosam temporibus, impedit quibusdam dolorum, ullam dolore eaque odit fugiat praesentium asperiores.'),
    (4, '2020-02-20 13:37:07', 'At hoc in eo M.');
    (5, '2020-02-20 13:47:20', 'De quibus cupio scire quid sentias. Traditur, inquit, ab Epicuro ratio neglegendi doloris.'),
    (6, '2020-02-20 13:48:17', 'Pork loin doner sausage turducken capicola.  Pork chop beef ribs turkey ball tip shankle, chicken short loin burgdoggen tongue.'),
    (7, '2020-02-20 13:51:09', 'Ham meatloaf beef jerky pork loin.'),
    (8, '2020-02-20 13:57:45', 'Dracopelta Tangvayosaurus Nigersaurus Lamplughsaura Hypsirophus Fruitadens Gongbusaurus Erlicosaurus Balochisaurus'),
    (9, '2020-02-20 14:07:25', 'Albertonykus Adeopapposaurus Kotasaurus'),
    (10, '2020-02-20 14:09:50', 'Haec igitur Epicuri non probo, inquam. Praeteritis, inquit, gaudeo. Uterque enim summo bono fruitur, id est voluptate.'),
    (11, '2020-02-20 14:17:37', 'Fortemne possumus dicere eundem illum Torquatum?');