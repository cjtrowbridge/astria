<?php

function ArchitectEditView(){
  Hook('Template Body','ArchitectEditViewBodyCallback');
  TemplateBootstrap2('Architect'); 
}
function ArchitectEditViewBodyCallback(){
  
  if(is_integer(path(2))){
    //look up by id
    
  }else{
    //try looking up by slug
  }
}
