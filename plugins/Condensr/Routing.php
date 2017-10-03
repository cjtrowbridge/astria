<?php

function PickBest3($Array,$NumberOfSentences = 1){
  include_once('Helpers.php');
  hPickBest3($Array,$NumberOfSentences);
}

function PickBest2($Array,$NumberOfSentences = 1){
  include_once('Helpers.php');
  hPickBest2($Array,$NumberOfSentences);
}

function GetStories($Headlines){
  include_once('Helpers.php');
  hGetStories($Headlines);
}

function ElementsContaining($Array,$String){
  include_once('Helpers.php');
  hElementsContaining($Array,$String);
}

function ElementsContainingArray($Elements,$Containing){
  include_once('Helpers.php');
  hElementsContainingArray($Elements,$Containing);
}

function FindMostImportantWords($Array,$Ignore = array()){
  include_once('Helpers.php');
  hFindMostImportantWords($Array,$Ignore);
}

function ScoreWords($Text){
  include_once('Helpers.php');
  hScoreWords($Text);
}

function PickBest($Array,$NumberOfSentences = 1){
  include_once('Helpers.php');
  hPickBest($Array,$NumberOfSentences);
}

function Condense($Text,$NumberOfSentences = 1){
  include_once('Helpers.php');
  hCondense($Text,$NumberOfSentences);
}

function CondenseCleanUp($Text){
  include_once('Helpers.php');
  hCondenseCleanUp($Text);
}

function CondenseFindScore($Word,$Scores){
  include_once('Helpers.php');
  hCondenseFindScore($Word,$Scores);
}

function CondenseGetWordScores($Text){
  include_once('Helpers.php');
  hCondenseGetWordScores($Text);
}

function CondenseSortByScore(&$arr, $col = 'Score', $dir = SORT_DESC) {
  include_once('Helpers.php');
  hCondenseSortByScore(&$arr, $col, $dir);
}

function Condensr($LongformText,$NumberOfSentences=1){
  include_once('Helpers.php');
  hCondensr($LongformText,$NumberOfSentences);
}
