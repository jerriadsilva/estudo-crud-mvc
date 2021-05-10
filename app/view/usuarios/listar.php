<div class="row justify-content-center" >
	<div class="container" style="max-width: 40rem;">
		<div class="card container-page text-white bg-dark">
			<div class="card-header">Lista de usuários</div>
			<div class="card-text">
				<table class="table table-striped">
					<thead class="thead-dark">
						<tr>
							<th scope="col">#</th>
							<th scope="col">Name</th>
							<th scope="col">Email</th>
							<th scope="col">Admin</th>
							<th scope="col"><a href="/user/new">Add</a></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($UserList as $User): ?>
						<tr>
							<th scope="row"><?=$User->id;?></th>
							<td><?=$User->name;?></td>
							<td><?=$User->email;?></td>
							<td><?=$User->admin;?></td>
							<td><a href="/user/edit/<?=$User->id;?>">Editar</a></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
