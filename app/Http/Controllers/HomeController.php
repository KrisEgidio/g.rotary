<?php

namespace App\Http\Controllers;

use App\Models\Comunicado;
use App\Models\Confirmacao;
use App\Models\Evento;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboards.inicio', [
            'eventos' => Evento::where('data', '>=', date('Y-m-d'))->orderBy('data', 'asc')->get(),
            'comunicados' => Comunicado::where('data', '>=', date('Y-m-d'))->orderBy('data', 'asc')->get(),
        ]);
    }


    public function calendario()
    {
        $eventos = Evento::where('status', '!=', 'cancelada')->where('data', '>=', date('Y-m-d'))->orderBy('data', 'asc')->get();


        $eventosSessoes = [];
        foreach ($sessoes as $sessao) {
            $eventosSessoes[] = [
                'id' => $sessao->id,
                'data' => date('Y-m-d', strtotime($sessao->data)),
                'dataFormatada' => date('d/m/Y', strtotime($sessao->data)),
                'titulo' => $sessao->nome,
                'descricao' => $sessao->descricao,
                'hora' => date('H:i', strtotime($sessao->hora)),
                'grau' => $sessao->grau,
                'local' => $sessao->lojaTemplo->templo->nome,
                'loja' => $sessao->lojaTemplo->loja->nome,
                'tipo' => 'Sessao',
                'tipoFormatado' => 'Sessão - ' . $sessao->tipo,
                'cor' => $sessao->presencaConfirmada() ? 'callout-success' : 'callout-default',
                'corCalendario' => $sessao->presencaConfirmada() ? 'green' : 'gray',
                'icon' => 'fas fa-bookmark',
                'presencaConfirmada' => $sessao->presencaConfirmada(),
                'imagem' => null,
                'ordemDia' => $sessao->ordem_do_dia,
                'tipoSessao' => $sessao->tipo,
            ];
        }

        foreach ($eventos as $evento) {
            $eventosSessoes[] = [
                'id' => $evento->id,
                'data' => date('Y-m-d', strtotime($evento->data)),
                'dataFormatada' => date('d/m/Y', strtotime($evento->data)),
                'titulo' => $evento->titulo,
                'tipoFormatado' => 'Evento',
                'descricao' => $evento->descricao,
                'hora' => date('H:i', strtotime($evento->hora)),
                'grau' => $evento->grau,
                'local' => $evento->endereco . ' - ' . $evento->bairro . ', ' . $evento->cidade->nome . ' - ' . $evento->cidade->estado->sigla . ', ' . $evento->cep,
                'loja' => $evento->loja->nome,
                'tipo' => 'Evento',
                'cor' => $evento->presencaConfirmada() ? 'callout-success' : 'callout-default',
                'corCalendario' => $evento->presencaConfirmada() ? 'green' : 'gray',
                'icon' => 'far fa-calendar-check',
                'presencaConfirmada' => $evento->presencaConfirmada(),
                'imagem' => $evento->imagem()->first() ? route('imagens.exibir', $evento->imagem()->first()->nome) : '',
                'ordemDia' => null,
                'tipoSessao' => null,
            ];
        }

        usort($eventosSessoes, function ($a, $b) {
            return strtotime($a['data']) - strtotime($b['data']);
        });

        return view('dashboards.calendario', [
            'eventosSessoes' => [],
        ]);
    }

    public function comunicado()
    {
        $comunicados = Comunicado::where('status', '!=', 'cancelada')->orderBy('data', 'desc')->paginate(10);

        return view('dashboards.comunicado', [
            'comunicados' => [],
        ]);
    }

}
