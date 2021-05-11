
<div class="text-center">
<?php foreach($Produtos as $Produto):?>
	<div class="card text-white bg-secondary mb-3 product text-left" style="width: 20rem;">
		<div class="card-header"><?=$Produto->name;?></div>
		<div class="card-body">
			<p class="card-text"><?=$Produto->description;?></p>
		</div>
		<h6 class="d-block text-right pr-3">R$<?=$Produto->price;?></h6>
	<?php if($LoggedUser->id): ?>
		<button class="btn btn-lg btn-primary" type="button">Comprar</button><?php endif; ?>
	</div>
<?php endforeach;?>
</div>