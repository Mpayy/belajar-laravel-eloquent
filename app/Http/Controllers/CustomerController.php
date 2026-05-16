<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Wallet;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function testQueryOneToOne()
    {
        $customer = Customer::find("PAI");
        
        // $wallet = Wallet::where("customer_id", $customer->id)->first();
        $wallet = $customer->wallet;

        return response()->json([
            "name" => $customer->name,
            "email" => $customer->email,
            "wallet_amount" => $wallet->amount,
        ]);
    }
    
    public function testInsertRelationship()
    {
        $customer = new Customer();
        $customer->id = "PAI";
        $customer->name = "Pai";
        $customer->email = "rifaih712@gmail.com";
        $customer->save();

        $wallet = new Wallet();
        $wallet->amount = 1000000;

        $customer->wallet()->save($wallet);

        return response()->json([
            "customer"=> $customer,
        ]);
    }

    public function testHasOneThrough()
    {
        try {
            $customer = Customer::find("PAI");

        $virtualAccount = $customer->virtualAccount;

        return response()->json([
            "customer" => $customer,
            "virtual_account"=> $virtualAccount
        ]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function testManyToMany()
    {
        $customer = Customer::find("PAI");

        $customer->likeProducts()->attach("1");

        $products = $customer->likeProducts;

        return response()->json([
            "customer" => $customer,
            "products"=> $products
        ]);
    }

    public function testManyToManyDetach()
    {
        $customer = Customer::find("PAI");

        $customer->likeProducts()->detach("1");

        $products = $customer->likeProducts;

        return response()->json([
            "customer" => $customer,
            "products"=> $products
        ]);
    }
}
