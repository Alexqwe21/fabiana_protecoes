<?php

class HomeController extends Controller
{

    public function index()
    {

        $dados = array();





        $dados['mensagem'] = 'Ben-vindo a KiOficina';
        $dados['nome'] = 'Alex';



        //var_dump($dados);

        $this ->carregarViews('home', $dados);
    }
}
