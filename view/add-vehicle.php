<?php
$classificList = '<select name="carClassification" id="carClassification">';
foreach ($classifications as $classification) {
 $classificList .= "<option value='$classification[classificationId]'";
 if(isset($carClassification)){
     if($classification['classificationId']=== $carClassification){
         $classificList .= ' selected ';
     }
 }
 $classificList .= ">$classification[classificationName]</option>";
}
$classificList .= '</select>';
?><!DOCTYPE html>
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
    <title>PHP Motors | Add Vehicle</title>
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
            <h1>Add Vehicle</h1>
            <?php
            if (isset($message)) {
                echo $message;
            }
            ?>
            <p>* Note all Fields are Required</p>
            
            <form action="/phpmotors/vehicles/index.php" method="post">
                <div>
                    <label for="carClassification">Car Classification</label>
                    <?php echo $classificList; ?>
                </div>
                <div>
                    <label for="vehicleMake">Make</label>
                    <input type="text" name="vehicleMake" id="vehicleMake" <?php if(isset($vehicleMake)){echo "value='$vehicleMake'";} ?> required>
                </div>
                <div>
                    <label for="vehicleModel">Model</label>
                    <input type="text" name="vehicleModel" id="vehicleModel" <?php if(isset($vehicleModel)){echo "value='$vehicleModel'";} ?> required>
                </div>
                <div>
                    <label for="vehicleDescription">Description</label>
                    <textarea name="vehicleDescription" id="vehicleDescription" cols="16" rows="2" required><?php if(isset($vehicleDescription)){echo $vehicleDescription;} ?></textarea>
                </div>
                <div>
                    <label for="vehicleImagePath">Image Path</label>
                    <input type="text" name="vehicleImagePath" id="vehicleImagePath" <?php if(isset($vehicleImagePath)){echo "value='$vehicleImagePath'";} ?> required>
                </div>
                <div>
                    <label for="vehicleThumbnailPath">Thumbnail Path</label>
                    <input type="text" name="vehicleThumbnailPath" id="vehicleThumbnailPath" <?php if(isset($vehicleThumbnailPath)){echo "value='$vehicleThumbnailPath'";} ?> required>
                </div>
                <div>
                    <label for="vehiclePrice">Price</label>
                    <input type="number" name="vehiclePrice" id="vehiclePrice" <?php if(isset($vehicleThumbnailPath)){echo "value='$vehiclePrice'";} ?> required>
                </div>
                <div>
                    <label for="vehicleInStock"># In Stock</label>
                    <input type="number" name="vehicleInStock" id="vehicleInStock" <?php if(isset($vehicleInStock)){echo "value='$vehicleInStock'";} ?> required>
                </div>
                <div>
                    <label for="vehicleColor">Color</label>
                    <input type="text" name="vehicleColor" id="vehicleColor" <?php if(isset($vehicleColor)){echo "value='$vehicleColor'";} ?> required>
                </div>
                <input type="hidden" name="action" value="addVehicle">
                <button class="primary" type="submit">Add Vehicle</button>
            </form>
        </main>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/common/footer.php'; ?>
        </footer>
    </div>
</body>

</html>