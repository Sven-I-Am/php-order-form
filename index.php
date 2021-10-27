<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

//we are going to use session variables, so we need to enable sessions
session_start();

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
//declaring page related values
const DrinksPage = "drinks";
const FoodPage = "foods";
$currentPage = 0;
//your products with their price.
if (!isset($_GET["food"]) || $_GET["food"] != 0) {
    $products = [
        ['name' => 'Club Ham', 'price' => 3.20],
        ['name' => 'Club Cheese', 'price' => 3],
        ['name' => 'Club Cheese & Ham', 'price' => 4],
        ['name' => 'Club Chicken', 'price' => 4],
        ['name' => 'Club Salmon', 'price' => 5]
    ];
    $currentPage = FoodPage;
} else {
    $products = [
        ['name' => 'Cola', 'price' => 2],
        ['name' => 'Fanta', 'price' => 2],
        ['name' => 'Sprite', 'price' => 2],
        ['name' => 'Ice-tea', 'price' => 3],
    ];
    $currentPage = DrinksPage;
}

//initiating form values
$email = $street= $strNumber = $city = $zipcode = "";
//initiating form errors
$emailError = $streetError = $strNumberError = $cityError = $zipcodeError = "";
//initiating other form values
$success = "";
$error = 0;
$totalValue = 0;
//declaring constants for express delivery
const BaseDTime = '120 minute';
const ExpressDTime = '45 minute';
const ExpressDCost = 5;
//declare values for COOKIE
const CookieName = 'totalSpent';
$totalSpentValue = 0;

//when user clicks submit button $_POST gets populated
if (!empty($_POST)) {
    $error = 0; //we start with 0 errors
    $email = $_POST["email"];
    $emailError = validateEmail($email); //function to validate email address
    if ($emailError != '') {
        $error++;
    }
    $street = $_POST["street"];
    $streetError = validateStreet($street);
    if ($streetError != '') {
        $error++;
    }
    $strNumber = $_POST["streetnumber"];
    $strNumberError = validateStreetNumber($strNumber);
    if ($strNumberError != '') {
        $error++;
    }
    $city = $_POST["city"];
    $cityError = validateCity($city);
    if ($cityError != '') {
        $error++;
    }
    $zipcode = $_POST["zipcode"];
    $zipcodeError = validateZipcode($zipcode);
    if ($zipcodeError != '') {
        $error++;
    }
    if (isset($_POST["products"])){
        $_SESSION[$currentPage] = $_POST["products"];
        $order= getProducts($_SESSION[$currentPage]);
        $totalValue = getTotalValue($order);
    } else {
        $error++;
        $orderError = "<li>please select products to order</li>";
    }
    if($error == 0){
        //set now time
        $currentTime = date("H:i");
        $deliveryTime = date('H:i', strtotime($currentTime . BaseDTime));
        $express = false;
        if (isset($_POST["express_delivery"])){
            $express = true;
            $deliveryTime = date('H:i', strtotime($currentTime . ExpressDTime));
            $totalValue += ExpressDCost;
        }
        if (isset($_COOKIE[CookieName])) {
            $totalSpentValue = (float)$_COOKIE[CookieName] + $totalValue;
        } else {
            $totalSpentValue += $totalValue;
        }

        setcookie(CookieName,  strval($totalSpentValue), time() + (86400 * 30), "/");
            $success = "<p><strong>Order sent at " . $currentTime . "</strong></p>
                        Estimated time of delivery: " . $deliveryTime;
            $success .="<br>Your order is: <br>";
        foreach($order as $prod){
            $success .= $prod["name"] . " x " . $prod["quantity"] . " = &euro;" . $prod["productTotal"] . "<br>";
        }
        if ($express == true){
            $success .= "Express-delivery = &euro;" . ExpressDCost;
        }
        $success .= '<p><strong>Ordertotal: &euro;' . $totalValue . '</strong></p>';

    }

}

/*---------*/
/*FUNCTIONS*/
/*---------*/

//VALIDATION FUNCTIONS
    //check and validate email
    function validateEmail($email) : string
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION["email"] = $email;
            $emailError = "";
        } else {
            $emailError = '<li>Please enter a valid email</li>';
        }
        return $emailError;
    }
    //check and validate street name
    function validateStreet($street): string
    {
        if (strlen($street)>=3 && strlen($street)<=44 && preg_match("/[0-9]/", $street) == 0){ //shortest street in BE has 3 letters, longest has 44
            $_SESSION["street"] = $street;
            $streetError ="";
        }else{
            $streetError = '<li>Please enter a valid street name</li>';
        }
        return $streetError;
    }
    //check and validate house number
    function validateStreetNumber($number): string
    {
        if (strlen($number)!=0 && preg_match("/[^0-9]/", $number) == 0){
            $_SESSION["strNumber"] = $number;
            $strNumberError = "";
        } else {
            $strNumberError = '<li>Please enter a valid streetnumber, only numbers are allowed!</li>';
        }
        return $strNumberError;
    }
    //check and validate city name
    function validateCity($city): string
    {
        if (strlen($city)>=2 && strlen($city)<=26 && preg_match("/[0-9]/", $city) == 0){ //shortest city name in BE is 2 letters, longest is 26
            $_SESSION["city"] = $city;
            $cityError = "";
        }else{
            $cityError = '<li>Please enter a valid city name</li>';
        }
        return $cityError;
    }
    //check and validate zipcode
    function validateZipcode($zip): string
    {
    if(preg_match("/[^0-9]/", $zip) == 0 && $zip >= 1000 && $zip <= 9999) { //zipcodes in BE are always 4 numbers long, between 1000 and 9999
        $_SESSION["zipcode"] = $zip;
        $zipcodeError = "";
    } else {
    $zipcodeError = '<li>Please enter a valid zipcode: between 1000 and 9999</li>';
    }
    return $zipcodeError;
    }
//CALCULATION FUNCTIONS
//get all products into an array
function getProducts($current): array
{
    global $products;
    $order = [];
    foreach($current as$i=>$product) {
        $name = $products[$i]["name"];
        $price = $products[$i]["price"];
        $price = (float)$price;
        $quantity = $product;
        $productTotal = $quantity * $price;
        $productOrder = ['name'=>$name, 'price'=>$price, 'quantity'=>$quantity,'productTotal'=>$productTotal];
        if($quantity>0){
            array_push($order, $productOrder); //only add to order if the product has a quantity of more than 0
        }
    }
    return $order;
}
//get total of order
function getTotalValue($order){
    global $totalValue;
    foreach ($order as $prod){
        $totalValue += $prod["productTotal"];
    }
    return $totalValue;
}



//whatIsHappening();
require 'form-view.php';