Yii2 Articles
=============

Yii2 Articles to create, manage, and delete articles in a Yii2 site.

<h2>FEATURES</h2>

<ul>
  <li>Create, edit and delete articles</li>
  <li>Manage categories, subcategories and multiple categories</li>
  <li>Advanced Access Permission</li>
  <li>Approval</li>
  <li>Extra Field Management</li>
  <li>Hits</li>
  <li>SEO Optimization</li>
</ul>

<h2>CHANGELOG</h2>

<ul>
  <li>0.0.1 - Initial Realese</li>
</ul>

<h2>INSTALLATION USING COMPOSER</h2>

<h2>MANUAL INSTALLATION</h2>

Download and copy the file in your module folder

<h2>CONFIGURATION</h2>

Add in your configuration file, in modules section:

<pre>'modules' => [ 
...
	// Articles
	'articles' => [
		'class' => 'app\modules\articles\Articles',
	],
...
]</pre>

Create Database Tables

<pre>

CREATE TABLE IF NOT EXISTS `article_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `parent` int(11) DEFAULT '0',
  `published` smallint(6) NOT NULL DEFAULT '0',
  `access` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL,
  `params` text NOT NULL,
  `metadesc` text NOT NULL,
  `metakey` text NOT NULL,
  `language` char(7) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`published`,`access`),
  KEY `parent` (`parent`),
  KEY `ordering` (`ordering`),
  KEY `published` (`published`),
  KEY `access` (`access`),
  KEY `language` (`language`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `article_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `catid` int(11) NOT NULL,
  `published` smallint(6) NOT NULL DEFAULT '0',
  `introtext` mediumtext NOT NULL,
  `fulltext` mediumtext NOT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL,
  `modified_by` int(11) NOT NULL DEFAULT '0',
  `access` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL,
  `params` text NOT NULL,
  `metadesc` text NOT NULL,
  `metakey` text NOT NULL,
  `language` char(7) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item` (`published`,`access`),
  KEY `catid` (`catid`),
  KEY `created_by` (`created_by`),
  KEY `ordering` (`ordering`),
  KEY `hits` (`hits`),
  KEY `created` (`created`),
  KEY `language` (`language`),
  FULLTEXT KEY `search` (`title`,`introtext`,`fulltext`,`metadesc`,`metakey`),
  FULLTEXT KEY `title` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

</pre>

<h2>NEEDED</h2>

Yii2 Widget: https://github.com/kartik-v/yii2-widgets
