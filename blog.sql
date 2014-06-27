/*
Create the `blog_members` table and drop if already exists.

Table contains all of the website's users
*/
DROP TABLE IF EXISTS `blog_members`;

CREATE TABLE `blog_members`
(

memberId INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
PRIMARY KEY(memberId),
email VARCHAR(100) NOT NULL,
username VARCHAR(15) NOT NULL,
password VARCHAR(256) NOT NULL,
role ENUM('User', 'Mod', 'Admin') NOT NULL,
created DATETIME NOT NULL,
lastActive DATETIME NOT NULL

)ENGINE=InnoDB;

/*
Create the `blog_settings` table and drop if already exists.

Table contains all website settings, i.e.
- Website Name
- Logo location
*/
DROP TABLE IF EXISTS `blog_settings`;

CREATE TABLE `blog_settings`
(

settingName VARCHAR(50) NOT NULL,
settingValue VARCHAR(250) NOT NULL,
lastEdited DATETIME NULL

)ENGINE=InnoDB;

/*
Create the `blog_posts` table and drop if already exists.

Table contains all posts made by admins.
*/
DROP TABLE IF EXISTS `blog_posts`;

CREATE TABLE `blog_posts`
(

postId INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
PRIMARY KEY(postId),
title VARCHAR(100) NOT NULL,
body TEXT NOT NULL,
created DATETIME NOT NULL,
lastEdited DATETIME NULL

)ENGINE=InnoDB;

/*
Create the `blog_comments` table and drop if already exists.

Table contains all comments made on a certain post.
*/
DROP TABLE IF EXISTS `blog_comments`;

CREATE TABLE `blog_comments`
(

commentId INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
PRIMARY KEY(commentId),
postId INT(10) UNSIGNED NOT NULL,
memberId INT(10) UNSIGNED NOT NULL,
comment TEXT NOT NULL,
created DATETIME NOT NULL,
lastEdited DATETIME NULL,
FOREIGN KEY(postId) REFERENCES blog_posts(postId),
FOREIGN KEY(memberId) REFERENCES blog_members(memberId)

)ENGINE=InnoDB;

/*
Create the `blog_images` table and drop if already exists.

Table contains all images submitted with an admin post.
*/
DROP TABLE IF EXISTS `blog_images`;

CREATE TABLE `blog_images`
(

imageId INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
PRIMARY KEY(imageId),
postId INT(10) UNSIGNED NOT NULL,
INDEX(postId),
extension VARCHAR(10) NOT NULL,
FOREIGN KEY(postId) REFERENCES blog_posts(postId)

)ENGINE=InnoDB;

/*
Create the `blog_likes` table and drop if already exists.

Table contains the likes on an admin post.
*/
DROP TABLE IF EXISTS `blog_likes`;

CREATE TABLE `blog_likes`
(

likeId INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
PRIMARY KEY(likeId),
postId INT(10) UNSIGNED NOT NULL,
memberId INT(10) UNSIGNED NOT NULL,
FOREIGN KEY(postId) REFERENCES blog_posts(postId),
FOREIGN KEY(memberId) REFERENCES blog_members(memberId)

)ENGINE=InnoDB;