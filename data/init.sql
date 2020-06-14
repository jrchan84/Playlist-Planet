CREATE DATABASE playlist_planet;

    use playlist_planet;

    CREATE TABLE artists(
    artist_id INTEGER AUTO_INCREMENT,
    sex VARCHAR(20),
    name VARCHAR(50),
    nationality VARCHAR(50),
    PRIMARY KEY (artist_id)
);

CREATE TABLE station_library(
    library_id INTEGER AUTO_INCREMENT,
    call_freq FLOAT,
    call_sign VARCHAR(10),
    name VARCHAR(50),
    PRIMARY KEY (library_id)
);

CREATE TABLE studio(
    studio_id INTEGER AUTO_INCREMENT,
    capacity INTEGER,
    description VARCHAR(255),
    PRIMARY KEY (studio_id)
);

CREATE TABLE episodes(
    episode_id INTEGER AUTO_INCREMENT,
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
    equip_id INTEGER AUTO_INCREMENT,
    name VARCHAR(255),
    description VARCHAR(255),
    PRIMARY KEY (equip_id, studio_id),
    FOREIGN KEY (studio_id) REFERENCES studio(studio_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE shows(
    show_id INTEGER AUTO_INCREMENT,
    name VARCHAR(255),
    start_date DATE,
    active BOOLEAN,
    PRIMARY KEY (show_id)
);

/*
CREATE TABLE hosts(
    host_id INTEGER AUTO_INCREMENT,
    PRIMARY KEY (host_id)
);
*/

CREATE TABLE collectives(
    host_id INTEGER,
    name VARCHAR(255),
    description CHAR(255),
    PRIMARY KEY (host_id)
    /*FOREIGN KEY (host_id) REFERENCES hosts(host_id) ON DELETE CASCADE*/
);

CREATE TABLE station_members(
    host_id INTEGER AUTO_INCREMENT,
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
    PRIMARY KEY (host_id)
    /*FOREIGN KEY (host_id) REFERENCES hosts(host_id) ON DELETE CASCADE*/
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
    media_id INTEGER AUTO_INCREMENT,
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
    FOREIGN KEY (library_id) REFERENCES station_library(library_id)
        ON UPDATE CASCADE,
    FOREIGN KEY (media_id) REFERENCES media(media_id)
        ON UPDATE CASCADE
);

CREATE TABLE episode_consists_of_media(
    episode_id INTEGER,
    media_id INTEGER,
    PRIMARY KEY (episode_id, media_id),
    FOREIGN KEY (episode_id) REFERENCES episodes(episode_id)
        ON UPDATE CASCADE,
    FOREIGN KEY (media_id) REFERENCES media(media_id)
        ON UPDATE CASCADE
);

CREATE TABLE show_has_episode(
    episode_id INTEGER,
    show_id INTEGER,
    host_id INTEGER,
    PRIMARY KEY (episode_id, show_id, host_id),
    FOREIGN KEY (episode_id) REFERENCES episodes(episode_id)
        ON UPDATE CASCADE,
    FOREIGN KEY (show_id) REFERENCES shows(show_id)
        ON UPDATE CASCADE,
    FOREIGN KEY (host_id) REFERENCES station_members(host_id)
        ON UPDATE CASCADE
);

CREATE TABLE members_are_part_of_collectives(
    stn_member_id INTEGER,
    collective_id INTEGER,
    PRIMARY KEY (stn_member_id, collective_id),
    FOREIGN KEY (stn_member_id) REFERENCES station_members(host_id)
        ON UPDATE CASCADE,
    FOREIGN KEY (collective_id) REFERENCEs station_members(host_id)
        ON UPDATE CASCADE
);

INSERT INTO artists VALUES (1, 'F', 'Fiona Apple', 'USA');
INSERT INTO artists VALUES (2, 'F', 'Charli XCX', 'UK');
INSERT INTO artists VALUES (3, 'M', 'Perfume Genius', 'USA');
INSERT INTO artists VALUES (4, 'M', 'Caribou', 'CANADA');
INSERT INTO artists VALUES (5, 'F', 'Black Dresses', 'CANADA');
INSERT INTO artists VALUES (6, 'F', 'ODESZA', 'USA');
INSERT INTO artists VALUES (7, 'M', 'The 1975', 'UK');
INSERT INTO artists VALUES (8, 'F', 'Beach House', 'USA');
INSERT INTO artists VALUES (9, 'F', 'Noname', 'USA');
INSERT INTO artists VALUES (10, 'M', 'Kendrick Lamar', 'USA');

INSERT INTO station_library VALUES (1, 30.4, 'CPDB', 'Playlist Planet');
INSERT INTO station_library VALUES (2, 101.9, 'CiTR', 'CiTR/Discorder Magazine');
INSERT INTO station_library VALUES (3, 98.1, 'CJSF', 'SFU College Radio');
INSERT INTO station_library VALUES (4, 101.9, 'CFUV', 'UVic College Radio');
INSERT INTO station_library VALUES (5, 94.5, 'CFBT', 'Virgin Radio');
INSERT INTO station_library VALUES (6, 103.5, 'CQHM', 'Today\'s Best Variety');
INSERT INTO station_library VALUES (7, 102.7, 'CKPK', 'The Peak');
INSERT INTO station_library VALUES (8, 95.3, 'CKZZ', 'Z Radio');
INSERT INTO station_library VALUES (9, 96.9, 'CJAX', 'Jack Radio');
INSERT INTO station_library VALUES (10, 107.5, 'CKKS', 'Kiss Radio');

INSERT INTO studio VALUES (1, 8, 'Studio A');
INSERT INTO studio VALUES (2, 5, 'Studio B');
INSERT INTO studio VALUES (3, 2, 'Studio C');
INSERT INTO studio VALUES (4, 1, 'Individual Recording Studio 1');
INSERT INTO studio VALUES (5, 1, 'Individual Recording Studio 2');
INSERT INTO studio VALUES (6, 8, 'Live Studio');
INSERT INTO studio VALUES (7, 5, 'Two-Way Studio');
INSERT INTO studio VALUES (8, 3, 'Podcast Studio A');
INSERT INTO studio VALUES (9, 3, 'Podcast Studio B');
INSERT INTO studio VALUES (10, 2, 'Podcast Studio C');

INSERT INTO episodes VALUES (1, 1, '2020-05-07 13:00:00', '2020-05-07 14:00:00', 15, 'Death Grips Retrospective', '');
INSERT INTO episodes VALUES (2, 1, '2020-01-07 16:00:00', '2020-01-07 17:00:00', 60, 'BLM and Police Abolition', '');
INSERT INTO episodes VALUES (3, 1, '2020-04-07 16:00:00', '2020-04-07 17:30:00', 45, 'Pride Month Programming', '');
INSERT INTO episodes VALUES (4, 2, '2020-05-08 10:00:00', '2020-05-08 11:00:00', 20, 'Coronavirus Weekly Update', '');
INSERT INTO episodes VALUES (5, 2, '2020-05-07 10:00:00', '2020-05-07 12:00:00', 60, 'Dune and Political Sci-Fi', '');
INSERT INTO episodes VALUES (6, 2, '2020-05-11 11:00:00', '2020-05-11 13:00:00', 70, 'A Decade of Memes', '');
INSERT INTO episodes VALUES (7, 3, '2020-05-07 11:00:00', '2020-05-07 12:00:00', 30, 'Public Libraries and their Worth', '');
INSERT INTO episodes VALUES (8, 4, '2020-05-30 15:00:00', '2020-05-30 16:00:00', 15, 'Tinder and Online Dating', '');
INSERT INTO episodes VALUES (9, 5, '2020-06-07 15:00:00', '2020-06-07 16:00:00', 20, 'AMS Elections', '');
INSERT INTO episodes VALUES (10, 6, '2019-12-31 17:00:00', '2019-12-31 18:45:00', 50, 'Computer Science Specializations', '');

INSERT INTO studio_equipment VALUES (1, 1, 'Rode Mic 1', 'Rode Sphere Mic');
INSERT INTO studio_equipment VALUES (2, 2, 'Rode Mic 1', 'Rode Cartoid Mic');
INSERT INTO studio_equipment VALUES (1, 3, 'Axia Mixer', 'AXIA Pro Mixer');
INSERT INTO studio_equipment VALUES (2, 4, 'Axia Mixer', 'AXIA Telos Mixer');
INSERT INTO studio_equipment VALUES (3, 5, 'Axia Mixer', 'AXIA Telos Mixer');
INSERT INTO studio_equipment VALUES (1, 6, 'Rode Mic 2', 'Rode Sphere Mic');
INSERT INTO studio_equipment VALUES (2, 7, 'Rode Mic 2', 'Rode Cartoid Mic');
INSERT INTO studio_equipment VALUES (4, 8, 'Axia Mixer', 'AXIA Pro Mixer');
INSERT INTO studio_equipment VALUES (5, 9, 'Axia Mixer', 'AXIA Telos Mixer');
INSERT INTO studio_equipment VALUES (6, 10, 'Axia Mixer', 'AXIA Telos Mixer');

INSERT INTO shows VALUES (1, 'UBC Sports Report', '2013-01-14', 1);
INSERT INTO shows VALUES (2, 'Weekly News', '2012-09-05', 1);
INSERT INTO shows VALUES (3, 'Student Voices Now!', '2012-09-04', 1);
INSERT INTO shows VALUES (4, 'Jazz & Pop', '2015-02-03', 1);
INSERT INTO shows VALUES (5, 'Violent Rhythms', '2016-01-07', 1);
INSERT INTO shows VALUES (6, 'Crunk Weekly', '2013-01-14', 0);
INSERT INTO shows VALUES (7, 'Hip-Hop Hustle', '2012-09-05', 1);
INSERT INTO shows VALUES (8, 'Nightcore Network', '2012-09-04', 0);
INSERT INTO shows VALUES (9, 'Ambient Noise', '2015-02-03', 1);
INSERT INTO shows VALUES (10, 'Experimental Echoes', '2016-01-07', 1);

/*
INSERT INTO hosts VALUES (1);
INSERT INTO hosts VALUES (2);
INSERT INTO hosts VALUES (3);
INSERT INTO hosts VALUES (4);
INSERT INTO hosts VALUES (5);
INSERT INTO hosts VALUES (6);
INSERT INTO hosts VALUES (7);
INSERT INTO hosts VALUES (8);
INSERT INTO hosts VALUES (9);
INSERT INTO hosts VALUES (10);
INSERT INTO hosts VALUES (11);
INSERT INTO hosts VALUES (12);
INSERT INTO hosts VALUES (13);
INSERT INTO hosts VALUES (14);
INSERT INTO hosts VALUES (15);
INSERT INTO hosts VALUES (16);
INSERT INTO hosts VALUES (17);
INSERT INTO hosts VALUES (18);
INSERT INTO hosts VALUES (19);
INSERT INTO hosts VALUES (20);
INSERT INTO hosts VALUES (21);
INSERT INTO hosts VALUES (22);
INSERT INTO hosts VALUES (23);
INSERT INTO hosts VALUES (24);
INSERT INTO hosts VALUES (25);
INSERT INTO hosts VALUES (26);
INSERT INTO hosts VALUES (27);
INSERT INTO hosts VALUES (28);
INSERT INTO hosts VALUES (29);
INSERT INTO hosts VALUES (30);
*/

INSERT INTO collectives VALUES (11, 'Sports Collective', '');
INSERT INTO collectives VALUES (12, 'News Collective', '');
INSERT INTO collectives VALUES (13, 'Student Affairs', '');
INSERT INTO collectives VALUES (14, 'Jazz Collective', '');
INSERT INTO collectives VALUES (15, 'Punk Collective', '');
INSERT INTO collectives VALUES (16, 'Crunk Collective', '');
INSERT INTO collectives VALUES (17, 'Election Issues', '');
INSERT INTO collectives VALUES (18, 'LGBTQ Collective', '');
INSERT INTO collectives VALUES (19, 'Asian Studies', '');
INSERT INTO collectives VALUES (20, 'Science Summit', '');

INSERT INTO station_members VALUES (1, 'Patrick', 'Lee', 'BC', 'V6Y3Z6', 'He/Him/His', '8600 Jones Rd.', 'Richmond', 'pl0419@students.cs.ubc.ca', '6046499449', '', '', '');
INSERT INTO station_members VALUES (2, 'Alan', 'Smith', 'BC', 'V6H3Z5', 'He/Him/His', '123 Street', 'Vancouver', 'alansmithee@gmail.com', '6041234567', '', '', '');
INSERT INTO station_members VALUES (3, 'Mary', 'Smith', 'BC', 'V6T1J5', 'She/Her/Hers', '456 Boulevard', 'Vancouver', 'marysmith@gmail.com', '7781234567', '', '', '');
INSERT INTO station_members VALUES (4, 'Jane', 'Lee', 'BC', 'V6X1J5', 'She/Her/Hers', '2345 E 45 Ave', 'Vancouver', 'janelee@alumni.com', '7781234567', '', '', '');
INSERT INTO station_members VALUES (5,'Bob', 'Zhang', 'BC', 'V6T1J5', 'He/Him/His', '1234 E 41 Ave', 'Vancouver', 'zhangb@ubc.ca', '7781234567', '7785648735', '', '');
INSERT INTO station_members VALUES (6, 'Joe', 'Alain', 'BC', 'V6T1J5', 'They/Them', '455 Street', 'Vancouver', 'alainjh@ubc.ca', '7781234567', '', '', '');
INSERT INTO station_members VALUES (7, 'Charles', 'DeSantos', 'BC', 'V6T1J5', 'He/Him/His', '798 Street', 'Vancouver', 'cdesantos@ubc.ca', '7781234567', '', '', '');
INSERT INTO station_members VALUES (8, 'Anna', 'Johnston', 'BC', 'V6T1J5', 'She/Her/Hers', '8595 W 41 Ave', 'Vancouver', 'annaj1234@gmail.com', '7781234567', '', '', '');
INSERT INTO station_members VALUES (9, 'Taylor', 'Corrico', 'BC', 'V6T1J5', 'She/Her/Hers', '4513 E 43 Ave', 'Vancouver', 'taylor4556@gmail.com', '7781234567', '', '', '');
INSERT INTO station_members VALUES (10, 'Ming', 'Xi', 'BC', 'V6T1J5', 'He/Him/His', '4552 Boulevard', 'Vancouver', 'mingxi452@gmail.com', '7781234567', '', '', '');
INSERT INTO station_members VALUES (21, 'Ferris', 'Lee', 'BC', 'V6Y3Z6', 'He/Him/His', '8600 Jones Rd.', 'Richmond', 'flee0229@students.cs.ubc.ca', '60474195498', '', '', '');
INSERT INTO station_members VALUES (22, 'Alan', 'Soros', 'BC', 'V6X3Z5', 'He/Him/His', '123 Street', 'Vancouver', 'sorosa@gmail.com', '6041235719', '', '', '');
INSERT INTO station_members VALUES (23, 'Mary', 'Johnson', 'BC', 'V6Y1J5', 'She/Her/Hers', '456 Boulevard', 'Vancouver', 'maryj3727@gmail.com', '7781715787', '', '', '');
INSERT INTO station_members VALUES (24, 'Jane', 'McSmith', 'BC', 'V6X1J5', 'She/Her/Hers', '2345 E 45 Ave', 'Vancouver', 'mcsmithje@alumni.com', '7781234567', '', '', '');
INSERT INTO station_members VALUES (25,'Bill', 'Zhang', 'BC', 'V6T1J5', 'He/Him/His', '1234 E 41 Ave', 'Vancouver', 'billzhang0507@ubc.ca', '7781278495', '7785648157', '', '');
INSERT INTO station_members VALUES (26, 'Francois', 'Alain', 'BC', 'V6T1J5', 'They/Them', '455 Street', 'Vancouver', 'falain23@ubc.ca', '7781549877', '', '', '');
INSERT INTO station_members VALUES (27, 'Michael', 'DeSantos', 'BC', 'V6T2J7', 'He/Him/His', '798 Street', 'Vancouver', 'michdesantos@ubc.ca', '7781245739', '', '', '');
INSERT INTO station_members VALUES (28, 'Anna', 'Corrian', 'BC', 'V6T1J5', 'She/Her/Hers', '8595 W 41 Ave', 'Vancouver', 'annncorr1220@gmail.com', '7781235468', '', '', '');
INSERT INTO station_members VALUES (29, 'Taylor', 'Bennett', 'BC', 'V6X1J5', 'She/Her/Hers', '4513 E 43 Ave', 'Vancouver', 'taylorbennett21@gmail.com', '7789492122', '', '', '');
INSERT INTO station_members VALUES (30, 'Xi', 'Yuan', 'BC', 'V6W1J5', 'She/Her/Hers', '4552 Boulevard', 'Vancouver', 'xiyuan0407@gmail.com', '7781454567', '', '', '');


INSERT INTO content_creators VALUES (1, 1, 1);
INSERT INTO content_creators VALUES (2, 0, 1);
INSERT INTO content_creators VALUES (3, 3, 1);
INSERT INTO content_creators VALUES (4, 3, 1);
INSERT INTO content_creators VALUES (5, 3, 1);
INSERT INTO content_creators VALUES (21, 1, 0);
INSERT INTO content_creators VALUES (22, 0, 0);
INSERT INTO content_creators VALUES (23, 2, 1);
INSERT INTO content_creators VALUES (24, 3, 1);
INSERT INTO content_creators VALUES (25, 3, 1);

INSERT INTO administrators VALUES (6, 'Station Manager', '2015-09-03');
INSERT INTO administrators VALUES (7, 'Technical Manager', '2016-09-07');
INSERT INTO administrators VALUES (8, 'Social Media Co-ordinator', '2017-08-23');
INSERT INTO administrators VALUES (9, 'Content Manager', '2015-08-23');
INSERT INTO administrators VALUES (10, 'Podcasting Co-ordinator', '2015-08-23');
INSERT INTO administrators VALUES (26, 'Station Assistant Manager', '2016-08-25');
INSERT INTO administrators VALUES (27, 'Music Library Curator', '2017-08-26');
INSERT INTO administrators VALUES (28, 'Digital Library Organizer', '2015-01-23');
INSERT INTO administrators VALUES (29, 'Technical Assistant', '2016-01-23');
INSERT INTO administrators VALUES (30, 'Editor-In-Chief', '2014-08-23');


INSERT INTO media VALUES (1, 'Shameika');
INSERT INTO media VALUES (2, 'forever');
INSERT INTO media VALUES (3, 'Without You');
INSERT INTO media VALUES (4, 'Never Come Back');
INSERT INTO media VALUES (5, 'CREEP YOU');
INSERT INTO media VALUES (6, 'Shameika');
INSERT INTO media VALUES (7, 'forever');
INSERT INTO media VALUES (8, 'Without You');
INSERT INTO media VALUES (9, 'Never Come Back');
INSERT INTO media VALUES (10, 'CREEP YOU');
INSERT INTO media VALUES (11, 'Juuling PSA');
INSERT INTO media VALUES (12, 'COVID-19 PSA');
INSERT INTO media VALUES (13, 'Social Distancing Measures');
INSERT INTO media VALUES (14, 'Hand-washing PSA');
INSERT INTO media VALUES (15, 'Community Programming PSA');
INSERT INTO media VALUES (16, 'Juuling PSA');
INSERT INTO media VALUES (17, 'COVID-19 PSA');
INSERT INTO media VALUES (18, 'Social Distancing Measures');
INSERT INTO media VALUES (19, 'Hand-washing PSA');
INSERT INTO media VALUES (20, 'Community Programming PSA');
INSERT INTO media VALUES (21, 'IKEA Ad');
INSERT INTO media VALUES (22, 'McDonalds Ad');
INSERT INTO media VALUES (23, 'KFC Ad');
INSERT INTO media VALUES (24, 'TD Ad');
INSERT INTO media VALUES (25, 'CIBC Ad');
INSERT INTO media VALUES (26, 'IKEA Ad');
INSERT INTO media VALUES (27, 'McDonalds Ad');
INSERT INTO media VALUES (28, 'KFC Ad');
INSERT INTO media VALUES (29, 'TD Ad');
INSERT INTO media VALUES (30, 'CIBC Ad');

INSERT INTO tracks VALUES (1, 'English', 'Art pop', 'Fetch the Bolt Cutters');
INSERT INTO tracks VALUES (2, 'English', 'Pop', 'how i\'m feeling now');
INSERT INTO tracks VALUES (3, 'English', 'Singer-songwriter', 'Set My Heart On Fire Immediately');
INSERT INTO tracks VALUES (4, 'English', 'Electronic', 'Suddenly');
INSERT INTO tracks VALUES (5, 'English', 'Experimental', 'PEACEFUL AS HELL');
INSERT INTO tracks VALUES (6, 'English', 'Electronic', 'In Return');
INSERT INTO tracks VALUES (7, 'English', 'Alternative', 'The 1975');
INSERT INTO tracks VALUES (8, 'English', 'Alternative/Indie', 'Depression Cherry');
INSERT INTO tracks VALUES (9, 'English', 'Jazz Rap', 'Telefone');
INSERT INTO tracks VALUES (10, 'English', 'Hip-Hop/Rap', 'DAMN.');

INSERT INTO psas VALUES (11, 'Government of Canada PSA for Juul-ing side effects');
INSERT INTO psas VALUES (12, 'Latest COVID-19 measures');
INSERT INTO psas VALUES (13, 'Best practices for social distancing');
INSERT INTO psas VALUES (14, 'Best practices for hand washing');
INSERT INTO psas VALUES (15, 'Community events ongoing and supporting local communities during COVID-19');
INSERT INTO psas VALUES (16, 'Government of Canada PSA for Juul-ing side effects');
INSERT INTO psas VALUES (17, 'Latest COVID-19 measures');
INSERT INTO psas VALUES (18, 'Best practices for social distancing');
INSERT INTO psas VALUES (19, 'Best practices for hand washing');
INSERT INTO psas VALUES (20, 'Community events ongoing and supporting local communities during COVID-19');

INSERT INTO ads VALUES (21, '');
INSERT INTO ads VALUES (22, '');
INSERT INTO ads VALUES (23, '');
INSERT INTO ads VALUES (24, '');
INSERT INTO ads VALUES (25, '');
INSERT INTO ads VALUES (26, '');
INSERT INTO ads VALUES (27, '');
INSERT INTO ads VALUES (28, 'Visit Richmond Auto Mall to take home your dream vehicle.');
INSERT INTO ads VALUES (29, 'For Canadian release ONLY.');
INSERT INTO ads VALUES (30, 'Visit Kijiji to find the rental that suits your needs.');

INSERT INTO performed_by VALUES (1, 1);
INSERT INTO performed_by VALUES (2, 2);
INSERT INTO performed_by VALUES (3, 3);
INSERT INTO performed_by VALUES (4, 4);
INSERT INTO performed_by VALUES (5, 5);
INSERT INTO performed_by VALUES (6, 6);
INSERT INTO performed_by VALUES (7, 7);
INSERT INTO performed_by VALUES (8, 8);
INSERT INTO performed_by VALUES (9, 9);
INSERT INTO performed_by VALUES (10, 10);

INSERT INTO station_owns_media VALUES (1, 1);
INSERT INTO station_owns_media VALUES (1, 2);
INSERT INTO station_owns_media VALUES (1, 3);
INSERT INTO station_owns_media VALUES (1, 4);
INSERT INTO station_owns_media VALUES (1, 5);
INSERT INTO station_owns_media VALUES (1, 6);
INSERT INTO station_owns_media VALUES (1, 7);
INSERT INTO station_owns_media VALUES (1, 8);
INSERT INTO station_owns_media VALUES (1, 9);
INSERT INTO station_owns_media VALUES (1, 10);
INSERT INTO station_owns_media VALUES (1, 11);
INSERT INTO station_owns_media VALUES (1, 12);
INSERT INTO station_owns_media VALUES (1, 13);
INSERT INTO station_owns_media VALUES (1, 14);
INSERT INTO station_owns_media VALUES (1, 15);
INSERT INTO station_owns_media VALUES (1, 16);
INSERT INTO station_owns_media VALUES (1, 17);
INSERT INTO station_owns_media VALUES (1, 18);
INSERT INTO station_owns_media VALUES (1, 19);
INSERT INTO station_owns_media VALUES (1, 20);

INSERT INTO episode_consists_of_media VALUES (1, 1);
INSERT INTO episode_consists_of_media VALUES (1, 2);
INSERT INTO episode_consists_of_media VALUES (1, 3);
INSERT INTO episode_consists_of_media VALUES (1, 4);
INSERT INTO episode_consists_of_media VALUES (1, 5);
INSERT INTO episode_consists_of_media VALUES (1, 6);
INSERT INTO episode_consists_of_media VALUES (1, 11);
INSERT INTO episode_consists_of_media VALUES (1, 13);
INSERT INTO episode_consists_of_media VALUES (1, 22);
INSERT INTO episode_consists_of_media VALUES (1, 24);

INSERT INTO show_has_episode VALUES (1, 1, 1);
INSERT INTO show_has_episode VALUES (2, 2, 3);
INSERT INTO show_has_episode VALUES (3, 3, 4);
INSERT INTO show_has_episode VALUES (4, 4, 11);
INSERT INTO show_has_episode VALUES (5, 5, 16);
INSERT INTO show_has_episode VALUES (6, 1, 1);
INSERT INTO show_has_episode VALUES (7, 2, 3);
INSERT INTO show_has_episode VALUES (8, 3, 4);
INSERT INTO show_has_episode VALUES (9, 4, 11);
INSERT INTO show_has_episode VALUES (10, 5, 16);

INSERT INTO members_are_part_of_collectives VALUES (1, 11);
INSERT INTO members_are_part_of_collectives VALUES (2, 12);
INSERT INTO members_are_part_of_collectives VALUES (3, 13);
INSERT INTO members_are_part_of_collectives VALUES (4, 14);
INSERT INTO members_are_part_of_collectives VALUES (5, 15);
INSERT INTO members_are_part_of_collectives VALUES (21, 11);
INSERT INTO members_are_part_of_collectives VALUES (22, 12);
INSERT INTO members_are_part_of_collectives VALUES (23, 13);
INSERT INTO members_are_part_of_collectives VALUES (24, 13);
INSERT INTO members_are_part_of_collectives VALUES (25, 15);








