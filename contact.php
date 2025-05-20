<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APATH CONTACT</title>
    <link rel="stylesheet" href="apath.css">
</head>

<body>
    <div class="container">
        <h1>APATH</h1>
        
        <?php
        $current_page = basename($_SERVER['PHP_SELF']);
        include "nav.php";
        ?>

        <h2>Contact</h2>

        <div class="contact-container">
            <!-- Contact Information -->
            <div class="contact-info">
                <p><strong>Address:</strong> 1234 Volunteer Lane, Atlanta, GA 30301</p>
                <p><strong>Email:</strong> contact@apath.org</p>
                <p><strong>Phone:</strong> (123) 456-7890</p>
            </div>

            <!-- Contact Form -->
            <div class="contact-form">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Simulate form submission
                    $name = htmlspecialchars($_POST['name']);
                    $email = htmlspecialchars($_POST['email']);
                    $message = htmlspecialchars($_POST['message']);
                    echo "<p class='success-message'>Thank you, $name. Your message has been sent successfully!</p>";
                } else {
                ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required>
                        
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                        
                        <label for="message">Message:</label>
                        <textarea id="message" name="message" rows="4" required></textarea>
                        
                        <button type="submit">Submit</button>
                    </form>
                <?php
                }
                ?>
            </div>
        </div>
    <p class="footer"><a href="#">Covid Information and Guidelines</a></p>
	</div>
</body>
</html>
