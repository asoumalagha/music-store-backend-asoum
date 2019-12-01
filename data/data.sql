DROP DATABASE IF EXISTS music_store_asoum;

CREATE DATABASE music_store_asoum;

USE music_store_asoum;

DROP TABLE IF EXISTS person;

CREATE TABLE person (
    id INT UNIQUE NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,

    PRIMARY KEY (id),
    UNIQUE KEY ID_name (name)
)
    ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO person(name) VALUES ('John Doe');
INSERT INTO person(name) VALUES ('Samantha Byers');
INSERT INTO person(name) VALUES ('Lady Gaga');

DROP TABLE IF EXISTS band;

CREATE TABLE band (
      id INT UNIQUE NOT NULL AUTO_INCREMENT,
      name VARCHAR(50) NOT NULL,

      PRIMARY KEY (id),
      UNIQUE KEY ID_name (name)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO band(name) VALUES ('Foo Fighters');
INSERT INTO band(name) VALUES ('System of a Down');
INSERT INTO band(name) VALUES ('Lady Gaga');

DROP TABLE IF EXISTS person_band;

CREATE TABLE person_band(
    person_id INT NOT NULL,
    FOREIGN KEY (person_id) REFERENCES person(id),
    band_id INT NOT NULL,
    FOREIGN KEY (band_id) REFERENCES band(id)

);

INSERT INTO person_band(person_id, band_id) VALUES(1, 1);
INSERT INTO person_band(person_id, band_id) VALUES(1, 2);
INSERT INTO person_band(person_id, band_id) VALUES(2, 2);
INSERT INTO person_band(person_id, band_id) VALUES(3, 3);

DROP TABLE IF EXISTS album;

CREATE TABLE album(
                      id INT UNIQUE NOT NULL AUTO_INCREMENT,
                      name VARCHAR(50) NOT NULL,
                      band_id INT NOT NULL,

                      PRIMARY KEY (id),
                      UNIQUE KEY ID_name (name),
                      FOREIGN KEY (band_id) REFERENCES band(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO album(name, band_id) VALUES ('Toxicity', 2);
INSERT INTO album(name, band_id) VALUES ('Hypnotize', 2);
INSERT INTO album(name, band_id) VALUES ('Skin and Bones', 1);
INSERT INTO album(name, band_id) VALUES ('Born this way', 3);

DROP TABLE IF EXISTS song;

CREATE TABLE song(
    id INT UNIQUE NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    album_id INT NOT NULL,

    PRIMARY KEY (id),
    UNIQUE KEY ID_name(name),
    FOREIGN KEY (album_id) REFERENCES album(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO song(name, album_id) VALUES ('Swine', 4);
INSERT INTO song(name, album_id) VALUES ('Bounce', 1);
INSERT INTO song(name, album_id) VALUES ('Soldier side', 2);
INSERT INTO song(name, album_id) VALUES ('IDK', 3);


