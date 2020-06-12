CREATE TABLE artists(
    artist_id INTEGER,
    sex VARCHAR(20),
    name VARCHAR(50),
    nationality VARCHAR(50),
    PRIMARY KEY (artist_id)
);

CREATE TABLE station_library(
    library_id INTEGER,
    call_freq FLOAT,
    call_sign VARCHAR(10),
    name VARCHAR(50),
    PRIMARY KEY (library_id)
);

CREATE TABLE studio(
    studio_id INTEGER,
    capacity INTEGER,
    description VARCHAR(255),
    PRIMARY KEY (studio_id)
);

CREATE TABLE episodes(
    episode_id INTEGER,
    studio_id INTEGER NOT NULL,
    start_time DATETIME,
    end_time DATETIME,
    spoken_word_duration INTEGER,
    title VARCHAR(255),
    description VARCHAR(255),
    PRIMARY KEY (episode_id),
    FOREIGN KEY (studio_id) REFERENCES studio(studio_id)
        ON UPDATE CASCADE
);

CREATE TABLE studio_equipment(
    studio_id INTEGER,
    equip_id INTEGER,
    name VARCHAR(255),
    description VARCHAR(255),
    PRIMARY KEY (equip_id, studio_id),
    FOREIGN KEY (studio_id) REFERENCES studio(studio_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE shows(
    show_id INTEGER,
    name VARCHAR(255),
    start_date DATE,
    active BOOLEAN,
    PRIMARY KEY (show_id)
);

CREATE TABLE hosts(
    host_id INTEGER,
    PRIMARY KEY (host_id)
);

CREATE TABLE collectives(
    host_id INTEGER,
    name VARCHAR(255),
    description CHAR(255),
    PRIMARY KEY (host_id),
    FOREIGN KEY (host_id) REFERENCES hosts(host_id) ON DELETE CASCADE
);

CREATE TABLE station_members(
    host_id INTEGER,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    province VARCHAR(2),
    postalcode VARCHAR(6),
    pronouns VARCHAR(50),
    address VARCHAR(255),
    city VARCHAR(50),
    email VARCHAR(255),
    primary_phone VARCHAR(25),
    alt_phone VARCHAR(25),
    interests VARCHAR(255),
    skills VARCHAR(255),
    PRIMARY KEY (host_id),
    FOREIGN KEY (host_id) REFERENCES hosts(host_id) ON DELETE CASCADE
);

CREATE TABLE content_creators(
    host_id INTEGER,
    trainings_completed INTEGER,
    membership_fee_paid BOOLEAN,
    PRIMARY KEY (host_id),
    FOREIGN KEY (host_id) REFERENCES station_members(host_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE administrators(
    host_id INTEGER,
    role VARCHAR(255),
    start_date DATE,
    PRIMARY KEY (host_id),
    FOREIGN KEY (host_id) REFERENCES station_members(host_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE media(
    media_id INTEGER,
    title VARCHAR(255),
    PRIMARY KEY (media_id)
);

CREATE TABLE tracks(
    media_id INTEGER,
    language VARCHAR(50),
    genre VARCHAR(30),
    album VARCHAR(255),
    PRIMARY KEY (media_id),
    FOREIGN KEY (media_id) REFERENCES media(media_id)
        ON DELETE CASCADE
);

CREATE TABLE psas(
    media_id INTEGER,
    description VARCHAR(255),
    PRIMARY KEY (media_id),
    FOREIGN KEY (media_id) REFERENCES media(media_id)
        ON DELETE CASCADE
);

CREATE TABLE ads(
    media_id INTEGER,
    description VARCHAR(255),
    PRIMARY KEY (media_id),
    FOREIGN KEY (media_id) REFERENCES media(media_id)
        ON DELETE CASCADE
);

CREATE TABLE performed_by(
    artist_id INTEGER,
    media_id INTEGER,
    PRIMARY KEY (artist_id, media_id),
    FOREIGN KEY (artist_id) REFERENCES artists(artist_id) ON UPDATE CASCADE,
    FOREIGN KEY (media_id) REFERENCES tracks(media_id) ON UPDATE CASCADE
);

CREATE TABLE station_owns_media(
    library_id INTEGER,
    media_id INTEGER,
    PRIMARY KEY (library_id, media_id),
    FOREIGN KEY (library_id) REFERENCES station_library(library_id),
    FOREIGN KEY (media_id) REFERENCES media(media_id)
);

CREATE TABLE episode_consists_of_media(
    episode_id INTEGER,
    media_id INTEGER,
    PRIMARY KEY (episode_id, media_id),
    FOREIGN KEY (episode_id) REFERENCES episodes(episode_id),
    FOREIGN KEY (media_id) REFERENCES media(media_id)
);

CREATE TABLE show_has_episode(
    episode_id INTEGER,
    show_id INTEGER,
    host_id INTEGER,
    PRIMARY KEY (episode_id, show_id, host_id),
    FOREIGN KEY (episode_id) REFERENCES episodes(episode_id),
    FOREIGN KEY (show_id) REFERENCES shows(show_id),
    FOREIGN KEY (host_id) REFERENCES hosts(host_id)
);

CREATE TABLE members_are_part_of_collectives(
    stn_member_id INTEGER,
    collective_id INTEGER,
    PRIMARY KEY (stn_member_id, collective_id),
    FOREIGN KEY (stn_member_id) REFERENCES hosts(host_id),
    FOREIGN KEY (collective_id) REFERENCEs hosts(host_id)
);