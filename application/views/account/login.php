<div clas="row">
	<div class = "login">
		<div class ="title"><h3>Авторизация</h3></div>
		<form action="/account/authorization" method="post">
				<div class="form-group">
				<label for="exampleInputName">Логин</label>
				<input type="text" name="name" class="form-control" id="exampleInputName">
			</div>
			<div class="form-group">
				<label for="exampleInputName">Пароль</label>
				<input type="password" name="password" class="form-control" id="exampleInputName">
			</div>
			<button type="submit" name="send" class="btn btn-default">Войти</button>
			<button type="submit" name="cancel" class="btn btn-default">Отмена</button>
		</form>
	</div>
</div>