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
    <title> <?php echo $vehicle['invMake'] . " " . $vehicle['invModel']; ?> | PHP Motors</title>
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
            <?php if (isset($vehicleDetailDisplay)) {
                echo $vehicleDetailDisplay;
            } ?>

            <hr>
            <h2>Customer Reviews</h2>
            <h2>Review The <?php echo $vehicle['invMake'] . " " . $vehicle['invModel'] ?></h2>
            <?php
            if (isset($_SESSION['messageVehicle'])) {
                echo $_SESSION['messageVehicle'];
            } ?>
            <?php
            if (!isset($_SESSION['loggedin'])) {
                echo '<p>You must <a href="/phpmotors/accounts/?action=login">login</a> to write a review.</p>';
            } else {
                if (!$_SESSION['loggedin']) {
                    echo '<p>You must <a href="/phpmotors/accounts/?action=login">login</a> to write a review.</p>';
                } else {
                    echo '
            <form action="/phpmotors/reviews/index.php" method="post" style="max-width: none">
                <div>
                    <label for="screenName">Screen Name</label>
                    <input type="text" name="screenName" id="screenName" value = "' . $screenName . '" disabled>
                </div>
                <div>
                    <label for="reviewText">Review</label>
                    <textarea class="txtarea" name="reviewText" id="reviewText" cols="30" rows="5" required></textarea>
                </div>
                <input type="hidden" name="action" value="addReview">
                <input type="hidden" name="invId" value="' . $vehicle['invId'] . '">
                <input type="hidden" name="invMake" value="' . $vehicle['invMake'] . '">
                <input type="hidden" name="invModel" value="' . $vehicle['invModel'] . '">
                <input type="hidden" name="clientId" value="' . $_SESSION['clientData']['clientId'] . '">
                <button class="primary" type="submit">Submit Review</button>
            </form>
           ';
                    echo $firstReview;
                }
            } ?>

            <?php
            echo $reviewsDetailDisplay;
            ?>
        </main>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>
    </div>
</body>

</html>