<?php

function ArchitectEvents(){
  TemplateBootstrap4('Events - Architect' , 'ArchitectEventsBodyCallback();');
}
function ArchitectEventsBodyCallback(){
  global $EVENTS;
  ?><h1><a href="/architect">Architect</a> / <a href="/architect/events">Events</a></h1>
  <?php
  pd($EVENTS);
}
