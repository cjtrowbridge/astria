function AddCard(
  title,
  text
){
  body = $('#bodyContainer');
  body.append(
'    <div class="card card-block">'+
'      <h4 class="card-title">'+title+' <button type="button" class="btn btn-link float-xs-right muted" onclick="$(this).parent().fadeOut(100);">x</button></h4>'+
'      <p class="card-text">'+text+'</p>'+
'    </div>'
  );
}
