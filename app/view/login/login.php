<div class="row justify-content-center" >
	<div class="container container-page" style="max-width: 20rem;margin-top: 1rem;">
		<!--<div class="title-page">
			<div class="card-header">Login</div>
		</div> -->
		<form method="POST" action="/login">
			<fieldset>
				<div class="form-group">
					<label for="email" class="form-label mt-4">Email address</label>
					<input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Email">
				</div>
				<div class="form-group">
					<label for="passwd" class="form-label mt-4">Password</label>
					<input type="password" class="form-control" id="passwd" name="passwd" placeholder="Password">
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</fieldset>
		</form>
	</div>
</div>
