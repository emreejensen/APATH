<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APATH ABOUT</title>
    <link rel="stylesheet" href="apath.css">
    <style>
    .error {color: #FF0000;}
    .about-container {
        text-align: center;
        margin: 20px;
    }
    .about-container img {
        width: 100%;
        max-width: 600px;
        height: auto;
    }
    .about-container p {
        font-size: 1.2em;
        line-height: 1.6em;
        margin: 20px 0;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>APATH</h1>
		
		<?php
		$current_page = basename($_SERVER['PHP_SELF']);
		include "nav.php";
		?>
		
		<h2>About</h2>

        <div class="about-container">
		
			<!-- Picture -->
            <img src="airport.jpg" alt="Airport">
            
            <!-- Description of the website -->
            <p>
                Welcome to APATH, a platform dedicated to assisting new students and volunteers in the Atlanta area.<br><br>
                Our mission is to provide support and resources to help students transition smoothly into their new environment.<br><br>
                Whether you need help with airport pickups, temporary housing, or finding local information, APATH is here to connect you with volunteers ready to lend a hand.<br><br>
                Join our community and make your transition to Atlanta a positive and enriching experience.
            </p>
			
			<!-- Picture -->
            <img src="atlanta.jpg" alt="Atlanta, Georgia">
            
            <!-- Brief information about Atlanta, Georgia -->
            <p>
                Atlanta, Georgia, is a vibrant and dynamic city known for its rich history, diverse culture, and booming economy. As the state capital, Atlanta boasts numerous attractions, including the Georgia Aquarium, the World of Coca-Cola, and the Atlanta Botanical Garden.<br><br>
                The city is also home to a thriving arts scene, top-notch restaurants, and beautiful parks, making it a fantastic place to live and visit.
            </p>
        </div>
    <p class="footer"><a href="#">Covid Information and Guidelines</a></p>
	</div>
</body>
</html>