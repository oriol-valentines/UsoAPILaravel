<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Animal;
use App\Models\Dueno;
use App\Http\Resources\UserResource;
use App\Http\Resources\AnimalResource;

//http://127.0.0.1:8000/api

//DEFAULT ROUTE
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//MOSTRAR DATOS DE DUEÑOS Y ANIMALES

//mostrar todos los dueños con sus animales
Route::get('/duenos', function () {
    return UserResource::collection(Dueno::all());
});

//mostrar todos los animales con su dueño
Route::get('/animales', function () {
    $animales = Animal::with('dueno')->get();
    return response()->json($animales);
});

//CREAR NUEVO DUEÑO Y ANIMAL

//crear nuevo dueño
Route::post('/duenos', function (Request $request){
    $dueno = Dueno::create([
        'nombre' => $request->nombre,
        'apellido' => $request->apellido
    ]);
    return response()->json($dueno, 201); //201 Created
});

//crear nuevo animal
Route::post('/animales', function (Request $request){
    $animal = Animal::create([
        'nombre' => $request->nombre,
        'tipo' => $request->tipo,
        'peso' => $request->peso,
        'enfermedad' => $request->enfermedad,
        'comentarios' => $request->comentarios,
        'dueno_id' => $request->dueno_id
    ]);
    return response()->json($animal, 201);
});

//ACTUALIZAR DUEÑO Y ANIMAL

//actualizar dueño
Route::put('/duenos/{id}', function (Request $request,string $id){
    $dueno = Dueno::find($id);
    if (!$dueno) {
        return response()->json(['message' => 'Dueño no encontrado'], 404);
    }
    $dueno->update([
        'nombre'=>$request->nombre,
        'apellido'=>$request->apellido
    ]);
    return response()->json($dueno, 201);
});

//actualizar animal
Route::put('/animales/{id}', function (Request $request,string $id){
    $animal = Animal::find($id);
    if(!$animal){
        return response()->json(['message' => 'Animal not found'],404);
    }
    $animal->update([
        'nombre' => $request->nombre,
        'tipo' => $request->tipo,
        'peso' => $request->peso,
        'enfermedad' => $request->enfermedad,
        'comentarios' => $request->comentarios,
        'dueno_id' => $request->dueno_id
    ]);
    return response()->json($animal, 201);
});

//ELIMINAR DUEÑO Y ANIMAL

//eliminar dueño
Route::delete('/dueno/{id}', function (Request $request, string $id){
    $dueno = Dueno::find($id);
    if(!$dueno){
        return response()->json(['Message' => 'user not Found', 404]);
    }
    $dueno->delete();
    return response()->json(['message' => 'Dueño eliminado'], 201);
});

//eliminar animal
Route::delete('/animal/{id}', function (Request $request, string $id){
    $animal = Animal::find($id);
    if(!$animal){
        return response()->json(['message' => 'Animal no encontrado'], 404);
    }
    $animal->delete();
    return response()->json(['message' => 'Animal eliminado'], 201);
});


//MOSTRAR DUEÑO Y ANIMAL ESPECIFICO

//mostrar usuario especifico
Route::get('/duenos/{id}', function (string $id) {
    $dueno = Dueno::find($id);
    if(!$dueno){
        return response()->json(['message' => 'Dueño no encontrado'], 404);
    }
    return response()->json($dueno);
});

//mostrar animal especifico
Route::get('/animales/{id}', function ($id){
    $animal = Animal::find($id);
    if(!$animal){
        return response()->json(['message' => 'no se ha encontrado el animal'], 404);
    }
    return response()->json($animal);
});