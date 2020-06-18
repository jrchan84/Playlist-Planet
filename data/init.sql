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
        ON DELETE CASCADE
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

CREATE TABLE collectives(
    host_id INTEGER,
    name VARCHAR(255),
    description CHAR(255),
    PRIMARY KEY (host_id)
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
);


CREATE TABLE content_creators(
    host_id INTEGER,
    trainings_completed INTEGER,
    membership_fee_paid BOOLEAN,
    PRIMARY KEY (host_id),
    FOREIGN KEY (host_id) REFERENCES station_members(host_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);



CREATE TABLE administrators(
    host_id INTEGER,
    role VARCHAR(255),
    start_date DATE,
    PRIMARY KEY (host_id),
    FOREIGN KEY (host_id) REFERENCES station_members(host_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
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
        ON UPDATE CASCADE
);

CREATE TABLE psas(
    media_id INTEGER,
    description VARCHAR(255),
    PRIMARY KEY (media_id),
    FOREIGN KEY (media_id) REFERENCES media(media_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE ads(
    media_id INTEGER,
    description VARCHAR(255),
    PRIMARY KEY (media_id),
    FOREIGN KEY (media_id) REFERENCES media(media_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE performed_by(
    artist_id INTEGER,
    media_id INTEGER,
    PRIMARY KEY (artist_id, media_id),
    FOREIGN KEY (artist_id) REFERENCES artists(artist_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (media_id) REFERENCES tracks(media_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE station_owns_media(
    library_id INTEGER,
    media_id INTEGER,
    PRIMARY KEY (library_id, media_id),
    FOREIGN KEY (library_id) REFERENCES station_library(library_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (media_id) REFERENCES media(media_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE episode_consists_of_media(
    episode_id INTEGER,
    media_id INTEGER,
    PRIMARY KEY (episode_id, media_id),
    FOREIGN KEY (episode_id) REFERENCES episodes(episode_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (media_id) REFERENCES media(media_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE show_has_episode(
    episode_id INTEGER,
    show_id INTEGER,
    host_id INTEGER,
    PRIMARY KEY (episode_id, show_id, host_id),
    FOREIGN KEY (episode_id) REFERENCES episodes(episode_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (show_id) REFERENCES shows(show_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (host_id) REFERENCES station_members(host_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE members_are_part_of_collectives(
    stn_member_id INTEGER,
    collective_id INTEGER,
    PRIMARY KEY (stn_member_id, collective_id),
    FOREIGN KEY (stn_member_id) REFERENCES station_members(host_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (collective_id) REFERENCES collectives(host_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

INSERT INTO artists VALUES (1, 'F', 'Fiona Apple', 'USA');
INSERT INTO artists VALUES (2, 'F', 'Charli XCX', 'UK');
INSERT INTO artists VALUES (3, 'M', 'Perfume Genius', 'USA');
INSERT INTO artists VALUES (4, 'M', 'Caribou', 'CANADA');
INSERT INTO artists VALUES (5, 'F', 'Black Dresses', 'CANADA');
INSERT INTO artists VALUES (6, 'M', 'ODESZA', 'USA');
INSERT INTO artists VALUES (7, 'M', 'The 1975', 'UK');
INSERT INTO artists VALUES (8, 'F', 'Beach House', 'USA');
INSERT INTO artists VALUES (9, 'F', 'Noname', 'USA');
INSERT INTO artists VALUES (10, 'M', 'Kendrick Lamar', 'USA');
INSERT INTO artists VALUES (11, 'F', 'Grimes', 'CANADA');
INSERT INTO artists VALUES (12, 'M', 'Blood Orange', 'USA');
INSERT INTO artists VALUES (13, 'F', 'Alvvays', 'CANADA');
INSERT INTO artists VALUES (14, 'M', 'Kanye West', 'USA');
INSERT INTO artists VALUES (15, 'F', 'Britney Spears', 'USA');
INSERT INTO artists VALUES (16, 'F', 'Beyonce', 'USA');
INSERT INTO artists VALUES (17, 'F', 'Ariana Grande', 'USA');
INSERT INTO artists VALUES (18, 'M', 'Mac Miller', 'USA');
INSERT INTO artists VALUES (19, 'M', 'Playboi Carti', 'USA');
INSERT INTO artists VALUES (20, 'F', 'Carly Rae Jepsen', 'Canada');
INSERT INTO artists VALUES (21, 'M', 'Frank Ocean', 'USA');
INSERT INTO artists VALUES (22, 'M', 'The Strokes', 'USA');

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

INSERT INTO episodes VALUES (1, 1, '2020-05-07 13:00:00', '2020-05-07 14:00:00', 15, '20 Best Albums of 2020 So Far', '');
INSERT INTO episodes VALUES (2, 1, '2020-01-07 16:00:00', '2020-01-07 17:00:00', 60, 'Coronavirus Daily Update', '');
INSERT INTO episodes VALUES (3, 1, '2020-04-07 16:00:00', '2020-04-07 17:30:00', 45, 'Pride Month Programming', '');
INSERT INTO episodes VALUES (4, 2, '2020-05-08 10:00:00', '2020-05-08 11:00:00', 20, 'BLM and Police Abolition', '');
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

INSERT INTO collectives VALUES (1, 'Sports Collective', '');
INSERT INTO collectives VALUES (2, 'News Collective', '');
INSERT INTO collectives VALUES (3, 'Student Affairs Collective', '');
INSERT INTO collectives VALUES (4, 'Jazz Collective', '');
INSERT INTO collectives VALUES (5, 'Punk Collective', '');
INSERT INTO collectives VALUES (6, 'Classical Aficionados', '');
INSERT INTO collectives VALUES (7, 'Current Affairs Collective', '');
INSERT INTO collectives VALUES (8, 'LGBTQ2IA+ Collective', '');
INSERT INTO collectives VALUES (9, 'Asian Heritage Month Coalition', '');
INSERT INTO collectives VALUES (10, 'Science Collective', '');

INSERT INTO station_members VALUES (1, 'Patrick', 'Lee', 'BC', 'V6Y3Z6', 'He/Him/His', '8600 Jones Rd.', 'Richmond', 'pl0419@students.cs.ubc.ca', '6046499449', '6042311931', 'Sci-Fi', 'Programming');
INSERT INTO station_members VALUES (2, 'Alan', 'Smith', 'BC', 'V6H3Z5', 'He/Him/His', '123 Street', 'Vancouver', 'alansmithee@gmail.com', '6041234567', '7785164789', '', '');
INSERT INTO station_members VALUES (3, 'Mary', 'Smith', 'BC', 'V6T1J5', 'She/Her/Hers', '456 Boulevard', 'Vancouver', 'marysmith@gmail.com', '7781234567', '', '', '');
INSERT INTO station_members VALUES (4, 'Jane', 'Lee', 'BC', 'V6X1J5', 'She/Her/Hers', '2345 E 45 Ave', 'Vancouver', 'janelee@alumni.com', '7781234567', '6048795418', '', '');
INSERT INTO station_members VALUES (5,'Bob', 'Zhang', 'BC', 'V6T1J5', 'He/Him/His', '1234 E 41 Ave', 'Vancouver', 'zhangb@ubc.ca', '7781234567', '7785648735', 'Computer Science', '');
INSERT INTO station_members VALUES (6, 'Joe', 'Alain', 'BC', 'V6T1J5', 'They/Them', '455 Street', 'Vancouver', 'alainjh@ubc.ca', '7781234567', '', '', '');
INSERT INTO station_members VALUES (7, 'Charles', 'DeSantos', 'BC', 'V6T1J5', 'He/Him/His', '798 Street', 'Vancouver', 'cdesantos@ubc.ca', '7781234567', '', '', '');
INSERT INTO station_members VALUES (8, 'Anna', 'Johnston', 'BC', 'V6T1J5', 'She/Her/Hers', '8595 W 41 Ave', 'Vancouver', 'annaj1234@gmail.com', '7781234567', '6041587548', '', 'Audacity');
INSERT INTO station_members VALUES (9, 'Taylor', 'Corrico', 'BC', 'V6T1J5', 'She/Her/Hers', '4513 E 43 Ave', 'Vancouver', 'taylor4556@gmail.com', '7781234567', '', 'Podcasting', 'Photoshop');
INSERT INTO station_members VALUES (10, 'Ming', 'Xi', 'BC', 'V6T1J5', 'He/Him/His', '4552 Boulevard', 'Vancouver', 'mingxi452@gmail.com', '7781234567', '', '', '');
INSERT INTO station_members VALUES (11, 'Ferris', 'Lee', 'BC', 'V6Y3Z6', 'He/Him/His', '8600 Jones Rd.', 'Richmond', 'flee0229@students.cs.ubc.ca', '60474195498', '6048789548', 'Gardening', '');
INSERT INTO station_members VALUES (12, 'Alan', 'Soros', 'BC', 'V6X3Z5', 'He/Him/His', '123 Street', 'Vancouver', 'sorosa@gmail.com', '6041235719', '7785195846', '', '');
INSERT INTO station_members VALUES (13, 'Mary', 'Johnson', 'BC', 'V6Y1J5', 'She/Her/Hers', '456 Boulevard', 'Vancouver', 'maryj3727@gmail.com', '7781715787', '', '', '');
INSERT INTO station_members VALUES (14, 'Jane', 'McSmith', 'BC', 'V6X1J5', 'She/Her/Hers', '2345 E 45 Ave', 'Vancouver', 'mcsmithje@alumni.com', '7781234567', '', 'Feminist Studies', '');
INSERT INTO station_members VALUES (15,'Bill', 'Zhang', 'BC', 'V6T1J5', 'He/Him/His', '1234 E 41 Ave', 'Vancouver', 'billzhang0507@ubc.ca', '7781278495', '7785648157', '', 'PHP, SQL');
INSERT INTO station_members VALUES (16, 'Francois', 'Alain', 'BC', 'V6T1J5', 'They/Them', '455 Street', 'Vancouver', 'falain23@ubc.ca', '7781549877', '6045484845', '', '');
INSERT INTO station_members VALUES (17, 'Michael', 'DeSantos', 'BC', 'V6T2J7', 'He/Him/His', '798 Street', 'Vancouver', 'michdesantos@ubc.ca', '7781245739', '6048798785', '', '');
INSERT INTO station_members VALUES (18, 'Anna', 'Corrian', 'BC', 'V6T1J5', 'She/Her/Hers', '8595 W 41 Ave', 'Vancouver', 'annncorr1220@gmail.com', '7781235468', '', '', '');
INSERT INTO station_members VALUES (19, 'Taylor', 'Bennett', 'BC', 'V6X1J5', 'She/Her/Hers', '4513 E 43 Ave', 'Vancouver', 'taylorbennett21@gmail.com', '7789492122', '', 'Hip Hop', '');
INSERT INTO station_members VALUES (20, 'Xi', 'Yuan', 'BC', 'V6W1J5', 'She/Her/Hers', '4552 Boulevard', 'Vancouver', 'xiyuan0407@gmail.com', '7781454567', '', '', '');

INSERT INTO content_creators VALUES (1, 1, 1);
INSERT INTO content_creators VALUES (2, 0, 1);
INSERT INTO content_creators VALUES (3, 3, 1);
INSERT INTO content_creators VALUES (4, 3, 1);
INSERT INTO content_creators VALUES (5, 3, 1);
INSERT INTO content_creators VALUES (11, 1, 0);
INSERT INTO content_creators VALUES (12, 0, 0);
INSERT INTO content_creators VALUES (13, 2, 1);
INSERT INTO content_creators VALUES (14, 3, 1);
INSERT INTO content_creators VALUES (15, 3, 1);

INSERT INTO administrators VALUES (6, 'Station Manager', '2015-09-03');
INSERT INTO administrators VALUES (7, 'Technical Manager', '2016-09-07');
INSERT INTO administrators VALUES (8, 'Social Media Co-ordinator', '2017-08-23');
INSERT INTO administrators VALUES (9, 'Content Manager', '2015-08-23');
INSERT INTO administrators VALUES (10, 'Podcasting Co-ordinator', '2015-08-23');
INSERT INTO administrators VALUES (16, 'Station Assistant Manager', '2016-08-25');
INSERT INTO administrators VALUES (17, 'Music Library Curator', '2017-08-26');
INSERT INTO administrators VALUES (18, 'Digital Library Organizer', '2015-01-23');
INSERT INTO administrators VALUES (19, 'Technical Assistant', '2016-01-23');
INSERT INTO administrators VALUES (20, 'Editor-In-Chief', '2014-08-23');

INSERT INTO media VALUES (1, 'Shameika');
INSERT INTO media VALUES (2, 'forever');
INSERT INTO media VALUES (3, 'Without You');
INSERT INTO media VALUES (4, 'Never Come Back');
INSERT INTO media VALUES (5, 'CREEP YOU');
INSERT INTO media VALUES (6, 'Sun Models');
INSERT INTO media VALUES (7, 'If You\'re Too Shy (Let Me Know)');
INSERT INTO media VALUES (8, 'Sparks');
INSERT INTO media VALUES (9, 'Reality Check');
INSERT INTO media VALUES (10, 'DNA.');
INSERT INTO media VALUES (11, 'Genesis');
INSERT INTO media VALUES (12, 'I Wanna C U');
INSERT INTO media VALUES (13, 'Adult Diversion');
INSERT INTO media VALUES (14, 'Runaway');
INSERT INTO media VALUES (15, 'Toxic');
INSERT INTO media VALUES (16, 'Formation');
INSERT INTO media VALUES (17, 'thank u, next');
INSERT INTO media VALUES (18, 'Myth');
INSERT INTO media VALUES (19, 'Magnolia');
INSERT INTO media VALUES (20, 'Call Me Maybe');
INSERT INTO media VALUES (21, '1999');
INSERT INTO media VALUES (22, 'Follow God');
INSERT INTO media VALUES (23, 'No More Parties in LA');
INSERT INTO media VALUES (24, 'Money Trees');
INSERT INTO media VALUES (25, 'i');
INSERT INTO media VALUES (26, 'Self Care');
INSERT INTO media VALUES (27, 'Run Away With Me');
INSERT INTO media VALUES (28, 'Julien');
INSERT INTO media VALUES (29, 'Silver Soul');
INSERT INTO media VALUES (30, 'Long Time');
INSERT INTO media VALUES (31, 'Every Single Night');
INSERT INTO media VALUES (32, 'Charcoal Baby');
INSERT INTO media VALUES (33, 'Dreams Tonite');
INSERT INTO media VALUES (34, 'Drunk in Love');
INSERT INTO media VALUES (35, 'Love It If We Made It');
INSERT INTO media VALUES (36, 'Ace');
INSERT INTO media VALUES (37, 'Pyramids');
INSERT INTO media VALUES (38, 'Self Control');
INSERT INTO media VALUES (39, 'The Adults Are Talking');
INSERT INTO media VALUES (40, 'Last Nite');
INSERT INTO media VALUES (41, 'Juuling PSA');
INSERT INTO media VALUES (42, 'COVID-19 PSA');
INSERT INTO media VALUES (43, 'Social Distancing Measures');
INSERT INTO media VALUES (44, 'Hand-washing PSA');
INSERT INTO media VALUES (45, 'Community Programming PSA');
INSERT INTO media VALUES (46, 'Juuling PSA');
INSERT INTO media VALUES (47, 'COVID-19 PSA');
INSERT INTO media VALUES (48, 'Social Distancing Measures');
INSERT INTO media VALUES (49, 'Hand-washing PSA');
INSERT INTO media VALUES (50, 'Community Programming PSA');
INSERT INTO media VALUES (51, 'IKEA Ad');
INSERT INTO media VALUES (52, 'McDonalds Ad');
INSERT INTO media VALUES (53, 'KFC Ad');
INSERT INTO media VALUES (54, 'TD Ad');
INSERT INTO media VALUES (55, 'CIBC Ad');
INSERT INTO media VALUES (56, 'IKEA Ad');
INSERT INTO media VALUES (57, 'McDonalds Ad');
INSERT INTO media VALUES (58, 'KFC Ad');
INSERT INTO media VALUES (59, 'TD Ad');
INSERT INTO media VALUES (60, 'CIBC Ad');

INSERT INTO tracks VALUES (1, 'English', 'Art pop', 'Fetch the Bolt Cutters');
INSERT INTO tracks VALUES (2, 'English', 'Pop', 'how i\'m feeling now');
INSERT INTO tracks VALUES (3, 'English', 'Singer-songwriter', 'Set My Heart On Fire Immediately');
INSERT INTO tracks VALUES (4, 'English', 'Electronic', 'Suddenly');
INSERT INTO tracks VALUES (5, 'English', 'Experimental', 'PEACEFUL AS HELL');
INSERT INTO tracks VALUES (6, 'English', 'Electronic', 'In Return');
INSERT INTO tracks VALUES (7, 'English', 'Alternative', 'Notes On A Conditional Form');
INSERT INTO tracks VALUES (8, 'English', 'Alternative/Indie', 'Depression Cherry');
INSERT INTO tracks VALUES (9, 'English', 'Jazz Rap', 'Telefone');
INSERT INTO tracks VALUES (10, 'English', 'Hip-Hop/Rap', 'DAMN.');
INSERT INTO tracks VALUES (11, 'English', 'Experimental', 'Visions');
INSERT INTO tracks VALUES (12, 'English', 'R&B', 'Angel\'s Pulse');
INSERT INTO tracks VALUES (13, 'English', 'Indie rock', 'Alvvays');
INSERT INTO tracks VALUES (14, 'English', 'Rap', 'My Beautiful Dark Twisted Fantasy');
INSERT INTO tracks VALUES (15, 'English', 'Pop', 'In the Zone');
INSERT INTO tracks VALUES (16, 'English', 'R&B', 'Lemonade');
INSERT INTO tracks VALUES (17, 'English', 'Pop', 'thank u, next');
INSERT INTO tracks VALUES (18, 'English', 'Alternative/Indie', 'Bloom');
INSERT INTO tracks VALUES (19, 'English', 'Rap', 'Playboi Carti');
INSERT INTO tracks VALUES (20, 'English', 'Pop', 'Kiss');
INSERT INTO tracks VALUES (21, 'English', 'Pop', 'Charli');
INSERT INTO tracks VALUES (22, 'English', 'Rap', 'Jesus Is King');
INSERT INTO tracks VALUES (23, 'English', 'Rap', 'The Life of Pablo');
INSERT INTO tracks VALUES (24, 'English', 'Rap', 'Good Kid, Maad City');
INSERT INTO tracks VALUES (25, 'English', 'Rap', 'To Pimp a Butterfly');
INSERT INTO tracks VALUES (26, 'English', 'Rap', 'Swimming');
INSERT INTO tracks VALUES (27, 'English', 'Pop', 'Emotion');
INSERT INTO tracks VALUES (28, 'English', 'Pop', 'Dedicated');
INSERT INTO tracks VALUES (29, 'English', 'Alternative/Indie', 'Teen Dream');
INSERT INTO tracks VALUES (30, 'English', 'Rap', 'Die Lit');
INSERT INTO tracks VALUES (31, 'English', 'Singer-Songwriter', 'The Idler Wheel');
INSERT INTO tracks VALUES (32, 'English', 'R&B', 'Negro Swan');
INSERT INTO tracks VALUES (33, 'English', 'Indie Rock', 'Antisocialites');
INSERT INTO tracks VALUES (34, 'English', 'Pop', 'Beyonce');
INSERT INTO tracks VALUES (35, 'English', 'Alternative', 'A Brief Inquiry Into Online Relationships');
INSERT INTO tracks VALUES (36, 'English', 'Rap', 'Room 25');
INSERT INTO tracks VALUES (37, 'English', 'R&B', 'Channel Orange');
INSERT INTO tracks VALUES (38, 'English', 'R&B', 'Blonde');
INSERT INTO tracks VALUES (39, 'English', 'Rock', 'The New Abnormal');
INSERT INTO tracks VALUES (40, 'English', 'Rock', 'Is This It');

INSERT INTO psas VALUES (41, 'Government of Canada PSA for Juul-ing side effects');
INSERT INTO psas VALUES (42, 'Latest COVID-19 measures');
INSERT INTO psas VALUES (43, 'Best practices for social distancing');
INSERT INTO psas VALUES (44, 'Best practices for hand washing');
INSERT INTO psas VALUES (45, 'Community events ongoing and supporting local communities during COVID-19');
INSERT INTO psas VALUES (46, 'Government of Canada PSA for Juul-ing side effects');
INSERT INTO psas VALUES (47, 'Latest COVID-19 measures');
INSERT INTO psas VALUES (48, 'Best practices for social distancing');
INSERT INTO psas VALUES (49, 'Best practices for hand washing');
INSERT INTO psas VALUES (50, 'Community events ongoing and supporting local communities during COVID-19');

INSERT INTO ads VALUES (51, '');
INSERT INTO ads VALUES (52, '');
INSERT INTO ads VALUES (53, '');
INSERT INTO ads VALUES (54, '');
INSERT INTO ads VALUES (55, '');
INSERT INTO ads VALUES (56, '');
INSERT INTO ads VALUES (57, '');
INSERT INTO ads VALUES (58, 'Visit Richmond Auto Mall to take home your dream vehicle.');
INSERT INTO ads VALUES (59, 'For Canadian release ONLY.');
INSERT INTO ads VALUES (60, 'Visit Kijiji to find the rental that suits your needs.');

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
INSERT INTO performed_by VALUES (11, 11);
INSERT INTO performed_by VALUES (12, 12);
INSERT INTO performed_by VALUES (13, 13);
INSERT INTO performed_by VALUES (14, 14);
INSERT INTO performed_by VALUES (15, 15);
INSERT INTO performed_by VALUES (16, 16);
INSERT INTO performed_by VALUES (17, 17);
INSERT INTO performed_by VALUES (8, 18);
INSERT INTO performed_by VALUES (19, 19);
INSERT INTO performed_by VALUES (20, 20);
INSERT INTO performed_by VALUES (2, 21);
INSERT INTO performed_by VALUES (14, 22);
INSERT INTO performed_by VALUES (14, 23);
INSERT INTO performed_by VALUES (10, 24);
INSERT INTO performed_by VALUES (10, 25);
INSERT INTO performed_by VALUES (18, 26);
INSERT INTO performed_by VALUES (20, 27);
INSERT INTO performed_by VALUES (20, 28);
INSERT INTO performed_by VALUES (8, 29);
INSERT INTO performed_by VALUES (19, 30);
INSERT INTO performed_by VALUES (1, 31);
INSERT INTO performed_by VALUES (12, 32);
INSERT INTO performed_by VALUES (13, 33);
INSERT INTO performed_by VALUES (16, 34);
INSERT INTO performed_by VALUES (7, 35);
INSERT INTO performed_by VALUES (9, 36);
INSERT INTO performed_by VALUES (21, 37);
INSERT INTO performed_by VALUES (21, 38);
INSERT INTO performed_by VALUES (22, 39);
INSERT INTO performed_by VALUES (22, 40);

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
INSERT INTO station_owns_media VALUES (1, 21);
INSERT INTO station_owns_media VALUES (1, 22);
INSERT INTO station_owns_media VALUES (1, 23);
INSERT INTO station_owns_media VALUES (1, 24);
INSERT INTO station_owns_media VALUES (1, 25);
INSERT INTO station_owns_media VALUES (1, 26);
INSERT INTO station_owns_media VALUES (1, 27);
INSERT INTO station_owns_media VALUES (1, 28);
INSERT INTO station_owns_media VALUES (1, 29);
INSERT INTO station_owns_media VALUES (1, 30);
INSERT INTO station_owns_media VALUES (1, 41);
INSERT INTO station_owns_media VALUES (1, 42);
INSERT INTO station_owns_media VALUES (1, 43);
INSERT INTO station_owns_media VALUES (1, 44);
INSERT INTO station_owns_media VALUES (1, 45);
INSERT INTO station_owns_media VALUES (1, 46);
INSERT INTO station_owns_media VALUES (1, 47);
INSERT INTO station_owns_media VALUES (1, 48);
INSERT INTO station_owns_media VALUES (1, 49);
INSERT INTO station_owns_media VALUES (1, 50);
INSERT INTO station_owns_media VALUES (1, 51);
INSERT INTO station_owns_media VALUES (1, 52);
INSERT INTO station_owns_media VALUES (1, 53);
INSERT INTO station_owns_media VALUES (1, 54);
INSERT INTO station_owns_media VALUES (1, 55);
INSERT INTO station_owns_media VALUES (1, 56);
INSERT INTO station_owns_media VALUES (1, 57);
INSERT INTO station_owns_media VALUES (1, 58);
INSERT INTO station_owns_media VALUES (1, 59);
INSERT INTO station_owns_media VALUES (1, 60);

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
INSERT INTO show_has_episode VALUES (1, 2, 1);
INSERT INTO show_has_episode VALUES (1, 3, 1);
INSERT INTO show_has_episode VALUES (1, 4, 1);
INSERT INTO show_has_episode VALUES (1, 5, 1);
INSERT INTO show_has_episode VALUES (1, 6, 1);
INSERT INTO show_has_episode VALUES (1, 7, 1);
INSERT INTO show_has_episode VALUES (1, 8, 1);
INSERT INTO show_has_episode VALUES (1, 9, 1);
INSERT INTO show_has_episode VALUES (1, 10, 1);
INSERT INTO show_has_episode VALUES (2, 1, 1);
INSERT INTO show_has_episode VALUES (2, 2, 1);
INSERT INTO show_has_episode VALUES (2, 3, 1);
INSERT INTO show_has_episode VALUES (2, 4, 1);
INSERT INTO show_has_episode VALUES (2, 5, 1);
INSERT INTO show_has_episode VALUES (2, 6, 1);
INSERT INTO show_has_episode VALUES (2, 7, 1);
INSERT INTO show_has_episode VALUES (2, 8, 1);
INSERT INTO show_has_episode VALUES (2, 9, 1);
INSERT INTO show_has_episode VALUES (2, 10, 1);
INSERT INTO show_has_episode VALUES (3, 3, 4);
INSERT INTO show_has_episode VALUES (4, 4, 11);
INSERT INTO show_has_episode VALUES (5, 5, 16);
INSERT INTO show_has_episode VALUES (6, 1, 1);
INSERT INTO show_has_episode VALUES (7, 2, 3);
INSERT INTO show_has_episode VALUES (8, 3, 4);
INSERT INTO show_has_episode VALUES (9, 4, 11);
INSERT INTO show_has_episode VALUES (10, 5, 16);

INSERT INTO members_are_part_of_collectives VALUES (1, 1);
INSERT INTO members_are_part_of_collectives VALUES (2, 1);
INSERT INTO members_are_part_of_collectives VALUES (3, 2);
INSERT INTO members_are_part_of_collectives VALUES (4, 3);
INSERT INTO members_are_part_of_collectives VALUES (6, 3);
INSERT INTO members_are_part_of_collectives VALUES (7, 7);
INSERT INTO members_are_part_of_collectives VALUES (8, 7);
INSERT INTO members_are_part_of_collectives VALUES (9, 7);
INSERT INTO members_are_part_of_collectives VALUES (19, 7);
INSERT INTO members_are_part_of_collectives VALUES (18, 7);
INSERT INTO members_are_part_of_collectives VALUES (16, 10);
INSERT INTO members_are_part_of_collectives VALUES (15, 10);
INSERT INTO members_are_part_of_collectives VALUES (14, 10);









