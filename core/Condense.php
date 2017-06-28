<?php

function PickBest2($Array,$NumberOfSentences = 1){
  
  foreach($Array as $Element){
    //This prevents syndication duplicates from having extra weight.
    $RemainingElements[$Element] = $Element;
  }
  
  $Output = array();
  $UsedWords = array();
  
  for($i = 1; $i <= $NumberOfSentences; $i++){
    Event('Looking for best element '.$i);
    
    $This = array();
    
    //Get most important word
    $Words = FindMostImportantWords($RemainingElements,$UsedWords);
    $UsedWords[$Words[0]['Word']] = $Words[0]['Word'];
    
    //Get stories with that word
    $SubsetStories = ElementsContaining($RemainingElements,$Words[0]['Word']);
    
    //Get most important two words within this subset
    $Words = FindMostImportantWords($SubsetStories,$UsedWords);
    
    $This['keywords'] = $Words[0]['Word'].','.$Words[1]['Word'];
    
    //Ignore both words from now on
    $UsedWords[$Words[0]['Word']] = $Words[0]['Word'];
    $UsedWords[$Words[1]['Word']] = $Words[1]['Word'];
    
    //Get stories with both of those words
    $SubsetStories = ElementsContaining($RemainingElements,$Words[0]['Word']);
    $SubsetStories = ElementsContaining($RemainingElements,$Words[1]['Word']);
    
    //Pick Best from those stories
    $This['element'] = PickBest($SubsetStories);
    
    $Output[] = $This;
    
    Event('Done looking for best element '.$i);
    
  }
  
  return $Output;
}

function ElementsContaining($Array,$String){
  $String = strtolower($String);
  $Output = array();
  foreach($Array as $Element){
    $Test = strtolower($Element);
    if(strpos($Test,$String) !== false){
      $Output[] = $Element;
    }
    
  }
  return $Output;
}

function ElementsContainingArray($Elements,$Containing){
  $String = strtolower($String);
  $Output = array();
  foreach($Elements as $Element){
    $Test = strtolower($Element);
    $Keep = true;
    foreach($Containing as $Word){
      if(strpos($Test,$Word) == false){
        $Keep = false;
      }
    }
    if($Keep){
      $Output[] = $Element;
    }
  }
  return $Output;
}

function FindMostImportantWords($Array,$Ignore = array()){
  $Text = '';
  
  foreach($Array as $RawSentence){
    $Text.= ' '.$RawSentence;
  }
  
  //Make this case insensitive.
  $Text = strtolower($Text);
  
  //Remove any ignored words
  foreach($Ignore as $Bad){
    $Bad=strtolower($Bad);
    $Text = str_replace($Bad,'',$Text);
  }
  
  //Clean Up The Text
  $CleanText = CondenseCleanUp($Text);

  //Score Words
  $Scores = CondenseGetWordScores($CleanText);

  //Sort Words by Score
  CondenseSortByScore($Scores, 'Score');
  
  //TODO run an edit distance on these and consolidate similar words

  return $Scores;
}

function PickBest($Array,$NumberOfSentences = 1){
  //TODO remove from list of headlines each word which was a previous top word. ie. "trump" is most popular word in first headline, so remove any headlines with that word before calculating second headline.
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
  $Already=array();
  foreach($Array as $RawSentence){
    $CleanSentence = CondenseCleanUp($RawSentence);

    $ThisSentenceScore = 0;

    $SentenceScores = CondenseGetWordScores($CleanSentence);
    foreach($SentenceScores as $SentenceScore){
      $ThisSentenceScore += $SentenceScore['Score'] * CondenseFindScore($SentenceScore['Word'],$Scores);
    }
    if(!(isset($Already[md5($RawSentence)]))){
      $Already[md5($RawSentence)]=md5($RawSentence);
      $Sentences[] = array(
        'Raw'   => $RawSentence,
        'Clean' => $CleanSentence,
        'Score' => $ThisSentenceScore
      );
    }
  }

  CondenseSortByScore($Sentences);
  
  $Output=array();
  $NumberOfSentences-=1;
  for($i = 0; $i <= $NumberOfSentences; $i++){
    if(isset($Sentences[$i])){
     $Output[] = $Sentences[$i]['Raw'];
    }
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

  $Scores = array();
  //$Ignore = array('over','new','as','after','says','a','the','s','and','he','she','said','his','hers','with','in','is','of','that','have','not','on','to','be','it','like','only','was','from','more','many','so','who','also','would','an','at','doesn','t','i','for','think','be','function','var','com','if','in','has','been','or','are','you');
  
  $Ignore = file_get_contents('core/UnimportantWords.txt');
  $Ignore = explode(PHP_EOL,$Ignore);
  
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
  CondenseSortByScore($Scores, 'Score');
  return $Scores;
}

function CondenseSortByScore(&$arr, $col = 'Score', $dir = SORT_DESC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);
}




function Condensr($LongformText,$NumberOfSentences=1){
   $URL='https://api.condensr.io/v1';
  
  $Arguments=array(
    'LongformText'      => $LongformText,
    'NumberOfSentences' => $NumberOfSentences
  );
  
  //Set up cURL  
  $cURL = curl_init();
  curl_setopt($cURL,CURLOPT_URL, $URL);
  curl_setopt($cURL,CURLOPT_POST, count($Arguments));
  $URLArguments = http_build_query($Arguments);
  curl_setopt($cURL,CURLOPT_POSTFIELDS, $URLArguments);
  curl_setopt($cURL,CURLOPT_RETURNTRANSFER, true);
  
  //Run cURL and close it
  $Data = curl_exec($cURL);
  if(curl_exec($cURL) === false){
    echo 'Curl error: ' . curl_error($cURL);
  }
  curl_close($cURL);
  
  $Data=json_decode($Data,true);
  
  return $Data;
}
