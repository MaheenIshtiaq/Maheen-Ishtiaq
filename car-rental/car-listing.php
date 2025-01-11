<?php 
session_start();
include('includes/config.php');
error_reporting(0);
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="">
<meta name="description" content="">
<title>Sahulat Car Rentals - Car Listing</title>
<!--Bootstrap -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<!--Custom Style -->
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<!--OWL Carousel slider-->
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<!--slick-slider -->
<link href="assets/css/slick.css" rel="stylesheet">
<!--bootstrap-slider -->
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<!--FontAwesome Font Style -->
<link href="assets/css/font-awesome.min.css" rel="stylesheet">
<!-- SWITCHER -->
<link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all" data-default-color="true" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" />
<!-- Fav and touch icons -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
</head>
<body>

<!-- Start Switcher -->
<?php include('includes/colorswitcher.php');?>
<!-- /Switcher -->  

<!--Header--> 
<?php include('includes/header.php');?>
<!-- /Header --> 

<!--Page Header-->
<section class="page-header listing_page">
  <div class="container">
    <div class="page-header_wrap">
      <div class="page-heading">
        <h1>Car Listing</h1>
      </div>
      <ul class="coustom-breadcrumb">
        <li><a href="#">Home</a></li>
        <li>Car Listing</li>
      </ul>
    </div>
  </div>
  <!-- Dark Overlay-->
  <div class="dark-overlay"></div>
</section>
<!-- /Page Header--> 

<!--Listing-->
<section class="listing-page">
  <div class="container">
    <div class="row">
      <div class="col-md-9 col-md-push-3">
        <div class="result-sorting-wrapper">
          <div class="sorting-count">
            <?php 
            //Query for Listing count
            $sql = "SELECT id from tblvehicles";
            $query = $dbh -> prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            $cnt = count($results);
            ?>
            <p><span><?php echo htmlentities($cnt);?> Listings</span></p>
          </div>
        </div>

        <?php 
        $sql = "SELECT tblvehicles.*, tblbrands.BrandName, tblbrands.id as bid FROM tblvehicles 
                JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand";
        $query = $dbh -> prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        if($query->rowCount() > 0) {
            foreach($results as $result) {  
        ?>
        <div class="product-listing-m gray-bg">
          <div class="product-listing-img">
            <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1);?>" class="img-responsive" alt="Image" />
          </div>
          <div class="product-listing-content">
            <h5><a href="vehical-details.php?vhid=<?php echo htmlentities($result->id);?>">
              <?php echo htmlentities($result->BrandName);?> , <?php echo htmlentities($result->VehiclesTitle);?>
            </a></h5>
            <p class="list-price">PKR <?php echo htmlentities($result->PricePerDay);?> Per Day</p>
            <ul>
              <li><i class="fa fa-user" aria-hidden="true"></i><?php echo htmlentities($result->SeatingCapacity);?> seats</li>
              <li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo htmlentities($result->ModelYear);?> model</li>
              <li><i class="fa fa-car" aria-hidden="true"></i><?php echo htmlentities($result->FuelType);?></li>
            </ul>
            <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id);?>" class="btn">
              View Details <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
            </a>
          </div>
        </div>
        <?php }} ?>
      </div>

      <!-- Side-Bar-->
      <aside class="col-md-3 col-md-pull-9">
        <div class="sidebar_widget">
          <div class="widget_heading">
            <h5><i class="fa fa-filter" aria-hidden="true"></i> Find Your Car</h5>
          </div>
          <div class="sidebar_filter">
            <form action="search-carresult.php" method="post">
              <div class="form-group select">
                <select class="form-control" name="brand">
                  <option>Select Brand</option>
                  <?php 
                  $sql = "SELECT * from tblbrands";
                  $query = $dbh -> prepare($sql);
                  $query->execute();
                  $results = $query->fetchAll(PDO::FETCH_OBJ);
                  foreach($results as $result) {  
                  ?>  
                  <option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->BrandName);?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group select">
                <select class="form-control" name="fueltype">
                  <option>Select Fuel Type</option>
                  <option value="Petrol">Petrol</option>
                  <option value="Diesel">Diesel</option>
                  <option value="CNG">CNG</option>
                </select>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-block">
                  <i class="fa fa-search" aria-hidden="true"></i> Search Car
                </button>
              </div>
            </form>
          </div>
        </div>

        <div class="sidebar_widget">
          <div class="widget_heading">
            <h5><i class="fa fa-car" aria-hidden="true"></i> Recently Listed Cars</h5>
          </div>
          <div class="recent_addedcars">
            <ul>
              <?php 
              $sql = "SELECT tblvehicles.*, tblbrands.BrandName, tblbrands.id as bid FROM tblvehicles 
                      JOIN tblbrands ON tblbrands.id = tblvehicles.VehiclesBrand ORDER BY id DESC LIMIT 4";
              $query = $dbh -> prepare($sql);
              $query->execute();
              $results = $query->fetchAll(PDO::FETCH_OBJ);
              foreach($results as $result) {  
              ?>
              <li class="gray-bg">
                <div class="recent_post_img">
                  <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id);?>">
                    <img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1);?>" alt="image">
                  </a>
                </div>
                <div class="recent_post_title">
                  <a href="vehical-details.php?vhid=<?php echo htmlentities($result->id);?>">
                    <?php echo htmlentities($result->BrandName);?> , <?php echo htmlentities($result->VehiclesTitle);?>
                  </a>
                  <p class="widget_price">PKR <?php echo htmlentities($result->PricePerDay);?> Per Day</p>
                </div>
              </li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </aside>
      <!--/Side-Bar--> 
    </div>
  </div>
</section>
<!-- /Listing--> 

<!--Footer -->
<?php include('includes/footer.php');?>
<!-- /Footer--> 

<!--Back to top-->
<div id="back-top" class="back-top">
  <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
</div>
<!--/Back to top--> 

<!--Login-Form -->
<?php include('includes/login.php');?>
<!--/Login-Form --> 

<!--Register-Form -->
<?php include('includes/registration.php');?>
<!--/Register-Form --> 

<!--Forgot-password-Form -->
<?php include('includes/forgotpassword.php');?>

<!-- Scripts --> 
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 
<!--Switcher-->
<script src="assets/switcher/js/switcher.js"></script>
<!--bootstrap-slider-JS--> 
<script src="assets/js/bootstrap-slider.min.js"></script> 
<!--Slider-JS--> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>

<style>/* General Styles */
body {
    font-family: 'Lato', sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
}

a {
    color: inherit;
    text-decoration: none;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
}

/* Page Header */
.page-header {
    background: url('assets/images/cover-1 (1).jpg') no-repeat center center;
    background-size: cover;
    padding: 0px 0;
    color: #fff;
}

.page-header .page-heading h1 {
    font-size: 36px;
    margin-bottom: 10px;
}

.page-header .coustom-breadcrumb {
    list-style: none;
    padding: 0;
}

.page-header .coustom-breadcrumb li {
    display: inline;
    margin-right: 5px;
}

.page-header .coustom-breadcrumb li a {
    color: #fff;
    text-decoration: none;
}

/* Listing Section */
.listing-page {
    padding: 40px 0;
}

.product-listing-m {
    background-color: #fff;
    padding: 20px;
    margin-bottom: 30px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    display: flex;
}

.product-listing-img {
    width: 30%;
}

.product-listing-img img {
    width: 100%;
    height: auto;
    border-radius: 4px;
}

.product-listing-content {
    width: 70%;
    padding-left: 20px;
}

.product-listing-content h5 {
    font-size: 22px;
    color: #333;
}

.product-listing-content .list-price {
    font-size: 18px;
    font-weight: bold;
    color:red;
    margin: 10px 0;
}

.product-listing-content ul {
    list-style: none;
    padding: 0;
}

.product-listing-content ul li {
    font-size: 14px;
    color: #666;
    margin-bottom: 5px;
}

.product-listing-content .btn {
    display: inline-block;
    background-color: red;
    color: #fff;
    padding: 10px 20px;
    font-size: 16px;
    text-transform: uppercase;
    border-radius: 4px;
    margin-top: 10px;
    transition: background-color 0.3s;
}

.product-listing-content .btn:hover {
    background-color: maroon;
}

/* Sidebar Styles */
.sidebar_widget {
    background-color: #fff;
    padding: 20px;
    margin-bottom: 30px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.widget_heading h5 {
    font-size: 18px;
    color: #333;
    margin-bottom: 15px;
}

.sidebar_filter .form-group {
    margin-bottom: 15px;
}

.sidebar_filter select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.sidebar_filter .btn {
    width: 100%;
    background-color:red;
    color: #fff;
    padding: 12px;
    font-size: 16px;
    border-radius: 4px;
    transition: background-color 0.3s;
}

.sidebar_filter .btn:hover {
    background-color:maroon;
}

/* Recent Cars */
.recent_addedcars ul {
    list-style: none;
    padding: 0;
}

.recent_addedcars li {
    background-color: #f9f9f9;
    margin-bottom: 15px;
    padding: 10px;
    display: flex;
}

.recent_addedcars .recent_post_img {
    width: 30%;
}

.recent_addedcars .recent_post_img img {
    width: 100%;
    height: auto;
    border-radius: 4px;
}

.recent_addedcars .recent_post_title {
    width: 70%;
    padding-left: 15px;
}

.recent_addedcars .recent_post_title a {
    font-size: 16px;
    color: #333;
}

.recent_addedcars .widget_price {
    font-size: 14px;
    font-weight: bold;
    color: red;
}

/* Responsive Styles */
@media (max-width: 991px) {
    .product-listing-m {
        flex-direction: column;
    }

    .product-listing-img, .product-listing-content {
        width: 100%;
        padding-left: 0;
    }
}

@media (max-width: 768px) {
    .page-header {
        text-align: center;
        padding: 40px 0;
    }

    .product-listing-content .btn {
        width: auto;
    }
}

@media (max-width: 480px) {
    .recent_addedcars li {
        flex-direction: column;
    }

    .recent_addedcars .recent_post_img, .recent_addedcars .recent_post_title {
        width: 100%;
        padding-left: 0;
    }
}

/* General Car Listing Layout */
.car-listing {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: space-between;
    margin-top: 30px;
}

.car-listing .car-item {
    background-color: #fff;
    width: calc(33.333% - 20px); /* 3 items per row with gaps */
    border-radius: 5px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s, box-shadow 0.3s;
}

.car-listing .car-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

/* Car Item Image */
.car-item .car-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

/* Car Item Info */
.car-item .car-info {
    padding: 15px;
}

.car-item .car-info h6 {
    font-size: 18px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

.car-item .car-info p {
    font-size: 14px;
    color: #666;
    margin-bottom: 15px;
}

.car-item .car-info .car-price {
    font-size: 16px;
    font-weight: bold;
    color: #e53935;
}

/* Similar Cars Section */
.similar-cars {
    margin-top: 30px;
}

.similar-cars .car-listing {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: space-between;
}

.similar-cars .car-item {
    background-color: #fff;
    width: calc(33.333% - 20px); /* 3 items per row with gaps */
    border-radius: 5px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.similar-cars .car-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

/* Car Image in Similar Cars */
.similar-cars .car-item .car-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

/* Car Info in Similar Cars */
.similar-cars .car-item .car-info {
    padding: 15px;
}

.similar-cars .car-item .car-info h6 {
    font-size: 18px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

.similar-cars .car-item .car-info p {
    font-size: 14px;
    color: #666;
    margin-bottom: 15px;
}

.similar-cars .car-item .car-info .car-price {
    font-size: 16px;
    font-weight: bold;
    color: #e53935;
}

/* Mobile Layout Adjustments */
@media (max-width: 768px) {
    .car-listing .car-item {
        width: calc(50% - 20px); /* 2 items per row on smaller screens */
    }

    .similar-cars .car-item {
        width: calc(50% - 20px); /* 2 items per row for similar cars */
    }

    .similar-cars .car-item .car-image {
        height: 180px;
    }
}

@media (max-width: 480px) {
    .car-listing .car-item {
        width: 100%; /* 1 item per row on very small screens */
    }

    .similar-cars .car-item {
        width: 100%; /* 1 item per row for similar cars on small screens */
    }

    .similar-cars .car-item .car-image {
        height: 150px;
    }
}

</style>

</body>
</html>
