-- MySQL dump 8.21
--
-- Host: localhost    Database: diskotek
---------------------------------------------------------
-- Server version	3.23.49

--
-- Table structure for table 'dok_album'
--

CREATE TABLE dok_album (
  id bigint(20) NOT NULL auto_increment,
  name varchar(255) NOT NULL default '',
  creation bigint(20) NOT NULL default '0',
  creation_uid bigint(20) NOT NULL default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY name (name),
  FULLTEXT KEY name_2 (name)
) TYPE=MyISAM;

--
-- Table structure for table 'dok_artist'
--

CREATE TABLE dok_artist (
  id bigint(20) NOT NULL auto_increment,
  name varchar(255) NOT NULL default '',
  creation bigint(20) NOT NULL default '0',
  creation_uid bigint(20) NOT NULL default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY name (name),
  FULLTEXT KEY name_2 (name)
) TYPE=MyISAM;

--
-- Table structure for table 'dok_rel_song_album'
--

CREATE TABLE dok_rel_song_album (
  song_id bigint(20) NOT NULL default '0',
  album_id bigint(20) NOT NULL default '0',
  track bigint(20) NOT NULL default '1',
  UNIQUE KEY album_id (album_id,track)
) TYPE=MyISAM;

--
-- Table structure for table 'dok_rel_song_artist'
--

CREATE TABLE dok_rel_song_artist (
  song_id bigint(20) NOT NULL default '0',
  artist_id bigint(20) NOT NULL default '0',
  link tinyint(3) unsigned NOT NULL default '0',
  UNIQUE KEY song_id (song_id,artist_id)
) TYPE=MyISAM;

--
-- Table structure for table 'dok_song'
--

CREATE TABLE dok_song (
  id bigint(20) NOT NULL auto_increment,
  name varchar(255) NOT NULL default '',
  length int(11) default NULL,
  creation bigint(20) NOT NULL default '0',
  creation_uid bigint(20) NOT NULL default '0',
  comment text NOT NULL,
  release year(4) NOT NULL default '0000',
  hits bigint(20) NOT NULL default '0',
  genre tinyint(3) unsigned NOT NULL default '14',
  PRIMARY KEY  (id),
  KEY hits (hits),
  FULLTEXT KEY name (name,comment)
) TYPE=MyISAM;

--
-- Table structure for table 'dok_user'
--

CREATE TABLE dok_user (
  id bigint(20) NOT NULL auto_increment,
  name varchar(255) NOT NULL default '',
  password varchar(255) NOT NULL default '',
  editor enum('1','0') NOT NULL default '0',
  admin enum('1','0') NOT NULL default '0',
  lang varchar(100) NOT NULL default '',
  theme varchar(255) NOT NULL default '',
  creation bigint(20) NOT NULL default '0',
  last_login bigint(20) NOT NULL default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY name (name)
) TYPE=MyISAM;

