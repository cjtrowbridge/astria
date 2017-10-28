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

    CREATE TABLE `Cache` (
      `CacheID` int(11) NOT NULL,
      `Hash` varchar(32) NOT NULL,
      `Content` text,
      `Created` datetime NOT NULL,
      `Expires` datetime DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf16;

    CREATE TABLE `UserGroup` (
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
      `Text` VARCHAR(255) DEFAULT NULL,
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
      `SignupDate` datetime DEFAULT NULL,
      `IsAstriaAdmin` BOOLEAN NOT NULL DEFAULT FALSE,
      `IsWaiting` BOOLEAN NOT NULL DEFAULT TRUE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf16;

    CREATE TABLE `UserGroupMembership` (
      `UserMembershipID` int(11) NOT NULL,
      `UserID` int(11) NOT NULL,
      `GroupID` int(11) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf16 ROW_FORMAT=COMPACT;
    
    ALTER TABLE `Cache` ADD PRIMARY KEY (`CacheID`), ADD UNIQUE KEY `Hash` (`Hash`) USING BTREE;
    ALTER TABLE `Group` ADD PRIMARY KEY (`GroupID`), ADD KEY `ParentID` (`ParentID`);
    ALTER TABLE `Permission` ADD PRIMARY KEY (`PermissionID`);
    ALTER TABLE `Permission` MODIFY `PermissionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
    ALTER TABLE `Permission` ADD UNIQUE(`UserID`,`Text`);
    ALTER TABLE `Session` ADD PRIMARY KEY (`SessionID`);
    ALTER TABLE `User` ADD PRIMARY KEY (`UserID`);
    ALTER TABLE `UserMembership` ADD PRIMARY KEY (`UserMembershipID`), ADD KEY `UserID` (`UserID`,`GroupID`);
    ALTER TABLE `Cache` MODIFY `CacheID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
    ALTER TABLE `Group` MODIFY `GroupID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
    ALTER TABLE `Session` MODIFY `SessionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
    ALTER TABLE `User` MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
    ALTER TABLE `UserMembership` MODIFY `UserMembershipID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  ";
  
  //TODO make Query support multiquery or make this work for multiple database types
  global $ASTRIA;
  mysqli_multi_query($ASTRIA['databases']['astria']['resource'],$SQL);
}
