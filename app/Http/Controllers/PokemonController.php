<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PokemonController extends Controller
{
    public function updatePokemonUser(Request $request) {
        $user_pokemon_data = User::firstOrCreate(['id' => $request->id]);
        if($request->mood == 'hate'){
            if(str_contains($user_pokemon_data->like, $request->pokemon_id)){
                return response()->json(['isValid'=>false, 'errors'=>'You already liked this Pokemon']);
            }
            if(is_null($user_pokemon_data->hate) && !is_null($request->hate)){
                $user_pokemon_data->hate = $request->pokemon_id . ',';
            }else{
                $hates = explode(',', $user_pokemon_data->hate);
                if(count($hates) <= 3){
                    $user_pokemon_data->hate = $user_pokemon_data->hate . $request->pokemon_id . ',';
                }else{
                    return response()->json(['isValid'=>false, 'errors'=>'Hates reach maximum of 3']);
                }
            }
        }
        if($request->mood == 'like'){
            if(str_contains($user_pokemon_data->hate, $request->pokemon_id)){
                return response()->json(['isValid'=>false, 'errors'=>'You already hated this Pokemon']);
            }
            if(is_null($user_pokemon_data->like) && !is_null($request->like)){
                $user_pokemon_data->like = $request->pokemon_id . ',';
            }else{
                $likes = explode(',', $user_pokemon_data->like);
                if(count($likes) <= 3){
                    $user_pokemon_data->like = $user_pokemon_data->like . $request->pokemon_id . ',';
                }else{
                    return response()->json(['isValid'=>false,'errors'=>'Likes reach maximum of 3']);
                }
            }
        }
        if($request->mood == 'fave'){
            $user_pokemon_data->favorite = $request->favorite;
        }
        $user_pokemon_data->save();
        return response()->json(['user_pokemon_data'=>$user_pokemon_data, 'isValid'=>true]);
    }

    public function retrieveLikeHateFav(Request $request) {
        $user_pokemon_data = User::where('id', $request->id)->get();
        return response()->json(compact('user_pokemon_data'));
    }

    public function retrieveAllUserPokemon(Request $request) {
        $user_pokemon_data = User::get();
        return response()->json(compact('user_pokemon_data'));
    }

    public function getUserId(Request $request) {
        $user_pokemon_data = User::where('id', '!=', $request->id)->get();
        return response()->json(compact('user_pokemon_data'));
    }
}
