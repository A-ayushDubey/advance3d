<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;

class RatingController extends Controller
{

public function store(Request $request,$id)
{

Rating::create([
'user_id'=>auth()->id(),
'product_id'=>$id,
'rating'=>$request->rating,
'review'=>$request->review
]);

return back();

}

}