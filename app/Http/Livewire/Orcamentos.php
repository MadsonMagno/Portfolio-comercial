<?php

namespace App\Http\Livewire;

use App\Models\Orcamento;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Orcamentos extends Component
{

    use WithPagination;

    public $search = '';
    public $data_ini ;
    public $data_fim ;

    public function render()
    {

        if($this->data_ini == ''){
            $this->data_ini = date('Y-m-d', strtotime(today())-1);
            $this->data_fim = date('Y-m-d', strtotime(today()));
        }

        $orcamentos = Orcamento::where('created_at','>=',$this->data_ini)
                        ->where('created_at','<=', date('Y-m-d H:i:s', strtotime($this->data_fim.' 23:59:59')))
                        ->where('nome','like','%'.$this->search.'%')
                        ->OrWhere('profissional','like','%'.$this->search.'%')
                        ->OrWhere('cdprofat','like','%'.$this->search.'%')
                        ->OrWhere('dsprofat','like','%'.$this->search.'%')
                        ->OrWhere('id','like','%'.$this->search.'%')
                        ->OrWhere('protocolo','like','%'.$this->search.'%')
                        ->with('user')
                        ->orderby('protocolo')
                        ->orderby('versao')
                        ->paginate(10);

        return view('livewire.orcamentos', compact('orcamentos'));
    }


    public function updatedSearch(){

        $this->resetPage();

    }

}
