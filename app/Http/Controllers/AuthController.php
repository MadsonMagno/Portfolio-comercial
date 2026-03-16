<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;
use App\Services\LdapService;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Adldap\Laravel\Facades\Adldap;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends AuthenticatedSessionController
{


    protected $ldapService;

    public function __construct(LdapService $ldapService)
    {
        $this->ldapService = $ldapService;
    }


    public function store(LoginRequest $request)
    {

        $email = $request->email.'@hospitaldaher.com.br';
        $request->merge(['email' => $email]);

        //autentica LDAP Geral
        if ($this->ldapService->authenticate($request->email, $request->password)) {

            //dd($this->ldapService->search($request->email));

            //Somente Usuário Radiologia ou TI
            if($userldap = $this->ldapService->search($request->email)){

                //dd(User::where('email', $request->email)->first());

                //Se não tiver na base local Cria
                if(!User::where('email', $request->email)->first()){
                    $userldap = $this->ldapService->search($request->email);
                    $user = User::create([
                        'name' => $userldap->getCommonName(),
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                    ]);
                 }


                 //atualiza a senha devido a politica de troca
                 if(Hash::make($request->password) != User::where('email', $email)->first()->password){

                    $user = User::where('email', $email)->first();
                    $user->password = Hash::make($request->password);
                    $user->save();

                 }


                //Autentica Local
                $request->authenticate();

                $request->session()->regenerate();

                return redirect()->intended(RouteServiceProvider::HOME);


            }



            return redirect()->route('login')->with('error', 'Você não tem permissão para acessar este sistema.');


        }

        return redirect()->route('login')->with('error', 'Credenciais inválidas.');





    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

}
