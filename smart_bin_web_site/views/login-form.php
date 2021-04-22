<center>
<form id="form" action="login.php" method="POST" onsubmit="javascript:return validate('form');">
	<fieldset>
	<div class="form-group">
	 <input autofocus class="form-control" type="email" placeholder="E-Mail" name="email">
	 <br><br>
	 <input class="form-control" type="password" placeholder="Password" name="password">
	 <br><br>
	</div>
	<div class="form-group">
	  <button class="btn btn-default" type="submit">
                <span aria-hidden="true" class="glyphicon glyphicon-log-in"></span>
                Log In
      </button><br><br>
	</div>
	</fieldset>
</form>

<div>
    or <a href="register.php">Register</a>
</div>
</center>