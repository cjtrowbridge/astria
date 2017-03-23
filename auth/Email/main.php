<?php 

Hook('Attempt Auth','AttemptEmailAuth();');
function AttemptEmailAuth(){
  include_once('core/Session.php');
  include_once('auth/Google/autoload.php');
  global $ASTRIA;
  Event('Starting Email Auth Check');

}

Hook('Auth Login Options','authEmailCallback();');
function authEmailCallback(){
  global $ASTRIA;
  ?>
    <div class="row">
      <div class="col-xs-12 col-md-6">
        <h4>Log In By Email</h4>
        <div class="container">
          <form>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
              </div>
            </div>
            <div class="form-group row">
              <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Log In</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="col-xs-12 col-md-6">
        <h4>Sign Up By Email</h4>
        <div class="container">
          <form>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
              </div>
            </div>
            <div class="form-group row">
              <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Sign Up</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    
  <?php
}
