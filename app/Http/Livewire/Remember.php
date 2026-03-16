<?php

namespace App\Http\Livewire;

use App\Models\Orcamento;
use Livewire\Component;
use App\Models\Pedido;
use PDO;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as Request;
use Illuminate\Support\Facades\DB;

class Remember extends Component
{

    public $oid;
    public $versao;
    public $orcamento_id;
    public $nome = '';
    public $profissional = '';
    public $convenio = 'Particular';
    public $observacao = '';
    public $etapa = 'DADOS CADASTRAIS';
    public $orcamento = [];
    public $filtrados = [];
    public $medias = [];
    public $selecionado = [
        'QTD' => 1,
        'VALOR' => 0,
        'CD_PRO_FAT' => ''
    ];
    public $pedido;
    public $cdprofat = '';
    public $dsprofat;
    public $cdprofat_sec = '';
    public $dsprofat_sec;
    public $secundarios = [];
    public $grupos = [
        'DADOS CADASTRAIS',
        'DIARIAS',
        'DROGAS E MEDICAMENTOS',
        'GASES MEDICINAIS',
        'HONORARIOS MEDICOS',
        'MATERIAL MEDICO HOSPITALAR',
        'TAXAS',
        'EXAMES E DIAGNOSTICOS',
        'MATERIAIS ESPECIAIS (OPME)',
        'PACOTES ESPECIAIS',
        'ENDOSCOPICOS CIRURGICOS',
        'OBSERVAÇÕES',
        'ORÇAMENTO'
    ];
    public $obs = '<p><b>ITENS NÃO INCLUSOS NESTA PREVISÃO:
    </b></p><p>Honorários Médicos, Exames Complementares (Laboratorial e de Imagens), Fisioterapia, Fonoaudiologia, Banco de Sangue, Hemodiálise, Medicamentos de alto custo, OPME (Órtese Próteses e Materiais Especiais).
    </p><p><br></p><p><b>
    INFORMAÇÕES IMPORTANTES:</b>
    </p><p>Os valores acima descritos são previsões e consideram exclusivamente o procedimento descrito neste documento. Em caso de inclusão e/ou realização de outros procedimentos, ESTA PREVISÃO PERDERÁ SUA VALIDADE.
    </p><p>Esta previsão está sujeita a alterações de acordo com os gastos efetivamente ocorridos dentro do hospital e anotações em prontuário, de acordo com o quadro clinico do cliente saúde, bem como a alteração de valor a maior ou a menor, conforme a
    utilização de materiais, medicamentos e/ou fios cirúrgicos.
    </p><p>Os <b>OPMES (ÓRTESES, PRÓTESES E MATERIAIS ESPECIAIS)</b>,deverão ser adquiridos de forma particular pelo paciente.
    </p><p>O MÉDICO CIRURGIÃO É RESPONSÁVEL PELA INDICAÇÃO DA MARCA E FORNECEDOR DO MATERIAL.
    O hospital cobra uma <b>TAXA DE OPERACIONALIZAÇÃO (10%) sobre o valor total do MATERIAL (OPME)</b> ,para tanto se faz necessário o envio da cotação do material para que seja calculada a taxa e a Estimativa seja atualizada ANTES da internação da paciente.</p><p><br></p><p><b>

    CONTATO PARA NEGOCIAÇÕES E FORMAS DE PAGAMENTO</b>:
    </p><p>Formas de Pagamento: Dinheiro, Cartão de Crédito/Débito, Transferência Bancária ou Depósito.
    À vista (Dinheiro) 5% de desconto ou até 3x sem juros no cartão.
    </p><p><span style="background-color: rgb(255 255 255 / var(--tw-bg-opacity)); font-size: 1rem;">O HOSPITAL FAZ A DEVOLUÇÃO DE VALOR CASO A CONTA SEJA MENOR QUE O VALOR PAGO.
    </span></p><p><span style="background-color: rgb(255 255 255 / var(--tw-bg-opacity)); font-size: 1rem;"><b>FINANCEIRO HOSPITAL DAHER: (61) 3213-4867 / 3213-4873 / 9.9809-3229 (WhatsApp)</b></span></p><p><span style="background-color: rgb(255 255 255 / var(--tw-bg-opacity)); font-size: 1rem;"><b>
    IHG: BANCO DE SANGUE (061) 3213-4999
    </b></span></p><p><span style="background-color: rgb(255 255 255 / var(--tw-bg-opacity)); font-size: 1rem;"><b>LABORATORIO CIAP: ANATOMOPATOLÓGICO POR CONGELAÇÃO (061) 3213-4924 /3346-1155.
    </b></span></p><p><span style="background-color: rgb(255 255 255 / var(--tw-bg-opacity)); font-size: 1rem;">O Cliente Saúde deverá impreterivelmente efetuar o pagamento com 48 horas de antecedência, em dias úteis e em horário comercial.
    </span></p><p><span style="background-color: rgb(255 255 255 / var(--tw-bg-opacity)); font-size: 1rem;"><b><font color="#ff0000">Esta Previsão tem validade por 30 (trinta) dias.</font></b></span><br></p>';

    public $procedimentos = [];
    public $pesquisar;
    public $modal = false;

    protected $listeners = ['summernote' => 'summernote', 'gerarorcamento' => 'gerarorcamento'];

    public function mount(){

        $this->oid = request()->get('id', 0);

        if($this->oid){
            $this->carregaorc();
        }

    }

    public function render()
    {

        $this->procedimentos =  $this->mv_query("SELECT cd_pro_fat, ds_pro_fat FROM pro_fat where cd_pro_fat like '%$this->pesquisar%' or ds_pro_fat like '%$this->pesquisar%' FETCH FIRST 10 ROWS ONLY");

        return view('livewire.remember');
    }

    public function carregaorc(){


        $o = Orcamento::where('id', $this->oid)->first();

        $this->orcamento_id = $o->protocolo ;
        $this->nome = $o->nome;
        $this->profissional = $o->profissional;
        $this->convenio = $o->convenio;
        $this->cdprofat = $o->cdprofat;
        $this->dsprofat = $o->dsprofat;
        $this->observacao = $o->observacao;
        $this->obs = $o->obs;
        //$this->data = $o->created_at;

        $this->orcamento = collect($o->itens);

        if(json_decode($o->secundarios)){
            $this->secundarios = json_decode($o->secundarios);
        }else{
            $this->secundarios = [];
        }




    }

    public function abrirmodal(){

        $this->modal = true;

    }



    public function summernote($text){


        $this->obs = $text;

        $this->dispatchBrowserEvent('summernote');

    }

    public function setetapa($etapa){

        $this->etapa = $etapa;

        $this->filtrados = collect($this->orcamento)->where('DS_GRU_FAT', $etapa);

        $this->limparSelecionado();

        if($this->etapa == 'OBSERVAÇÕES'){
            $this->dispatchBrowserEvent('summernote');
        }


    }

    public function setprofat($cdprofat, $dsprofat){

        $this->selecionado['CD_PRO_FAT'] = $cdprofat;
        $this->selecionado['DS_PRO_FAT'] = $dsprofat;

        $this->modal = false;

        $this->pesquisar = '';


    }

    public function limparSelecionado(){


        $this->selecionado = collect([
            'QTD' => 1,
            'VALOR' => 0,
            'CD_PRO_FAT' => ''
        ]);

    }

    public function remove($index){

        $this->orcamento->forget($index);

        $this->filtrados = $this->orcamento->where('DS_GRU_FAT', $this->etapa);

        $this->limparSelecionado();


    }

    public function edit($index){

        $this->selecionado = $this->orcamento[$index];
        $this->selecionado['id'] = $index;



    }

    public function save(){


        //dd(isset($this->selecionado['id']));

        if(isset($this->selecionado['id'])){

            $this->orcamento[$this->selecionado['id']] = $this->selecionado;
            $this->limparSelecionado();
            $this->filtrados = $this->orcamento->where('DS_GRU_FAT', $this->etapa);

            //dd($this->orcamento);

        }else{

            $this->selecionado['DS_GRU_FAT'] = $this->etapa;

            $id = collect($this->orcamento)->reverse()->keys()->first() + 1;

            $this->orcamento[$id] = $this->selecionado->toArray();

            $this->limparSelecionado();
            $this->filtrados = collect($this->orcamento)->where('DS_GRU_FAT', $this->etapa);

            //dd($this->orcamento);

        }





    }


    public function limpar(){


        $keys = $this->orcamento->where('DS_GRU_FAT', $this->etapa)->keys();

        foreach ($keys as $key ) {
            $this->orcamento->forget($key);
        }


        $this->filtrados = $this->orcamento->where('DS_GRU_FAT', $this->etapa);

        $this->limparSelecionado();


    }

    public function agrupar(){


        $media = 0;

        foreach ($this->filtrados as  $v) {
            $media += $v['TOTAL'];
        }



        $this->limpar();


        $id = collect($this->orcamento)->reverse()->keys()->first() + 1;

        //dd($id);

        $this->orcamento[$id] = [
            'QTD' => 1,
            'VALOR' => $media,
            'TOTAL' => $media,
            'CD_PRO_FAT' => '',
            'DS_PRO_FAT' => 'VALOR MÉDIO '. $this->etapa,
            'DS_GRU_FAT' => $this->etapa
        ];

        $this->limparSelecionado();
        $this->filtrados = collect($this->orcamento)->where('DS_GRU_FAT', $this->etapa);

    }


    public function updatedCdprofat(){

        $dsprofat = $this->mv_query("SELECT ds_pro_fat FROM pro_fat WHERE CD_PRO_FAT = '$this->cdprofat'");

        if(count($dsprofat)){
            $this->dsprofat = $dsprofat[0]['DS_PRO_FAT'];
        }else{

        }


    }

    public function addsec(){

        $this->secundarios[] = '';

    }

    public function removesec($key){

        //dd($this->secundarios);

        $secundarios = collect($this->secundarios)->forget($key);

        $this->secundarios = $secundarios;

    }

    public function updatedSelecionado(){


        if($this->selecionado['QTD']>0 & $this->selecionado['VALOR']>0){
            $this->selecionado['TOTAL'] = $this->selecionado['QTD'] * $this->selecionado['VALOR'];
        }



    }

    public function updatedSelecionadoCDPROFAT($value){

        $this->getprofat();

    }

    public function getprofat(){

        $cdprofat = $this->selecionado['CD_PRO_FAT'];

        $dsprofat = $this->mv_query("SELECT ds_pro_fat FROM pro_fat WHERE CD_PRO_FAT = '$cdprofat'");

        if(count($dsprofat)){
            $this->selecionado['DS_PRO_FAT'] = $dsprofat[0]['DS_PRO_FAT'];
        }else{

        }


    }


    public function getMedias(){

                $sql = "
                SELECT a.cd_pro_fat, c.ds_pro_fat,  a.cd_gru_fat, d.ds_gru_fat, 1 as qtd, dbamv.fnc_ffcv_calcula_procedimento( a.cd_pro_fat, 64, 1, 'I', 1, 'U' ) AS total,  dbamv.fnc_ffcv_calcula_procedimento( a.cd_pro_fat, 64, 1, 'I', 1, 'U' ) AS valor

                FROM itreg_fat a

                INNER JOIN reg_fat b ON a.cd_reg_fat = b.cd_reg_fat
                INNER JOIN pro_fat c ON a.cd_pro_fat = c.cd_pro_fat
                INNER JOIN gru_fat d ON a.cd_gru_fat = d.cd_gru_fat

                WHERE b.cd_reg_fat IN

                (
                SELECT i.cd_reg_fat
                FROM itreg_fat i
                INNER JOIN reg_fat r ON i.cd_reg_fat = r.cd_reg_fat
                WHERE r.cd_convenio = 64
                AND i.cd_pro_fat = '$this->cdprofat'
                )

                GROUP BY a.cd_pro_fat, a.cd_gru_fat, c.ds_pro_fat, d.ds_gru_fat

                ";




        if(count($this->secundarios)){

            foreach ($this->secundarios as $sec) {


                $sql .= "

                UNION ALL

                SELECT a.cd_pro_fat, c.ds_pro_fat,  a.cd_gru_fat, d.ds_gru_fat, 1 as qtd, dbamv.fnc_ffcv_calcula_procedimento( a.cd_pro_fat, 64, 1, 'I', 1, 'U' ) AS total,  dbamv.fnc_ffcv_calcula_procedimento( a.cd_pro_fat, 64, 1, 'I', 1, 'U' ) AS valor

                FROM itreg_fat a

                INNER JOIN reg_fat b ON a.cd_reg_fat = b.cd_reg_fat
                INNER JOIN pro_fat c ON a.cd_pro_fat = c.cd_pro_fat
                INNER JOIN gru_fat d ON a.cd_gru_fat = d.cd_gru_fat

                WHERE b.cd_reg_fat IN

                (
                SELECT i.cd_reg_fat
                FROM itreg_fat i
                INNER JOIN reg_fat r ON i.cd_reg_fat = r.cd_reg_fat
                WHERE r.cd_convenio = 64
                AND i.cd_pro_fat = '$sec'
                )

                GROUP BY a.cd_pro_fat, a.cd_gru_fat, c.ds_pro_fat, d.ds_gru_fat

                ";

                }


        }




        $medias = $this->mv_query($sql);



        if(count($medias)){
            $this->medias = $medias;
            $this->orcamento = collect($medias);

            $this->orcamento = collect($medias)->map(function ($registro) {
                $registro['VALOR'] = floatval($registro['VALOR']);
                $registro['TOTAL'] = floatval($registro['TOTAL']);
                return $registro;
            });

            $this->dispatchBrowserEvent('message');

            $this->limparSelecionado();

        }else{
            $this->dispatchBrowserEvent('fail');
            $this->limparSelecionado();
        }


    }






    public function mv_query($sql) {

        $tns = "
        (DESCRIPTION =
            (ADDRESS_LIST =
              (ADDRESS = (PROTOCOL = TCP)(HOST = oda-scan.hdls.home)(PORT = 1521))
            )
            (CONNECT_DATA =
              (SERVICE_NAME = MVHTML5)
            )
          )
               ";
        $db_username = "john_araujo";
        $db_password = "jh0n2021";
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



    public function  gerarorcamento(){

        ///dd($this->orcamentos);

        $orcam = [
            'nome' => $this->nome,
            'profissional' => $this->profissional,
            'convenio' => $this->convenio,
            'cdprofat' => $this->cdprofat,
            'dsprofat' => $this->dsprofat,
            'observacao' => $this->observacao,
            'valor' => collect($this->orcamento)->sum('TOTAL'),
            'obs' => $this->obs,
            'user_id' => Auth::user()->id
        ];




        if(count($this->secundarios)){

            foreach ($this->secundarios as $sec) {
                $secundarios[] = $sec;
            }

            $orcam['secundarios'] = json_encode($secundarios);

        }

        $orcamento = Orcamento::create($orcam);

        //update protocolo
        if($this->oid){

            $idpai = DB::table('orcamentos')->where('id', $this->oid)->first()->id_pai;

            $prot = $idpai;
            $this->versao = DB::table('orcamentos')->where('id_pai', $idpai)->count()+1;
            //$idpai = $this->oid;
        }else{
            $prot = $orcamento->id;
            $this->versao = 1;
            $idpai = $orcamento->id;
        }


        $protocolo = $prot;
        Orcamento::where('id', $orcamento->id)->update(['protocolo' => $protocolo, 'id_pai' => $idpai, 'versao' => $this->versao]);

        foreach ($this->orcamento as $orc) {
            $orc['orcamento_id'] = $orcamento->id;
            $orc['id'] = null;

            $orcamento->itens()->create($orc);
        }

        $this->orcamento_id = $protocolo;

        $this->dispatchBrowserEvent('generatePDF');

    }

}
