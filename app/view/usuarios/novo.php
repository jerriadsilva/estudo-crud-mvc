<div class="card container-page text-white bg-dark mx-auto" style="max-width: 40rem;">
	<div class="card-header" style="border:none"><?= $titulo ?></div>
	<div class="card-text" style="padding:0 10px 10px">
		<form action="<?=$FormAction;?>" method="POST">
			<div class="form-group">
				<label for="exampleInputEmail1">Nome</label>
				<input type="text" class="form-control" name="name" placeholder="Seu Nome" value="<?=$User->name??'';?>">
		</div>
		<div class="form-group">
				<label for="exampleInputEmail1">Endereço de email</label>
				<input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Seu email" value="<?=$User->email??'';?>">
				<small id="emailHelp" class="form-text text-muted">Nunca vamos compartilhar seu email, com ninguém.</small>
		</div>
		<div class="form-group">
				<label for="exampleInputPassword1">Senha</label>
				<input type="password" class="form-control" name="passwd" id="exampleInputPassword1" placeholder="Nova senha">
		</div><?php if($User->admin??true): ?>
		<div class="form-group form-check">
				<input type="checkbox" class="form-check-input" <?=($User->admin??false)?'checked="checked"':'';?> name="admin" id="exampleCheck1">
				<label class="form-check-label" for="exampleCheck1">Administrador</label>
		</div><?php endif; ?>
		<button type="submit" class="btn btn-primary">Enviar</button>
		</form>
	</div>
</div>
