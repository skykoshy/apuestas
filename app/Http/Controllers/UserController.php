<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Log;

class UserController extends Controller
{
    public function authenticate(Request $request)
    {
      $credentials = $request->only('email', 'password');
      try {
          if (! $token = JWTAuth::attempt($credentials)) {
              return response()->json(['success' => false]);
          }
      } catch (JWTException $e) {
          return response()->json(['success' => false]);
      }

      $user = User::where('email',$request->post('email'))->first();
      
      return response()->json([
          'token'=>$token,
          'nombre' => $user->name,
          'success'=>true
      ]);
    }


    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
                return response()->json([
                    "success"=>false,
                    "errors"=>$validator->errors()->toJson()
                ]);
        }

        $user = User::create([
            'name' => $request->post('nombre'),
            'email' => $request->post('email'),
            'saldo' => "10000",
            'apuesta' => "sin apuesta",
            'password' => Hash::make($request->post('password')),
        ]);

        $token = JWTAuth::fromUser($user);
        $success = true;
        return response()->json(compact('user','token','success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function players()
    {
        $players = User::all();
        return response()->json($players);
    }

    public function update(Request $request)
    {
        $user = User::find($request->post('id'));
        $user->name = $request->post('name');
        $user->email = $request->post('email');
        $user->saldo = $request->post('saldo');
        $user->save();
        
        return response()->json([
            "user" => $user,
            "mensaje" => "El jugador se ha actualizado satisfactoriamente."
        ]);
    }

    public function show($id)
    {
        $player = User::find($id);
        return response()->json($player);
    }

    public function delete($id)
    {
        $player = User::find($id);
        $player->delete();
        return response()->json([ "mensaje" => "El jugador se ha eliminado satisfactoriamente."]);
    }

    public function sorteo()
    {
        $colors_bet =[
            'red' => 15,
            'green' => 2,
            'black' => 2,
        ];

        $colors = ['red','green','black'];
        $pesos =[2,49,49];

        $players = User::all();

        foreach ($players as $player) {
           $apuesta_porcentaje = rand(8,15);

           $saldo = $player->saldo;
           //el cliente elige un color aleatorio
           $apuesta = array_rand($colors,1);
           $valor_apuesta = ($saldo*$apuesta_porcentaje)/100;

           if($saldo <= 1000){
            $apuesta = $saldo;
           }

          $result = $this->weighted_random($colors,$pesos);

          if($colors[$apuesta] == $result)
          {
            $player->saldo =round( $player->saldo+($valor_apuesta*$colors_bet[$result]));

          }else{
            $player->saldo = round($player->saldo - $valor_apuesta);
          }
          $player->apuesta = $colors[$apuesta];
          $player->update();
           
        }

        return response()->json([
            "players"=>$players,
            "color" => $result
        ]);
    }

    private function weighted_random($values, $weights){ 
        $count = count($values); 
        $i = 0; 
        $n = 0; 
        $num = mt_rand(0, array_sum($weights)); 
        while($i < $count){
            $n += $weights[$i]; 
            if($n >= $num){
                break; 
            }
            $i++; 
        } 
        return $values[$i]; 
    }
}