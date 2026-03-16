<?php

namespace App\Http\Livewire;

use App\Models\Orcamento;
use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Pedido;
use PDO;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Auth;

class Visualizar extends Component
{

    public $orcamento_id;
    public $nome = '';
    public $profissional = '';
    public $convenio = 'Particular';
    public $observacao = '';
    public $etapa = 'ORÇAMENTO';
    public $orcamento = [];
    public $filtrados = [];
    public $medias = [];
    public $selecionado = [];
    public $pedido;
    public $cdprofat = '';
    public $dsprofat;
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
    public $obs = '';
    public $oid;
    public $data;
    public $secundarios = [];
    public $versao;
    public $protocolo;


    public function mount(){


        $this->oid = request()->route()->parameter('orc');
    }


    public function render()
    {


        $o = Orcamento::where('id', $this->oid)->first();


        //dd($id);

        $this->orcamento_id = $o->protocolo;
        $this->nome = $o->nome;
        $this->profissional = $o->profissional;
        $this->convenio = $o->convenio;
        $this->cdprofat = $o->cdprofat;
        $this->dsprofat = $o->dsprofat;
        $this->observacao = $o->observacao;
        $this->obs = $o->obs;
        $this->data = $o->created_at;
        $this->versao = $o->versao;
        $this->protocolo = $o->protocolo;

        $this->orcamento = $o->itens;

        if(json_decode($o->secundarios)){
            $this->secundarios = json_decode($o->secundarios);
        }else{
            $this->secundarios = [];
        }



        return view('livewire.visualizar');
    }

    public function summernote($text){


        //$this->obs = $text;

        $this->dispatchBrowserEvent('summernote');

    }

    public function setetapa($etapa){

        $this->etapa = $etapa;

        $this->filtrados = collect($this->orcamento)->where('DS_GRU_FAT', $etapa);



        if($this->etapa == 'OBSERVAÇÕES'){
            $this->dispatchBrowserEvent('summernote');
        }


    }

























}
