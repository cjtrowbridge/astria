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
  ,function(){
    $('body card:last-of-type input:first-of-type').focus();
  });
}
function Cardify(title,id){
  AddCard(
    title,
    $('#'+id).html()
  );
}
