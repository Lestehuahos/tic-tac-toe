<div clas="row">
	<form action="/account/save" method="post">
			<div class="form-group">
			<label for="exampleInputName">Логин</label>
			<input type="text" name="name" class="form-control" id="exampleInputName">
		</div>
		<div class="form-group">
			<label for="exampleInputName">Пароль</label>
			<input type="password" name="password" class="form-control" id="exampleInputName">
		</div>
		<div class="form-group">
			<label for="exampleInputName">Пароль еще раз</label>
			<input type="password" name="confirm_password" class="form-control" id="exampleInputName">
		</div>
		<div class="form-group">
			<label for="exampleInputName">E-mail</label>
			<input type="text" name="email" class="form-control" id="exampleInputName">
		</div>
		<div class="form-group">
			<label for="exampleInputName">Пол</label>
			<input type="text" name="sex" class="form-control" id="exampleInputName">
		</div>
		<button type="submit" name="send" class="btn btn-default">Войти</button>
		<button type="submit" name="cancel" class="btn btn-default">Отмена</button>
	</form>
</div>