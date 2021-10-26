<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

//we are going to use session variables, so we need to enable sessions
session_start();

//your products with their price.
if(!isset($_GET["food"]) || $_GET["food"]!=0){
    $products = [
        ['name' => 'Club Ham', 'price' => 3.20],
        ['name' => 'Club Cheese', 'price' => 3],
        ['name' => 'Club Cheese & Ham', 'price' => 4],
        ['name' => 'Club Chicken', 'price' => 4],
        ['name' => 'Club Salmon', 'price' => 5]
    ];
} else {
    $products = [
        ['name' => 'Cola', 'price' => 2],
        ['name' => 'Fanta', 'price' => 2],
        ['name' => 'Sprite', 'price' => 2],
        ['name' => 'Ice-tea', 'price' => 3],
    ];
}
const COOKIE_NAME = "totalSpent";
$totalValue = 0;
$totalSpentValue = 0;
define("REST_EMAIL", "sven.vander.mierde@gmail.com");

//check and validate email
function validateEmail($email) : string
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["email"] = $email;
        $emailError = '';
    } else {
        $emailError = 'Please enter a valid email';
    }
    return $emailError;
}

function validateStreet($street): string
{
    if (strlen($street)>=3 && strlen($street)<=44 && preg_match("/[0-9]/", $street) == 0){
        $_SESSION["street"] = $street;
        $streetError = '';
    }else{
        $streetError = 'Please enter a valid street name';
    }
    return $streetError;
}

function validateStreetNumber($number): string
{
    if (strlen($number)!=0 && preg_match("/[^0-9]/", $number) == 0){
        $_SESSION["strNumber"] = $number;
        $strNumberError = '';
    } else {
        $strNumberError = 'Please enter a valid streetnumber, only numbers are allowed!';
    }
    return $strNumberError;
}

function validateCity($city): string
{
    if (strlen($city)>=2 && strlen($city)<=26 && preg_match("/[0-9]/", $city) == 0){
        $_SESSION["city"] = $city;
        $cityError = '';
    }else{
        $cityError = 'Please enter a valid street name';
    }
    return $cityError;
}

function validateZipcode($zip): string
{
    $zip = (int)$zip;
    if ($zip >= 1000&& $zip<=9999){
        $_SESSION["zipcode"] = $zip;
        $zipcodeError = '';
    } else {
        $zipcodeError = 'Please enter a valid zipcode: between 1000 and 9999';
    }
    return $zipcodeError;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $error = 0;
    $i = 0;
    $order = [];
    $email = $_POST["email"];
    $emailError = validateEmail($email);
    if($emailError!=''){$error++;}
    $street = $_POST["street"];
    $streetError = validateStreet($street);
    if($streetError!=''){$error++;}
    $strNumber = $_POST["streetnumber"];
    $strNumberError = validateStreetNumber($strNumber);
    if($strNumberError!=''){$error++;}
    $city = $_POST["city"];
    $cityError = validateCity($city);
    if($cityError!=''){$error++;}
    $zipcode = $_POST["zipcode"];
    $zipcodeError = validateZipcode($zipcode);
    if($zipcodeError!=''){$error++;}
    foreach($_POST['products'] as $product) {
        $name = $products[$i]["name"];
        $price = $products[$i]["price"];
        $price = (float)$price;
        $quantity = $product;
        $productTotal = $quantity * $price;
        $productOrder = ['name'=>$name, 'price'=>$price, 'quantity'=>$quantity,'productTotal'=>$productTotal];
        $totalValue += $productTotal;
        array_push($order, $productOrder);
        $i++;
    }
    if($totalValue==0) {
        $error++;
        $orderError = "please select products to order";
    }
    if(isset($_POST["express_delivery"])){
        $deliveryTime = '45 minutes';
        $expressPrice = $_POST["express_delivery"];
        $expressPrice = (float)$expressPrice;
        $totalValue += $expressPrice;
        $express = true;
    } else {
        $deliveryTime = '2 hours';
        $express = false;
    }

    if ($error == 0){

        /*$mailToUser = "Thank you for ordering with us!\nDelivery adress: \n" . $street . " " . $strNumber. "\n Zipcode: " . $zipcode . " - City: " . $city . "\n";
        foreach($order as $prod){
            if($prod["quantity"]!=0){
                $mailToUser.= $prod["name"] . " x " . $prod["quantity"] . " = &euro;" . $prod["productTotal"] . "\n";
            }
        }
        if ($express == true){
            $mailToUser .= "Express-delivery = &euro;" . $expressPrice;
        }
        $mailToUser .= 'Ordertotal: &euro;' . $totalValue . '\n Estimated delivery time: ' . $deliveryTime . '\n';
        $mailToOwner = "We got an order in!\n" . $mailToUser;
        mail(REST_EMAIL, "new order!", $mailToOwner);
        mail($email, "We got your order", $mailToUser);*/
        $success = '<h2>Order sent successfully. Check your inbox!</h2>
                    Your order is: <br>';

    }
}

function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}

//whatIsHappening();

require 'form-view.php';