-- MySQL dump 9.07
--
-- Host: localhost    Database: diskotek
---------------------------------------------------------
-- Server version	4.0.10-gamma-log

--
-- Table structure for table 'album'
--

CREATE TABLE album (
  id bigint(20) NOT NULL auto_increment,
  name varchar(255) NOT NULL default '',
  creation bigint(20) NOT NULL default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY name (name)
) TYPE=MyISAM;

--
-- Table structure for table 'artist'
--

CREATE TABLE artist (
  id bigint(20) NOT NULL auto_increment,
  name varchar(255) NOT NULL default '',
  creation bigint(20) NOT NULL default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY name (name)
) TYPE=MyISAM;

--
-- Table structure for table 'rel_song_album'
--

CREATE TABLE rel_song_album (
  song_id bigint(20) NOT NULL default '0',
  album_id bigint(20) NOT NULL default '0',
  track bigint(20) NOT NULL default '1',
  UNIQUE KEY song_id (song_id,album_id,track)
) TYPE=MyISAM;

--
-- Table structure for table 'rel_song_artist'
--

CREATE TABLE rel_song_artist (
  song_id bigint(20) NOT NULL default '0',
  artist_id bigint(20) NOT NULL default '0',
  UNIQUE KEY song_id (song_id,artist_id)
) TYPE=MyISAM;

--
-- Table structure for table 'song'
--

CREATE TABLE song (
  id bigint(20) NOT NULL auto_increment,
  name varchar(255) NOT NULL default '',
  length int(11) default NULL,
  creation bigint(20) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

