function AddCard(
  title,
  text
){
  body = $('#bodyContainer');
  body.append(
'    <div class="card card-block">'+
'      <h4 class="card-title">'+title+'</h4>'+
'      <p class="card-text">'+text+'</p>'+
'      <button type="button" class="btn btn-outline-danger" onclick="$(this).parent().fadeOut(100);">Cancel</button>'+
'      <button type="button" class="btn btn-success">Continue</button>'+
'    </div>'
  );
}
