<div class="card container-page text-white bg-dark mx-auto" style="max-width: 30rem;">
	<div class="card-header" style="border:none"><?= $titulo ?></div>
	<div class="card-text" style="padding:0 10px 10px">
		<form action="/admin<?=$FormAction;?>" method="POST">
			<div class="form-group">
				<label for="nome">Nome</label>
				<input type="text" class="form-control" name="nome" id="nome" placeholder="Nome completo" value="<?=$Usuario->nome??'';?>">
			</div>
			<div class="form-group">
					<label for="email">Endereço de email</label>
					<input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Email" value="<?=$Usuario->email??'';?>">
			</div>
			<div class="form-group w-50">
					<label for="passwd">Senha</label>
					<input type="password" class="form-control" name="passwd" id="passwd" placeholder="Nova senha">
			</div><?php if($UsuarioLogado->admin??true): ?>
			<div class="form-group form-check">
					<input type="checkbox" class="form-check-input" <?=($Usuario->admin??false)?'checked="checked"':'';?> name="admin" id="exampleCheck1">
					<label class="form-check-label" for="exampleCheck1">Administrador</label>
			</div><?php endif; ?>
			<input type="hidden" name="hash_form" value="<?=$Formulario::GeraHashForm();?>">
			<button type="submit" class="btn btn-primary mt-3">Enviar</button>
		</form>
	</div>
</div>
