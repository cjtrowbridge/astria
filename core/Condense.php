<?php

function PickBest($Array,$NumberOfSentences = 1){
  $Text = '';
  foreach($Array as $RawSentence){
    $Text.= ' '.$RawSentence;
  }
  
  //Clean Up The Text
  $CleanText = CondenseCleanUp($Text);

  //Score Words
  $Scores = CondenseGetWordScores($CleanText);

  //Score Words
  CondenseSortByScore($Scores, 'Score');
  
  $Sentences = array();
  foreach($Array as $RawSentence){
    $CleanSentence = CondenseCleanUp($RawSentence);

    $ThisSentenceScore = 0;

    $SentenceScores = CondenseGetWordScores($CleanSentence);
    foreach($SentenceScores as $SentenceScore){
      $ThisSentenceScore += $SentenceScore['Score'] * CondenseFindScore($SentenceScore['Word'],$Scores);
    }

    $Sentences[$CleanSentence] = array(
      'Raw'   => $RawSentence,
      'Clean' => $CleanSentence,
      'Score' => $ThisSentenceScore
    );
  }

  CondenseSortByScore($Sentences);
  
  $Output=array();
  $NumberOfSentences-=1;
  for($i = 0; $i <= $NumberOfSentences; $i++){
   $Output[] = $Sentences[$i]['Raw'];
  }

  return $Output;
}

function Condense($Text,$NumberOfSentences = 1){
  //Clean Up The Text
  $CleanText = CondenseCleanUp($Text);

  //Score Words
  $Scores = CondenseGetWordScores($CleanText);

  //Score Words
  CondenseSortByScore($Scores, 'Score');

  //Parse Sentences. Punctuation is irrelevant for the purposes of this algorithm.
  $RawSentences = $Text;
  $RawSentences = str_replace('?','.',$RawSentences);
  $RawSentences = str_replace('!','.',$RawSentences);
  $RawSentences = explode('.',$RawSentences);
  $Sentences = array();
  foreach($RawSentences as $RawSentence){
    $CleanSentence = CondenseCleanUp($RawSentence);

    $ThisSentenceScore = 0;

    $SentenceScores = CondenseGetWordScores($CleanSentence);
    foreach($SentenceScores as $SentenceScore){
      $ThisSentenceScore += $SentenceScore['Score'] * CondenseFindScore($SentenceScore['Word'],$Scores);
    }

    $Sentences[] = array(
      'Raw'   => $RawSentence,
      'Clean' => $CleanSentence,
      'Score' => $ThisSentenceScore
    );
  }

  CondenseSortByScore($Sentences);

  $Output='';
  $NumberOfSentences-=1;
  for($i = 0; $i <= $NumberOfSentences; $i++){
   $Output = trim($Output).' '.$Sentences[$i]['Raw'];
  }

  return $Output;
  //return $Sentences[0]['Raw'];
}

function CondenseCleanUp($Text){
  $CleanText = strtolower($Text);
  $CleanText = str_replace("'","",$CleanText);
  $CleanText = str_replace('"','',$CleanText);
  $CleanText = trim($CleanText);
  return $CleanText;
}

function CondenseFindScore($Word,$Scores){
  foreach($Scores as $Score){
    if($Score['Word']==$Word){
      return $Score['Score'];
    }
  }
  return 0;
}

function CondenseGetWordScores($Text){
  $WordScores = array_count_values(str_word_count($Text, 1));

  $Scores  = array();
  $Ignore=array('a','the','s','and','he','she','said','his','hers','with','in','is','of','that','have','not','on','to','be','it','like','only','was','from','more','many','so','who','also','would','an','at','doesn','t','i','for','think','be','function','var','com','if','in','has','been','or','are','you');

  foreach($WordScores as $Word => $Score){
    if(!(
      in_array($Word,$Ignore)||
      strlen($Word)<=1
    )){
      $Scores[] = array(
        'Word'  => $Word,
        'Score' => $Score
      );
    }
  }
  return $Scores;
}

function CondenseSortByScore(&$arr, $col = 'Score', $dir = SORT_DESC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);
}
