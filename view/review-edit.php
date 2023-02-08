<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="/phpmotors/css/normalize.css" rel="stylesheet">
    <link href="/phpmotors/css/small.css" rel="stylesheet">
    <link href="/phpmotors/css/medium.css" rel="stylesheet">
    <link href="/phpmotors/css/large.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Exo&display=swap" rel="stylesheet">
    <title>Edit Review | PHP Motors</title>
</head>

<body>
    <div id="container">
        <header>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/header.php'; ?>
        </header>
        <nav>
            <?php echo $navList;?>
        </nav>
        <main>
            <?php
            echo "
            <h1>$review[invMake] $review[invModel] Review</h1>
            <p>Reviewed on $review[reviewDate]</p>";
            ?>
            <?php
            if (isset($message)) {
                echo $message;
            }
            ?>
            <form action='/phpmotors/reviews/index.php' method='POST'>
                <input type='hidden' name='action' value='updateReview'>
                <input type='hidden' name='reviewId' value="<?php echo $reviewId?>">
                <div>
                    <label for='reviewText'>Review Text</label>
                    <textarea name='reviewText' id='reviewText' cols='30' rows='10' required><?php echo $review['reviewText']; ?></textarea>
                </div>
                <button class='primary' type='submit'>Update</button>
            </form>

        </main>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>
    </div>
</body>

</html>