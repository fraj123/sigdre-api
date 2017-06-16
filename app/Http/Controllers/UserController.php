<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

use App\User;

use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = \App\User::with('cargos', 'estados')->get();
        return response()->json(compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \DB::beginTransaction();
        try{
            $register = new User;
            $register->id_cargo     = $request->cargo;
            $register->nombres      = $request->nombres;
            $register->paterno      = $request->paterno;
            $register->materno      = $request->materno;
            $register->username     = $request->username;
            $register->password     = Hash::make($this->generateRandomString(15));
            $register->email        = $request->email;
            $register->id_estado    = 1;
            $register->save();
            \DB::commit();
            return response()->json(['error' => 'false'], 200);
        } catch (Exception $exception){
             \DB::rollback();
            return response()->json(['error' => 'true'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        \DB::beginTransaction();
        try{
            $register = User::find($id);
            $register->id_cargo     = $request->cargo;
            $register->nombres      = $request->nombres;
            $register->paterno      = $request->paterno;
            $register->materno      = $request->materno;
            $register->username     = $request->username;
            $register->email        = $request->email;
            $register->id_estado    = $request->estado;
            $register->save();
            \DB::commit();
            return response()->json(['resultado' => 'false'], 200);
        } catch (Exception $exception){
            \DB::rollback();
            return response()->json(['resultado' => 'true'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Metodo para la autenticacion de usuario mediante un token
     * en la API
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function auth(Request $request){

        $credentials = $request->only('email', 'password');
        $token = null;

        $usuario = \App\User::where('email', $request->email) -> first();

        try{
            if(!$token = JWTAuth::attempt($credentials)){
                return response()->json(['error'=>'Invalid credentials']);
            }
        } catch (JWTException $exception){
            return response()->json(['error'=>'Something went wrong'], 500);
        }
        return response()->json(compact('usuario', 'token'));
    }

    //Método con str_shuffle()
    function generateRandomString($length = 10) {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }
}
