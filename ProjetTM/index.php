<?php

session_start();

$titre="Index du site";

require_once("includes/identifiants.php");
require_once("includes/debut.php");

?>

  <style>

     /* Add a gray background color and some padding to the footer */
     footer {
       background-color: #f2f2f2;
       padding: 25px;
     }

   .carousel-inner img {
       width: 3000px; /* Set width to 100% */
       max-height: 	1000px;
   }

	 html,body{height:100%;}
	 .carousel,.item,.active{height:100%;}
	 .carousel-inner{height:100%;}
	 .carousel-captionheight{100%;}
   }

	 .contact-form{
	     background: #fff;
	     margin-top: 10%;
	     margin-bottom: 5%;
	     width: 70%;
	 }
	 .contact-form .form-control{
	     border-radius:1rem;
	 }
	 .contact-image{
	     text-align: center;
	 }
	 .contact-image img{
	     border-radius: 6rem;
	     width: 11%;
	     margin-top: -3%;
	     transform: rotate(29deg);
	 }
	 .contact-form form{
	     padding: 14%;
	 }
	 .contact-form form .row{
	     margin-bottom: -7%;
	 }
	 .contact-form h3{
	     margin-bottom: 8%;
	     margin-top: -10%;
	     text-align: center;
	     color: #0062cc;
	 }
	 .contact-form .btnContact {
	     width: 50%;
	     border: none;
	     border-radius: 1rem;
	     padding: 1.5%;
	     background: #dc3545;
	     font-weight: 600;
	     color: #fff;
	     cursor: pointer;
	 }
	 .btnContactSubmit
	 {
	     width: 50%;
	     border-radius: 1rem;
	     padding: 1.5%;
	     color: #fff;
	     background-color: #0062cc;
	     border: none;
	     cursor: pointer;
	 }

}

  </style>


<body>

	<?php
		require_once("includes/menu.php");
	?>

	<div id="carousel" class="carousel slide">
	    <div id="portfolio">
	        <div class="row">


	                <div id="carouselPortfolio" class="carousel slide" data-ride="carousel">
	                    <!-- Indicators -->
	                    <ol class="carousel-indicators">
	                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
	                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
	                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
	                    </ol>

	                    <div class="carousel-inner" role="listbox">

	                        <!-- Images -->
	                        <div class="carousel-item active">
	                            <img class="d-block img-fluid" src="https://www.parismou.org/sites/default/files/corona_0.jpeg" alt="First slide">
	                            <div class="carousel-caption">
	                                <h3>Offer</h3>
	                            </div>
	                        </div>

	                        <div class="carousel-item">
	                            <img class="d-block img-fluid" src="https://www.parismou.org/sites/default/files/corona_0.jpeg" alt="Second slide">
	                            <div class="carousel-caption">
	                                <h3>Receive</h3>
	                            </div>
	                        </div>

	                        <div class="carousel-item">
	                            <img class="d-block img-fluid" src="https://www.parismou.org/sites/default/files/corona_0.jpeg" alt="Third slide">
	                            <div class="carousel-caption">
	                                <h3>Make a change</h3>
	                            </div>
	                        </div>

	                    </div>
	                    <!--Carousel Inner-->
	                </div>
	                <!--Carousel Example Slides Only-->

	                <!-- Controls -->
	                <a class="carousel-control-prev" href="#carouselPortfolio" role="button" data-slide="prev">

	                    <span class="sr-only">Previous</span></a>

	                <a class="carousel-control-next" href="#carouselPortfolio" role="button" data-slide="next">

	                    <span class="sr-only">Next</span></a>

	            </div>
	            <!--column-->

	</div>

</br></br></br></br></br></br>



	<div class="container text-center">
	  <h3>What We Do</h3><br>
	  <div class="row">
	    <div class="col-md-4">
	      <img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image">
	      <p>Contactez nos généreux donateurs</p>
	    </div>
	    <div class="col-md-4">
	      <img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image">
	      <p>Ajouter vos mask</p>
	    </div>
			<div class="col-md-4">
				<img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image">
				 <p>Ajouter vos mask</p>
				<p></p>
			</div>
	  </div>
	</div>

</br></br></br></br></br></br><br>
	<div class="container contact-form">
	            <div class="contact-image">
	                <img src="img/contactus.png" alt="rocket_contact"/>
	            </div>
	            <form method="post">
	                <h3>Contact us</h3>
	               <div class="row">
	                    <div class="col-md-6">
	                        <div class="form-group">
	                            <input type="text" name="txtName" class="form-control" placeholder="Your Name *" value="" />
	                        </div>
	                        <div class="form-group">
	                            <input type="text" name="txtEmail" class="form-control" placeholder="Your Email *" value="" />
	                        </div>
	                        <div class="form-group">
	                            <input type="text" name="txtPhone" class="form-control" placeholder="Your Phone Number *" value="" />
	                        </div>
	                        <div class="form-group">
	                            <input type="submit" name="btnSubmit" class="btnContact" value="Send Message" />
	                        </div>
	                    </div>
	                    <div class="col-md-6">
	                        <div class="form-group">
	                            <textarea name="txtMsg" class="form-control" placeholder="Your Message *" style="width: 100%; height: 150px;"></textarea>
	                        </div>
	                    </div>
	                </div>
	            </form>
	</div>


</body>

<?php
echo '<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>';
require_once("includes/footer.php");
?>

</html>
