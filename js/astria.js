function AstriaEditor(){
  var x = $('.AstriaEditor.ready');
  $(x).keyup(function(){
    $(this).mouseup(function() {
      $(this).css('border-color','red');
    })
    $(this).removeClass('ready');
    //var text = $(this).val();
    //var matches = text.match(/\n/g);
    //var breaks = matches ? matches.length : 0;
    //var padding = 5;
    //var height = breaks + padding;
    //$(this).css('height',height+'rem');
    $(this).css('height','800px');
    $(this).css('max-height','calc(100% - 3em)');
    
  });
  $(x).keyup();
  $(this).focus();
}

function AstriaToggleEditable(){
  $('.AstriaToggleEditableInputs').toggle();
  $('.AstriaToggleEditableLabels').toggle();
}
