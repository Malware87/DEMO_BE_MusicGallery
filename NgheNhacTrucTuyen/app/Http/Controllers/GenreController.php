<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Genre;

class GenreController extends Controller {
    public function GetGenre(Request $request) {
        $output = Genre::select('id', 'name')->get();
        return response()->json($output);
    }
}
