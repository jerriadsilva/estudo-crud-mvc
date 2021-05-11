<div class="card container-page text-white bg-dark mx-auto" style="max-width: 40rem;">
	<div class="card-header" style="border:none"><?= $titulo ?></div>
	<div class="card-text" style="padding:0 10px 10px">
		<form action="<?=$FormAction;?>" method="POST">
			<div class="form-group">
				<label for="nome">Nome</label>
				<input type="text" class="form-control" name="nome", id="nome" placeholder="Nome do produto" value="<?=$Produto->nome??'';?>">
			</div>
			<div class="form-group">
				<label for="descricao" class="form-label mt-4">Descrição</label>
				<textarea class="form-control" id="descricao" name="descricao" rows="3" placeholder="Descrição do produto"><?=$Produto->descricao??'';?></textarea>
			</div>
			<div class="form-group">
				<label for="valor">Valor</label>
				<input type="text" class="form-control" name="valor" id="valor" placeholder="$0,00" value="<?=$Produto->valor??'';?>">
			</div>
			<button type="submit" class="btn btn-primary">Enviar</button>
		</form>
	</div>
</div>
