# php-bookmarks

Online web bookmark storage using PHP / MySQL

## JS Bookmarklet
```
javascript:location.href='https://my.scibx.org/phpstudies/php-bookmarks/add_bookmarklet.php?get_URL='+encodeURIComponent(location.href)+'&get_title='+encodeURIComponent((document.getSelection().length>0?document.getSelection().substring(0,100):document.title).replace(/\'/g,''));
```

## Create SQL Tables
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
    PRIMARY KEY(entryID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
```
### Table `bookmarks_auth`
```
CREATE TABLE bookmarks_auth (
    userID int(11) NOT NULL AUTO_INCREMENT, 
    username varchar(15) NOT NULL UNIQUE, 
    password varchar(255) NOT NULL, 
    screenname varchar(45) NOT NULL, 
    PRIMARY KEY(userID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
```

## Credit(s)
### [kafene/netscape-bookmark-parser](https://github.com/kafene/netscape-bookmark-parser)
This software uses a PHP library that parses Netscape format bookmark files, released under MIT license.
