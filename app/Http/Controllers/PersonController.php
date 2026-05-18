<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function testAccessorsMutators()
    {
        $person = new Person();
        $person->first_name = "Achmad";
        $person->last_name = "Rifaih";
        $person->save();

        $fullName = $person->full_name;

        // $person = Person::find(1);
        // $person->full_name = "Aminu Fatma";
        // $person->save();

        return response()->json([
            'person' => $person,
        ]);
    }

    public function testAttributeCasting()
    {
        $person = new Person();
        $person->first_name = "Achmad";
        $person->last_name = "Rifaih";
        $person->save();

        return response()->json([
            'person' => $person,
        ]);
    }

    public function testCustomCast()
    {
        $person = new Person();
        $person->first_name = "Achmad";
        $person->last_name = "Rifaih";
        $person->address = new Address(
            "Jalan Belum Jadi",
            "Jakarta",
            "Indonesia",
            "13960"
        );
        $person->save();
        
        return response()->json([
            'person' => $person,
            'address' => $person->address,
        ]);
    }
}
