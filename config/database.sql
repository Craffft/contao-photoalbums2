-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************


-- --------------------------------------------------------

-- 
-- Table `tl_photoalbums2_archive`
-- 

CREATE TABLE `tl_photoalbums2_archive` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `sorting` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `protected` char(1) NOT NULL default '',
  `users` blob NULL,
  `groups` blob NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Table `tl_photoalbums2_album`
-- 

CREATE TABLE `tl_photoalbums2_album` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `sorting` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `startdate` varchar(10) NOT NULL default '',
  `enddate` varchar(10) NOT NULL default '',
  `enddate` varchar(10) NOT NULL default '',
  `pictures` blob NULL,
  `pic_preview` varchar(255) NOT NULL default '',
  `pic_sort_check` varchar(64) NOT NULL default '',
  `pic_sort` blob NULL,
  `event` varchar(255) NOT NULL default '',
  `place` varchar(255) NOT NULL default '',
  `photographer` varchar(255) NOT NULL default '',
  `description` text NULL,
  `protected` char(1) NOT NULL default '',
  `users` blob NULL,
  `groups` blob NULL,
  `published` char(1) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Table `tl_layout`
-- 

CREATE TABLE `tl_layout` (
  `skipPhotoalbums2` char(1) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Table `tl_modules`
-- 

CREATE TABLE `tl_module` (
  `pa2Mode` varchar(64) NOT NULL default '',
  `pa2Archives` blob NULL,
  `pa2AlbumsTemplate` varchar(64) NOT NULL default '',
  `pa2PhotosTemplate` varchar(64) NOT NULL default '',
  `pa2NumberOfAlbums` smallint(5) unsigned NOT NULL default '0',
  `pa2NumberOfPhotos` smallint(5) unsigned NOT NULL default '0',
  `pa2AlbumsPerPage` smallint(5) unsigned NOT NULL default '5',
  `pa2PhotosPerPage` smallint(5) unsigned NOT NULL default '24',
  `pa2AlbumsPerRow` smallint(5) unsigned NOT NULL default '1',
  `pa2PhotosPerRow` smallint(5) unsigned NOT NULL default '2',
  `pa2AlbumsShowHeadline` char(1) NOT NULL default '',
  `pa2PhotosShowHeadline` char(1) NOT NULL default '',
  `pa2AlbumsShowTitle` char(1) NOT NULL default '',
  `pa2PhotosShowTitle` char(1) NOT NULL default '',
  `pa2AlbumsShowTeaser` char(1) NOT NULL default '',
  `pa2PhotosShowTeaser` char(1) NOT NULL default '',
  `pa2AlbumsImageSize` varchar(64) NOT NULL default '',
  `pa2PhotosImageSize` varchar(64) NOT NULL default '',
  `pa2AlbumsImageMargin` varchar(128) NOT NULL default '',
  `pa2PhotosImageMargin` varchar(128) NOT NULL default '',
  `pa2AlbumsMetaFields` blob NULL,
  `pa2PhotosMetaFields` blob NULL,
  `pa2DetailPage` varchar(10) NOT NULL default '',
  `pa2TimeFilter` char(1) NOT NULL default '',
  `pa2TimeFilterStart` varchar(64) NOT NULL default '',
  `pa2TimeFilterEnd` varchar(64) NOT NULL default '',
  `pa2Teaser` text NULL,
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Table `tl_user`
-- 

CREATE TABLE `tl_user` (
  `photoalbums` blob NULL,
  `photoalbump` blob NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Table `tl_user_group`
-- 

CREATE TABLE `tl_user_group` (
  `photoalbums` blob NULL,
  `photoalbump` blob NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
