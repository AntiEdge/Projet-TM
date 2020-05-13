<?php

session_start();

$titre="Index du site";

require_once("includes/identifiants.php");
require_once("includes/debut.php");

?>

  <style>

  body {background-color: white;}

    .carousel {

      margin: 0 auto;

    }

	 .contact-form{
	     margin-top: 10%;
	     margin-bottom: 5%;
	     width: 1000%;
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
	     width: 100%;
	     border: none;
	     border-radius: 1rem;
	     padding: 1.5%;
	     background: #5791ff;
	     font-weight: 600;
	     color: #fff;
	     cursor: pointer;
	 }
	 .btnContactSubmit
	 {
	     width: 100%;
	     border-radius: 1rem;
	     padding: 1.5%;
	     color: #fff;
	     background-color: #0062cc;
	     border: none;
	     cursor: pointer;
	 }

   img.rounded-corners {
  border-radius: 30px;
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
	                            <img class="img-fluid mx-auto" src="img/exchangecovid19.jpg" alt="First slide">
	                            <div class="carousel-caption">
	                            </div>
	                        </div>

	                        <div class="carousel-item">
	                            <img class="img-fluid mx-auto" src="img/covid19.jpeg" alt="Second slide">
	                            <div class="carousel-caption">
	                                <h3>Get in touch</h3>
	                            </div>
	                        </div>

	                        <div class="carousel-item">
	                            <img class="img-fluid mx-auto" src="img/covid19.jpeg" alt="Third slide">
	                            <div class="carousel-caption">
	                                <h3>Fight it together </h3>
	                            </div>
	                        </div>

	                    </div>


                     <a class="carousel-control-prev" href="#carouselPortfolio" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                         <span class="sr-only">Previous</span>
                        </a>

                     <a class="carousel-control-next" href="#carouselPortfolio" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                         <span class="sr-only">Next</span>
                        </a>
	                </div>
	            </div>
	            <!--column-->

	</div>

</br></br></br></br></br></br>



	<div class="container text-center">
	  <h3>What We Do</h3><br>
	  <div class="row">
	    <div class="col-md-4">

	      <img src="img/givemask.png" id="givemask" class="img-responsive rounded-corners" style="width:59%" alt="Image">

	    </div>
	    <div class="col-md-4">
	      <img src="img/requestmask.png" id="requestmask" class="img-responsive rounded-corners" style="width:60%" alt="Image">
	    </div>
			<div class="col-md-4">
				<img src="img/getconnected.png" id="contactmask" class="img-responsive rounded-corners" style="width:60%" alt="Image">
				<p></p>
			</div>
	  </div>
	</div>

  <script>
  $(function () {
  $("#givemask").click(function () {

    var id = <?php if(!isset($_SESSION['id'])){
      echo 1;
    }
    else {

      echo 0;

    }?>

    if(id == 0){

        window.location.replace("maskofferform.php");

      } else{

        window.location.replace("register.php");

      }

  });
});

$(function () {
$("#requestmask").click(function () {
  window.location.replace("map.php");
});
});

$(function () {
$("#contactmask").click(function () {
  window.location.replace("membre.php");
});
});

  </script>

</br></br></br></br></br></br><br>


	<div class="container contact-form">
	            <div class="contact-image">
	                <img src="img/contactus.png"/>
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
