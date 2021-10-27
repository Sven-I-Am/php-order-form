<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
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
    if($emailError!='' || $streetError!='' || $strNumberError!=''){
        echo '<div class="alert alert-danger">' . $emailError . $streetError . $strNumberError . '</div>';
    }
    if ($success!='') {
        echo '<div class="alert alert-success">' . $success . '</div>';
    }
    ?>
    <form method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail:</label>
                <input type="text" id="email" name="email" class="form-control" value="<?php if($_SESSION["email"]!=''){echo $_SESSION["email"];} ?>"<?php if($emailError!=''){echo 'style="border-color: #f5c6cb; background-color: #f8d7da"';}elseif($_SESSION["email"]!=''){echo 'style="border-color: #c3e6cb; background-color: #d4edda"';} ?>"/>
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
                    <input type="text" id="city" name="city" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode</label>
                    <input type="text" id="zipcode" name="zipcode" class="form-control">
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>
            <?php foreach ($products AS $i => $product): ?>
                <label>
                    <input type="checkbox" value="1" name="products[<?php echo $i ?>]"/> <?php echo $product['name'] ?> -
                    &euro; <?php echo number_format($product['price'], 2) ?></label><br />
            <?php endforeach; ?>
        </fieldset>

        <label>
            <input type="checkbox" name="express_delivery" value="5" />
            Express delivery (+ 5 EUR)
        </label>

        <button type="submit" class="btn btn-primary">Order!</button>
    </form>

    <footer>You already ordered <strong>&euro; <?php echo $totalValue ?></strong> in food and drinks.</footer>
</div>

<style>
    footer {
        text-align: center;
    }
</style>
</body>
</html>