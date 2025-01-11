<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (isset($_POST['send'])) {
    // Input sanitization and validation
    $name = filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $contactno = filter_input(INPUT_POST, 'contactno', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    if ($name && $email && $contactno && $message) {
        try {
            // Prepare and execute query
            $sql = "INSERT INTO tblcontactusquery (name, EmailId, ContactNumber, Message) VALUES (:name, :email, :contactno, :message)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':name', $name, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':contactno', $contactno, PDO::PARAM_STR);
            $query->bindParam(':message', $message, PDO::PARAM_STR);
            $query->execute();

            // Check if insertion was successful
            if ($dbh->lastInsertId()) {
                $msg = "Query Sent. We will contact you shortly.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        } catch (PDOException $e) {
            // Log error and show user-friendly message
            error_log($e->getMessage(), 3, 'logs/error.log');
            $error = "An unexpected error occurred. Please try again later.";
        }
    } else {
        $error = "Please fill in all fields with valid information.";
    }
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sahulat Car Rentals</title>

   <!--Bootstrap -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<link href="assets/css/slick.css" rel="stylesheet">
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<link href="assets/css/font-awesome.min.css" rel="stylesheet">
		<link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all" data-default-color="true" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" />
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

<!-- Page Header -->
<section class="page-header contactus_page">
    <div class="container">
        <div class="page-header_wrap">
            <div class="page-heading">
                <h1>Contact Us</h1>
            </div>
            <ul class="coustom-breadcrumb">
                <li><a href="index.php">Home</a></li>
                <li>Contact Us</li>
            </ul>
        </div>
    </div>
</section>

<!-- Contact Form Section -->
<section class="contact_us section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3>Get in touch using the form below</h3>
                <?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?></div><?php } 
                else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?></div><?php } ?>
                <div class="contact_form gray-bg">
                    <form method="post">
                        <div class="form-group">
                            <label>Full Name <span>*</span></label>
                            <input type="text" name="fullname" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email Address <span>*</span></label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Phone Number <span>*</span></label>
                            <input type="text" name="contactno" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Message <span>*</span></label>
                            <textarea name="message" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="send" class="btn">Send Message <i class="fa fa-angle-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <h3>Contact Details</h3>
                <div class="contact_detail">
                    <?php
                    $sql = "SELECT Address, EmailId, ContactNo FROM tblcontactusinfo";
                    $query = $dbh->prepare($sql);
                    $query->execute();
                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                    if ($query->rowCount() > 0) {
                        foreach ($results as $result) { ?>
                            <ul>
                                <li><i class="fa fa-map-marker"></i> <?php echo htmlentities($result->Address); ?></li>
                                <li><i class="fa fa-envelope"></i> <a href="mailto:<?php echo htmlentities($result->EmailId); ?>"> <?php echo htmlentities($result->EmailId); ?></a></li>
                                <li><i class="fa fa-phone"></i> <?php echo htmlentities($result->ContactNo); ?></li>
                            </ul>
                        <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Include Footer -->
<?php include('includes/footer.php'); ?>

<!-- Back to Top -->
<div id="back-top" class="back-top">
    <a href="#top"><i class="fa fa-angle-up"></i></a>
</div>

<!-- Include Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/interface.js"></script>

<style>/* Contact Us Section */
.contact_us {
    padding: 60px 0;
    background-color: #f5f5f5;
}

.contact_us h3 {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
    color: #333;
}

.contact_form {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.contact_form .form-group {
    margin-bottom: 15px;
}

.contact_form .form-group label {
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
    color: #333;
}

.contact_form .form-group input,
.contact_form .form-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    color: #333;
    background: #f9f9f9;
}

.contact_form .form-group input:focus,
.contact_form .form-group textarea:focus {
    border-color: red;
    outline: none;
}

.contact_form .form-group textarea {
    resize: none;
}

.contact_form .btn {
    background: red;
    color: #fff;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s;
    border-radius: 5px;
}

.contact_form .btn:hover {
    background: maroon;
}

/* Contact Details Section */
.contact_detail ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.contact_detail ul li {
    margin-bottom: 15px;
    font-size: 16px;
    color: #555;
}

.contact_detail ul li i {
    color:red;
    margin-right: 10px;
    font-size: 18px;
}
</style>
</body>
</html>
