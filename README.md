# php-bookmarks

This is a web bookmark storage application run in a LAMP server environment.  

It is inspired by Delicious and Mar.gar.in(<http://mar.gar.in>).  

You can build a self-hosted online bookmark storage with this application.  

The application provides Import/Export features to back up your bookmarks in both XML and Netscape HTML format. Most modern web browsers are capable of importing Netscape HTML bookmark files.  

## A Sample Installation
<https://my.scibx.org/scibx-boomarks/>

## JS Bookmarklet
```
javascript:location.href='https://my.scibx.org/scibx-bookmarks/add_bookmarklet.php?get_URL='+encodeURIComponent(location.href)+'&get_title='+encodeURIComponent((document.getSelection().length>0?document.getSelection().substring(0,100):document.title).replace(/\'/g,''));
```

## Requirements
Packages `php-curl`, `php-mbstring`, `php-xml` are required.

## Installation
### Adjust the permission of a few directories
```
$ chmod 0707 config/ backups/
```

### Run the installer
1. Open `https://{$your-server}/php-bookmarks/setup.php` page via your web browser.
2. Enter all the necessary information in the form.
3. Click 'Submit' to run the installer.

## SQL Table Info.
### Table `bookmarks_entries`
```
CREATE TABLE bookmarks_entries (
    entryID int(11) NOT NULL AUTO_INCREMENT, 
    URL text NOT NULL, 
    title text NOT NULL, 
    note text, 
    tags varchar(255), 
    category varchar(45), 
    subcategory varchar(45), 
    time varchar(19), 
    publicity varchar(15) NOT NULL, 
    pinned tinyint NOT NULL DEFAULT '0', 
    PRIMARY KEY(entryID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;
```
### Table `bookmarks_auth`
```
CREATE TABLE bookmarks_auth (
    userID int(11) NOT NULL AUTO_INCREMENT, 
    username varchar(15) NOT NULL UNIQUE, 
    password varchar(255) NOT NULL, 
    screenname varchar(45) NOT NULL, 
    PRIMARY KEY(userID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## Credit(s)
### [kafene/netscape-bookmark-parser](https://github.com/kafene/netscape-bookmark-parser)
This software uses a PHP library, released under MIT license, that parses Netscape format bookmark files.

### [Simple HTML DOM Parser](https://simplehtmldom.sourceforge.io)
This software uses this library, released under MIT license, to retrieve the title of a web page link.

## License Info.
This repository is open to public under GPL v2 license.
