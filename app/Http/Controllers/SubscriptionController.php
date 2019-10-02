<?php

namespace App\Http\Controllers;

use App\paypal\CreatePlan;
use DemeterChain\C;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public  function  createPlan(){
        $plan = new CreatePlan();
        $plan->execute();
    }


    public  function  seePlanList(){
        $plan = new CreatePlan();
        return $plan->planList();
    }


    public  function showPlanDetails($id)
    {
        $plan = new CreatePlan();
        echo "<pre>";
         echo $plan->planDetails($id);
    }

    public  function  planActive($id)
    {
        $plan = new CreatePlan();
        $plan->activate($id);
    }
}
