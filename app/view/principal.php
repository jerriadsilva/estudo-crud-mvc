
<div class="text-center">
<?php foreach($Produtos as $Produto):?>
	<div class="card text-white bg-secondary mb-3 product text-left" style="width: 20rem;">
		<div class="card-header"><?=$Produto->nome;?></div>
		<div class="card-body">
			<p class="card-text"><?=$Produto->descricao;?></p>
		</div>
		<h6 class="d-block text-right pr-3">R$<?=$Produto->valor;?></h6>
	<?php if($UsuarioLogado->id): ?>
		<button class="btn btn-lg btn-primary" type="button">Comprar</button><?php endif; ?>
	</div>
<?php endforeach;?>
</div>