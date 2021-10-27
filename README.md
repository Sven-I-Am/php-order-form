# Exercise using PHP
## challenge
from the files provided by [BeCode](https://github.com/becodeorg/ANT-Lamarr-5.34/tree/main/2.The-Hill/php/3.order-form) create a working order-form using only PHP!

## timeline
* day 1
  * I got the basic functionality working with the help from
    * [W3schools](https://www.w3schools.com/)
    * [GeeksForGeeks](https://www.geeksforgeeks.org/php-full-form/?ref=lbp)
    * [stackoverflow](https://stackoverflow.com/)
  * initiated the repository in GitHub and committed/pushed only once at the end of the day
* day 2
  * I worked on adding some nice to have features such as
    * changing the product selection from checkboxes to numerical input
    * adding a COOKIE to keep track of the total spent by the user
      * Ran into an issue when I tried setting the cookie within the index.php file. I got it working however by coding it into the form-view.php before the `<html>` tag
    * I tried adding the functionality to order both food and drinks in one order (session) but it broke my code
    * discovered an issue when ordering drinks at the end of the day, continue to check on day 3
    * committed code before lunch and at the end of the day
* day 3
  * can't figure out the issue with the drinks order so decided to scrap code and start again
  * must commit more often!
  * restarting code:
    * :thumbsup: products array and visual on the page switch between foods and drinks when clicking the nav links
    * :thumbsup: validate email
    * :thumbsup: save email to SESSION
    * :thumbsup: show error message when invalid email
    * :thumbsup: validate street
    * :thumbsup: save street to session
    * :thumbsup: show error message when invalid street
    * :thumbsdown: validate street number
    * :thumbsdown: save street number to SESSION
    * :thumbsdown: show error when invalid street number