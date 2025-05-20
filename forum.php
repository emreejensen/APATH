<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APATH FORUM</title>
    <link rel="stylesheet" href="apath.css">
    <style>
    .error {color: #FF0000;}
    .forum-container {
        margin: 20px;
    }
    .thread-list {
        list-style-type: none;
        padding: 0;
    }
    .thread-item {
        padding: 10px;
        border: 1px solid #ccc;
        margin-bottom: 10px;
        border-radius: 4px;
    }
    .thread-item a {
        text-decoration: none;
        color: #000;
    }
    .thread-item a:hover {
        text-decoration: underline;
    }
    .new-thread {
        margin-top: 20px;
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
		
        <h2>Forum</h2>

        <div class="forum-container">
            <ul class="thread-list">
                <?php
                // Example threads - replace with dynamic content from your database
                $threads = [
                    ['id' => 1, 'title' => 'Welcome to APATH!'],
                    ['id' => 2, 'title' => 'General Discussion'],
                    ['id' => 3, 'title' => 'Volunteer Opportunities'],
					['id' => 4, 'title' => 'Student Q&A'],
					['id' => 5, 'title' => 'Admin Alerts']
                ];
                
                foreach ($threads as $thread) {
                    echo '<li class="thread-item"><a href="thread.php?id=' . $thread['id'] . '">' . $thread['title'] . '</a></li>';
                }
                ?>
            </ul>

            <div class="new-thread">
                <a href="new_thread.php">Start New Thread</a>
            </div>
        </div>
    <p class="footer"><a href="#">Covid Information and Guidelines</a></p>
	</div>
</body>
</html>