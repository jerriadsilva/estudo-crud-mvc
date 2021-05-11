<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarNavDropdown">
		<ul class="navbar-nav">
			<li class="nav-item active">
			<a class="nav-link" href="/">Home</a>
			</li>
			<?php if($LoggedUser->admin()): ?>
			<li class="nav-item">
				<a class="nav-link" href="/users">Usuarios</a>
			</li><?php endif; ?>
			<?php if(!empty($LoggedUser->id())):?>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?=$LoggedUser->name();?>
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
					<a class="dropdown-item" href="/logout">Logout</a>
				</div>
			</li>
			<?php else: ?>
			<li class="nav-item active">
				<a class="nav-link" href="/login">Login</a>
			</li><?php endif; ?>
		</ul>
	</div>
</nav>