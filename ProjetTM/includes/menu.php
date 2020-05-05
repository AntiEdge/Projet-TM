	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	  <a class="navbar-brand" href="#"><img src=".\styles\corona.jpg" width="30" height="30" alt=""></a>
	  <a class="navbar-brand" href="index.php">Acceuil</a>
	  <a class="navbar-brand" href="membre.php">Membre</a>
	  <a class="navbar-brand" href="map.php">Map</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>

	  <div class="collapse navbar-collapse" id="navbarSupportedContent">
	    <ul class="navbar-nav ml-md-auto">
	    	<?php
	    		if (isset($_SESSION['id'])) {
	    	?>
	    		<li class="nav-item">
	    			<a class="nav-link" href="" data-toggle="modal" data-target="#exampleModal">Mon profil</a>
	    		</li>
	    			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Paramètres</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <li>
	    						<a href="profil.php">Mon profil</a>
	    					</li>
	    					<li>
	    						<a href="editer-profil.php">Modifier mon profil</a>
	    					</li>
	    					<li>
	    						<a href="demandes-amis.php">Demande d'ami</a>
	    					</li>
	    					<li>
	    						<a href="tchat.php">Tchat</a>
	    					</li>
	    					<li>
	    						<a href="deconnexion.php">Se déconnecter</a>
	    					</li>
					      </div>
					    </div>
					  </div>
					</div>
	    	<?php
	    	}
	    	else
	    	{
	    	?>
	    		<li class="nav-item">
	    			<a class="nav-link" href="register.php">S'inscrire</a>
	    		</li>
		    	<li class="nav-item">
		    		<a class="nav-link" href="connexion.php">Se connecter</a>
		    	</li>
	    	<?php
	    	}
	    	?>
	    </ul>
	  </div>
	</nav>

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
