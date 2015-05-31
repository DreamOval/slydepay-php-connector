<!DOCTYPE html>
<!--

-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include_once 'Integrator.class.php';

        
            $paylive="https://app.slydepay.com.gh/payLIVE/detailsnew.aspx?pay_token=";
            $ns="http://www.i-walletlive.com/payLIVE"; 
            $wsdl="https://app.slydepay.com.gh/webservices/paymentservice.asmx?wsdl";

            $settings = parse_ini_file("sample.ini");

            $api_version=$settings["slydepay.api_version"];
            $merchant_email=$settings["slydepay.merchant_email"];
            $merchant_secret_key=$settings["slydepay.merchant_key"];

            
            $service_type="C2B";
            $integration_mode=true;

            $slyde = new SlydepayConnector($ns, $wsdl, $api_version, $merchant_email, $merchant_secret_key, $service_type, $integration_mode);

            $order_id= GUID();

            $comment1="";
            $comment2="";
            $order_items = array();

            $chromecast_unit_price = 150;
            $chromecast_quantity = 2;
            $chromecast_subtotal = $chromecast_unit_price* $chromecast_quantity;

            $organza_unit_price = 50;
            $organza_quantity = 2;
            $organza_subtotal = $organza_unit_price* $organza_quantity;

            $order_items[0] = $slyde->buildOrderItem("001", "chromecast", $chromecast_unit_price, $chromecast_quantity, $chromecast_subtotal);
            $order_items[1] = $slyde->buildOrderItem("002", "organza", $organza_unit_price, $organza_quantity,$organza_subtotal);


            $sub_total=$chromecast_subtotal+ $organza_subtotal;
            $shipping_cost=30;
            $tax_amount=0;
            $total= $sub_total + $shipping_cost+ $tax_amount;


            $response = $slyde->ProcessPaymentOrder($order_id, $sub_total, $shipping_cost, $tax_amount, $total, $comment1, $comment2, $order_items);
//           Uncomment for debugging
//            var_dump($response);
//            var_dump($response->ProcessPaymentOrderResult);
            $redirect = $paylive.$response->ProcessPaymentOrderResult;


//Uncomment to use MobilePaymentOrder web method and comment ProcessPaymentOrder block

//            $response = $slyde->MobilePaymentOrder($order_id, $sub_total, $shipping_cost, $tax_amount, $total, $comment1, $comment2, $order_items);
//            var_dump($response);
//            var_dump($response->mobilePaymentOrderResult);
//            $redirect = $paylive.$response->mobilePaymentOrderResult->token;


//Displaying what the composed redirect url looks like before running the redirect command
//              var_dump($redirect);

            header("Location: $redirect");

        function GUID()
        {
            if (function_exists('com_create_guid') === true)
            {
                return trim(com_create_guid(), '{}');
            }

            return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
        }

        ?>
    </body>
</html>
