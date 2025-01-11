<?php
if(isset($_POST['emailsubscibe']))
{
    $subscriberemail = $_POST['subscriberemail'];
    $sql = "SELECT SubscriberEmail FROM tblsubscribers WHERE SubscriberEmail=:subscriberemail";
    $query = $dbh -> prepare($sql);
    $query-> bindParam(':subscriberemail', $subscriberemail, PDO::PARAM_STR);
    $query-> execute();
    $results = $query -> fetchAll(PDO::FETCH_OBJ);
    $cnt = 1;
    if($query -> rowCount() > 0)
    {
        echo "<script>alert('Already Subscribed.');</script>";
    }
    else{
        $sql = "INSERT INTO tblsubscribers(SubscriberEmail) VALUES(:subscriberemail)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':subscriberemail', $subscriberemail, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if($lastInsertId)
        {
            echo "<script>alert('Subscribed successfully.');</script>";
        }
        else
        {
            echo "<script>alert('Something went wrong. Please try again');</script>";
        }
    }
}
?>

<footer>
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h6>About Us</h6>
                    <ul>
                        <li><a href="page.php?type=aboutus">About Us</a></li>
                        <li><a href="page.php?type=faqs">FAQs</a></li>
                        <li><a href="page.php?type=privacy">Privacy</a></li>
                        <li><a href="page.php?type=terms">Terms of use</a></li>
                        <li><a href="admin/">Admin Login</a></li>
                    </ul>
                </div>

                <div class="col-md-4">
                    <h6>Subscribe to Our Newsletter</h6>
                    <div class="newsletter-form">
                        <form method="post">
                            <div class="form-group">
                                <input type="email" name="subscriberemail" class="form-control newsletter-input" required placeholder="Enter your email" />
                            </div>
                            <button type="submit" name="emailsubscibe" class="btn btn-block">Subscribe <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></button>
                        </form>
                        <p class="subscribed-text">*We send great deals and the latest auto news every week to our subscribers.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <h6>Follow Us</h6>
                    <ul class="social-links">
                        <li><a href="#"><i class="fab fa-facebook-f"></i> Facebook</a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i> Twitter</a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-pull-6">
                    <p class="copy-right">Copyright &copy; 2024 Sahulat Car Rentals.</p>
                </div>
                <div class="col-md-6 text-md-right">
                    <ul class="footer-links">
                        <li><a href="page.php?type=aboutus">About Us</a></li>
                        <li><a href="page.php?type=faqs">FAQs</a></li>
                        <li><a href="page.php?type=privacy">Privacy</a></li>
                        <li><a href="page.php?type=terms">Terms of use</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    footer {
        background-color: #232323;
        color: #fff;
        padding: 50px 0;
    }
    
    .footer-top h6 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .footer-top ul {
        list-style-type: none;
        padding: 0;
    }

    .footer-top ul li {
        margin-bottom: 10px;
    }

    .footer-top ul li a {
        color: #bbb;
        text-decoration: none;
    }

    .footer-top ul li a:hover {
        color: #fff;
    }

    .newsletter-form .newsletter-input {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f1f1f1;
    }

    .newsletter-form button {
        background-color: red;
        color: white;
        padding: 10px 20px;
        border: none;
        width: 100%;
        border-radius: 5px;
        cursor: pointer;
    }

    .newsletter-form button:hover {
        background-color:maroon;
    }

    .footer-bottom {
        background-color: #111;
        padding: 20px 0;
    }

    .footer-bottom .copy-right {
        font-size: 14px;
    }

    .social-links {
        list-style: none;
        padding: 0;
    }

    .social-links li {
        margin-bottom: 10px;
    }

    .social-links li a {
        color: #bbb;
        text-decoration: none;
    }

    .social-links li a:hover {
        color: red;
    }

    .footer-links {
        list-style: none;
        padding: 0;
        display: flex;
        justify-content: flex-end;
    }

    .footer-links li {
        margin-left: 20px;
    }

    .footer-links li a {
        color: #bbb;
        text-decoration: none;
    }

    .footer-links li a:hover {
        color: #fff;
    }
</style>
