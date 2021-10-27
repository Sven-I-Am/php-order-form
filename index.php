<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

//we are going to use session variables so we need to enable sessions
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
$email = "";
//initiating form errors
$emailError = "";
//initiating other form values
$success = "";
$error = 0;
$totalValue = 0;


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

    if($error == 0){
        $success = "Order sent";
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


whatIsHappening();
require 'form-view.php';