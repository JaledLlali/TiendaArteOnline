<script src="https://www.paypal.com/sdk/js?client-id=YOUR_CLIENT_ID&currency=EUR"></script><?php
define('ProPayPal', 0);
if(ProPayPal){
    define("PayPalClientId", "ASLlSl2NwD7NXo9EN0dyvqbrQc9iSP7aQc2kVS6IMxXJMjpmOf02iYO0TlJVF0Rb5fXs4UuN3Rq0HOso");
    define("PayPalSecret", "EFJSncXGhmmGffNkA7aYwS0d7SQTCXGdqLHhpMhqf3iJXupFYMaooFI4F8c_8PwnQNyXAsXdG41h2OiR");
    define("PayPalBaseUrl", "https://api.paypal.com/v1/");
    define("PayPalENV", "production");
} else {
    define("PayPalClientId", "XXXXXXXXXXXXXXXXXXXXX");
    define("PayPalSecret", "XXXXXXXXXXXXXXXXXXXXXXX");
    define("PayPalBaseUrl", "https://api.sandbox.paypal.com/v1/");
    define("PayPalENV", "sandbox");
}
?>