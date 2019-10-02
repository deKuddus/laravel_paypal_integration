<?php

namespace App\Http\Controllers;

use App\paypal\CreateExecute;
use App\paypal\CreatePayment;
use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class PaymentController extends Controller
{

    public  function  payment(){
        $payment = new CreatePayment();
        return $payment->create();
    }

   public function execute()
   {
       $payment = new CreateExecute();
       return $payment->execute();
   }
}
