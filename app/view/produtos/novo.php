<div class="card container-page text-white bg-dark mx-auto" style="max-width: 40rem;">
	<div class="card-header" style="border:none"><?= $titulo ?></div>
	<div class="card-text" style="padding:0 10px 10px">
		<form action="<?=$FormAction;?>" method="POST">
			<div class="form-group">
				<label for="name">Nome</label>
				<input type="text" class="form-control" name="name", id="name" placeholder="Nome do produto" value="<?=$Produto->name??'';?>">
			</div>
			<div class="form-group">
				<label for="description" class="form-label mt-4">Descrição</label>
				<textarea class="form-control" id="description" name="description" rows="3" placeholder="Descrição do produto"><?=$Produto->description??'';?></textarea>
			</div>
			<div class="form-group">
				<label for="price">Valor</label>
				<input type="text" class="form-control" name="price" id="price" placeholder="$0,00" value="<?=$Produto->price??'';?>">
			</div>
			<button type="submit" class="btn btn-primary">Enviar</button>
		</form>
	</div>
</div>
