<!doctype html>
<?php
if (isset($_COOKIE[COOKIE_NAME]))
{
$totalSpentValue = $_COOKIE[COOKIE_NAME] + $totalValue;
}
else
{
$totalSpentValue += $totalValue;
}
setCookie(COOKIE_NAME, $totalSpentValue, time() + (86400 * 30), "/");
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <link type="text/css" rel="stylesheet" href="style.css">
    <title>Order food & drinks</title>
</head>
<body>

<div class="container">
    <h1>Order food in restaurant "the Personal Ham Processors"</h1>
    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="?food=1">Order food</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?food=0">Order drinks</a>
            </li>
        </ul>
    </nav>
    <?php
    if($emailError!=''){
        echo '<div class="alert alert-danger">' . $emailError . '</div>';
    }
    if($streetError!=''){
        echo '<div class="alert alert-danger">' . $streetError . '</div>';
    }
    if ($strNumberError != '') {
        echo '<div class="alert alert-danger">' . $strNumberError . '</div>';
    }
    if ($cityError != '') {
        echo '<div class="alert alert-danger">' . $cityError . '</div>';
    }
    if ($zipcodeError != '') {
        echo '<div class="alert alert-danger">' . $zipcodeError . '</div>';
    }
    if ($orderError !=''){
        echo '<div class="alert alert-danger">' . $orderError . '</div>';
    }
    if ($success!=''){
        echo '<div class="alert alert-success">' . $success;
        foreach($order as $prod){
            if($prod["quantity"]!=0){
                echo $prod["name"] . " x " . $prod["quantity"] . " = &euro;" . $prod["productTotal"] . "<br>";
            }
        }
        if ($express == true){
            echo "Express-delivery = &euro;" . $expressPrice;
        }
        echo '<p><strong>Ordertotal: &euro;' . $totalValue . '</strong></p>
                Estimated deliverytime: ' . $deliveryTime . '</div>';
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail:</label>
                <input type="text" id="email" name="email" class="form-control" value="<?php if($_SESSION["email"]!=''){echo $_SESSION["email"];} ?>"<?php if($emailError!=''){echo 'style="border-color: #f5c6cb; background-color: #f8d7da"';}elseif($_SESSION["email"]!=''){echo 'style="border-color: #c3e6cb; background-color: #d4edda"';} ?>/>
            </div>
            <div></div>
        </div>
        <fieldset>
            <legend>Address</legend>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street:</label>
                    <input type="text" name="street" id="street" class="form-control" value="<?php if($_SESSION["street"]!=''){echo $_SESSION["street"];} ?>"<?php if($streetError!=''){echo 'style="border-color: #f5c6cb; background-color: #f8d7da"';}elseif($_SESSION["street"]!=''){echo 'style="border-color: #c3e6cb; background-color: #d4edda"';} ?>>
                </div>
                <div class="form-group col-md-6">
                    <label for="streetnumber">Street number:</label>
                    <input type="text" id="streetnumber" name="streetnumber" class="form-control" value="<?php if($_SESSION["strNumber"]!=''){echo $_SESSION["strNumber"];} ?>"<?php if($strNumberError!=''){echo 'style="border-color: #f5c6cb; background-color: #f8d7da"';}elseif($_SESSION["strNumber"]!=''){echo 'style="border-color: #c3e6cb; background-color: #d4edda"';} ?>>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" class="form-control" value="<?php if($_SESSION["city"]!=''){echo $_SESSION["city"];} ?>"<?php if($cityError!=''){echo 'style="border-color: #f5c6cb; background-color: #f8d7da"';}elseif($_SESSION["city"]!=''){echo 'style="border-color: #c3e6cb; background-color: #d4edda"';} ?>>
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode</label>
                    <input type="text" id="zipcode" name="zipcode" class="form-control" value="<?php if($_SESSION["zipcode"]!=''){echo $_SESSION["zipcode"];} ?>"<?php if($zipcodeError!=''){echo 'style="border-color: #f5c6cb; background-color: #f8d7da"';}elseif($_SESSION["zipcode"]!=''){echo 'style="border-color: #c3e6cb; background-color: #d4edda"';} ?>>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>
            <?php foreach ($products AS $i => $product): ?>
                <label>
                    <input type="number" min="0" value="0" name="products[]"/> <?php echo $product['name'] ?> -
                    &euro; <?php echo number_format($product['price'], 2) ?></label><br />
            <?php endforeach; ?>
        </fieldset>
        
        <label>
            <input type="checkbox" name="express_delivery" value="5" />
            Express delivery (+ 5 EUR) 
        </label>
            
        <button type="submit" class="btn btn-primary">Order!</button>
    </form>
    <div>Total for current order: <strong>&euro; <?php //echo $orderValue; ?></strong></div>

    <footer>In the last 30 days you've ordered <strong>&euro; <?php echo $totalSpentValue; ?></strong> in food and drinks.</footer>
</div>

<style>
    footer {
        text-align: center;
    }
</style>
</body>
</html>
