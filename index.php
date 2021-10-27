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
$totalValue = 0;


//when user clicks submit button $_POST gets populated
if (!empty($_POST)) {
    $error = 0; //we start with 0 errors
    $email = $_POST["email"];
    $emailError = validateEmail($email); //function to validate email address
    if ($emailError != '') {
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
            $emailError = 'Please enter a valid email';
        }
        return $emailError;
    }


whatIsHappening();
require 'form-view.php';