function AddCard(
  title,
  text
){
  body = $('#bodyContainer');
  body.append(
'    <div class="card card-block">'+
'      <h4 class="card-title">'+title+' <button type="button" class="btn btn-link float-xs-right muted" onclick="$(this).parent().parent().fadeOut(100);">x</button></h4>'+
'      <p class="card-text">'+text+'</p>'+
'    </div>'
  );
  $('card:last-of-type input:first-of-type').focus();
}
function Cardify(title,id){
  AddCard(
    title,
    $('#'+id).html()
  );
}

function AstriaEditor(){
  var x = $('.AstriaEditor.ready');
  $(x).keyup(function(){
    $(this).mouseup(function() {
      $(this).css('border-color','red');
    })
    $(this).removeClass('ready');
    var text = $(this).val();
    var matches = text.match(/\n/g);
    var breaks = matches ? matches.length : 0;
    var padding = 5;
    var height = breaks + padding;
    $(this).css('height',height+'rem');
    $(this).focus();
  });
  $(x).keyup();
}
