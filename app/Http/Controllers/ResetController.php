<?php

namespace App\Http\Controllers;

use App\Models\Remember;
use Illuminate\Http\Request;
use PDO;

class ResetController extends Controller
{
    //
    public function reset(Request $request){



        $remember = Remember::where('token', $request->token)->first();

        if($remember->date){
            return response('Token Inválido!');
        }


        $user = $this->mv_query("select * from dbasgu.usuarios where cpf = $remember->cpf");

        if(count($user)){

            $senha = rand(0, 99999999);

            $sql = "update dbasgu.usuarios set cd_senha = (select cd_senha from dbasgu.usuarios where cd_usuario = 'dbamv'), sn_senha_plogin = 'S', sn_ativo='S', nr_tentativa_login = 0 where cpf =  $remember->cpf ";
            $altera = $this->mv_execute($sql);
        }

        dd($altera);

    }



    public function mv_query($sql) {



        $tns = "
        (DESCRIPTION =
            (ADDRESS_LIST =
              (ADDRESS = (PROTOCOL = TCP)(HOST = sml-scan.hdls.home)(PORT = 1521))
            )
            (CONNECT_DATA =
              (SERVICE_NAME = HTML5HML)
            )
          )
               ";
        $db_username = "dbamv";
        $db_password = env('DB_PASSWORD', '');
        try{
            $conn = new PDO("oci:dbname=".$tns.';charset=UTF8',$db_username,$db_password);

        }catch(PDOException $e){
            echo ($e->getMessage());
        }


            $stmt = $conn->query($sql);

            if($stmt){


                $row =$stmt->fetchAll(PDO::FETCH_ASSOC);

                $lista = $row;

            }else{
                $lista = null;
            }

            Return $lista;


    }

    public function mv_execute($sql) {



        $tns = "
        (DESCRIPTION =
            (ADDRESS_LIST =
              (ADDRESS = (PROTOCOL = TCP)(HOST = sml-scan.hdls.home)(PORT = 1521))
            )
            (CONNECT_DATA =
              (SERVICE_NAME = HTML5HML)
            )
          )
               ";
        $db_username = "dbamv";
        $db_password = env('DB_PASSWORD', '');
        try{
            $conn = new PDO("oci:dbname=".$tns,$db_username,$db_password);
            // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $conn->beginTransaction();
            $stmt = $conn->prepare($sql);

            $stmt->execute();
            $conn->commit();

        }catch(PDOException $e){

            $conn->rollback();

            echo ($e->getMessage());
        }




            if($stmt){


                return $stmt;

            }else{
                return 'erro';
            }




    }
}
