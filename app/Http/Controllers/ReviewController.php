<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class ReviewController extends Controller
{
    public function show() {
        return Inertia::render('Reviews');
    }
}
