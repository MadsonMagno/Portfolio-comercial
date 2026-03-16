<?php

namespace App\Services;

use Adldap\Laravel\Facades\Adldap;
use Illuminate\Support\Str;

class LdapService
{
    public function authenticate($username, $password)
    {

        return Adldap::auth()->attempt($username, $password);
    }

    public function search($email)
    {

        $baseComercial = 'OU=Comercial,OU=Usuarios,OU=Hospital Daher Lago Sul (PRD),DC=hdls,DC=home';
        $baseTI = 'OU=TI,OU=Usuarios,OU=Hospital Daher Lago Sul (PRD),DC=hdls,DC=home';

        $baseContabilidade = 'OU=Contabilidade,OU=Usuarios,OU=Hospital Daher Lago Sul (PRD),DC=hdls,DC=home';
        $baseSup = 'OU=Superintendencia,OU=Usuarios,OU=Hospital Daher Lago Sul (PRD),DC=hdls,DC=home';

        $usersComercial =  Adldap::search()->users()->in($baseComercial)->get();
        $usersTI =  Adldap::search()->users()->in($baseTI)->get();
        $usersContabilidade =  Adldap::search()->users()->in($baseContabilidade)->get();
        $usersSup =  Adldap::search()->users()->in($baseSup)->get();

        $users1 = $usersComercial->merge($usersTI);
        $users2 = $users1->merge($usersSup);

        $users = $users2->merge($usersContabilidade);

        //dd($users);

        if ($users->count() > 0) {
            // Iterar sobre os resultados da pesquisa
            foreach ($users as $user) {
                // Acessar os atributos do usuário
                $name = $user->getCommonName();
                $principal = $user->getUserPrincipalName();

                if(Str::lower($email) == Str::lower($principal)){
                    return $user;
                }
            }
        } else {
            return false;
        }



    }
}
