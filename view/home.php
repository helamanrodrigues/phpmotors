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
    <title>PHP Motors | Home</title>
</head>
<body>
    <div id="container">
    <header> 
        <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/header.php';?>
    </header>
    <nav>
        <?php echo $navList;?>
    </nav>
    <main>
        
        <div class="home-content">
            <h1>Welcome to PHP Motors!</h1>
            <div class="center">
                <img src="images/delorean.jpg" alt="delorean">
                <h2>DMC Delorean</h2>
                <p>3 Cup holders Superman doors Fuzzy dice!</p>
                <img class="button" src="images/site/own_today.png" alt="Own today">
            </div>
            <section>
                <h3>Delorean Upgrades</h3>
                <section>
                    <div>
                        <div>
                            <img src="images/upgrades/flux-cap.png" alt="flux-cap">
                        </div>
                        
                        <a href="#">Flux Capacitor</a>
                    </div>
                    <div>
                        <div>
                            <img src="images/upgrades/flame.jpg" alt="flame">
                        </div>
                        <a href="#">Flame Details</a>
                    </div>
                    <div>
                        <div>
                            <img src="images/upgrades/bumper_sticker.jpg" alt="bumper stickers">
                        </div>
                        <a href="#">Bumper Stickers</a>
                    </div>
                    <div>
                        <div>
                            <img src="images/upgrades/hub-cap.jpg" alt="hub caps">
                        </div>
                        <a href="#">Hub Caps</a>
                    </div>
                </section>
            </section>
            <section>
                <h3>DMC Delorean Reviews</h3>
                <ul>
                    <li>"So fast its almost like traveling in time" (4/5)</li>
                    <li>"Coolest ride on the road" (4/5)</li>
                    <li>"I'm feeling Marty McFly!" (5/5)</li>
                    <li>"The most futuristic ride of our day" (4.5/5)</li>
                    <li>"80's living and I love it!" (4/5)</li>
                </ul>
            </section>
        </div>
        

    </main>
    <footer>
        <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php';?>
    </footer>
    </div>
</body>
</html>