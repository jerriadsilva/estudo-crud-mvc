<div class="card container-page text-white bg-dark mx-auto" style="max-width: 40rem;">
	<div class="card-header">Lista de usuários</div>
	<div class="card-text">
		<table class="table table-striped">
			<thead class="thead-dark">
				<tr>
					<th scope="col">#</th>
					<th scope="col">Nome</th>
					<th scope="col">Email</th>
					<th scope="col">Admin</th>
					<th scope="col"><a href="/usuario/novo">Cadastrar</a></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($Usuarios as $Usuario): ?>
				<tr>
					<th scope="row"><?=$Usuario->id;?></th>
					<td><?=$Usuario->nome;?></td>
					<td><?=$Usuario->email;?></td>
					<td><?=$Usuario->admin;?></td>
					<td><a href="/usuario/edita/<?=$Usuario->id;?>">Editar</a></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
