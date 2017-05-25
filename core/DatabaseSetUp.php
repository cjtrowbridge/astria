<?php

function DatabaseSetUp(){
  global $ASTRIA;
  if(!(isset($ASTRIA['app']))){
    include_once('config.php');
  }
  include_once('core/MakeSureDBConnected.php');
  MakeSureDBConnected('astria');
  $SQL="
    SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";

    CREATE TABLE IF NOT EXISTS `Feed` (
      `FeedID` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `FeedSourceID` int(11) NOT NULL,
      `FeedCategoryID` int(11) NOT NULL,
      `FeedParserID` int(11) DEFAULT NULL,
      `FeedURL` varchar(255) NOT NULL,
      `FeedName` varchar(255) DEFAULT NULL,
      `FeedDescription` text,
      `FeedLogoURL` varchar(255) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    
    CREATE TABLE IF NOT EXISTS `FeedFetch` (
      `FetchID` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `FeedID` int(11) NOT NULL,
      `URL` varchar(255) NOT NULL,
      `Arguments` text NULL,
      `FetchTime` datetime NOT NULL,
      `Duration` decimal(10,4) NOT NULL,
      `Content` text,
      `ContentLength` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf16;
    
    CREATE TABLE IF NOT EXISTS `FeedCategory` (
      `FeedCategoryID` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
      `Name` varchar(255) NOT NULL,
      `Description` text NOT NULL,
      `Path` varchar(255) NOT NULL,
      `ParentID` int(11) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

    
    CREATE TABLE `Cache` (
      `CacheID` int(11) NOT NULL,
      `Hash` varchar(32) NOT NULL,
      `Content` text,
      `Created` datetime NOT NULL,
      `Expires` datetime DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf16;

    CREATE TABLE `Group` (
      `GroupID` int(11) NOT NULL,
      `ParentID` int(11) DEFAULT NULL,
      `Name` varchar(255) NOT NULL,
      `Description` text
    ) ENGINE=InnoDB DEFAULT CHARSET=utf16;

    CREATE TABLE `Permission` (
      `PermissionID` int(11) NOT NULL,
      `ViewID` int(11) NOT NULL,
      `UserID` int(11) DEFAULT NULL,
      `GroupID` int(11) DEFAULT NULL,
      `InsertedTime` datetime NOT NULL,
      `InsertedUser` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf16;

    CREATE TABLE `Session` (
      `SessionID` int(11) NOT NULL,
      `SessionHash` varchar(32) NOT NULL,
      `UserID` int(11) DEFAULT NULL,
      `UserAgentHash` varchar(32) NOT NULL,
      `UserAgent` text NOT NULL,
      `UserIPHash` varchar(32) NOT NULL,
      `UserIP` text NOT NULL,
      `Expires` datetime NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf16;

    CREATE TABLE `User` (
      `UserID` int(11) NOT NULL,
      `Email` varchar(255) NOT NULL,
      `Password` varchar(255) DEFAULT NULL,
      `PasswordExpires` datetime DEFAULT NULL,
      `EmailConfirmationHash` varchar(255) DEFAULT NULL,
      `Photo` text,
      `FirstName` text,
      `LastName` text,
      `LastLogin` datetime DEFAULT NULL,
      `SignupDate` datetime DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf16;

    CREATE TABLE `UserMembership` (
      `UserMembershipID` int(11) NOT NULL,
      `UserID` int(11) NOT NULL,
      `GroupID` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf16 ROW_FORMAT=COMPACT;
    
    CREATE TABLE `ACE` (
      `ACEID` int(11) NOT NULL,
      `Hash` varchar(255) NOT NULL,
      `Code` text NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf16;

    ALTER TABLE `ACE` ADD PRIMARY KEY (`ACEID`), ADD KEY `Hash` (`Hash`(191));
    ALTER TABLE `ACE` MODIFY `ACEID` int(11) NOT NULL AUTO_INCREMENT;
    ALTER TABLE `Cache` ADD PRIMARY KEY (`CacheID`), ADD UNIQUE KEY `Hash` (`Hash`) USING BTREE;
    ALTER TABLE `Group` ADD PRIMARY KEY (`GroupID`), ADD KEY `ParentID` (`ParentID`);
    ALTER TABLE `Permission` ADD PRIMARY KEY (`PermissionID`), ADD KEY `UserID` (`UserID`,`GroupID`,`ViewID`) USING BTREE;
    ALTER TABLE `Session` ADD PRIMARY KEY (`SessionID`);
    ALTER TABLE `User` ADD PRIMARY KEY (`UserID`);
    ALTER TABLE `UserMembership` ADD PRIMARY KEY (`UserMembershipID`), ADD KEY `UserID` (`UserID`,`GroupID`);
    ALTER TABLE `Cache` MODIFY `CacheID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
    ALTER TABLE `Group` MODIFY `GroupID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
    ALTER TABLE `Permission` MODIFY `PermissionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
    ALTER TABLE `Session` MODIFY `SessionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
    ALTER TABLE `User` MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
    ALTER TABLE `UserMembership` MODIFY `UserMembershipID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  ";
  
  //TODO make Query support multiquery or make this work for multiple database types
  global $ASTRIA;
  mysqli_multi_query($ASTRIA['databases']['astria']['resource'],$SQL);
}
