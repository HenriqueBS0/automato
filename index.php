<?php

require_once 'EstadoFinal.php';
require_once 'Automato.php';


$alfabeto = array_merge(Automato::getLetras(), Automato::getNumeros());

$estados = [
    'q0', 'q1', 'q2',  'q3',
    'q4', 'q5', 'q6',  'q7',
    'q8', 'q9', 'q10', 'q11',
    'q12'
];

$estadoInicial = 'q0';

$estadosFinais = [
    new EstadoFinal('q2',  'IF'),
    new EstadoFinal('q5',  'FOR'),
    new EstadoFinal('q10', 'WHILE'),
    new EstadoFinal('q11', 'ID'),
    new EstadoFinal('q12', 'CONSTANTE')
];


$delta = [
    'q0'  => array_merge(
        ['i' => 'q1', 'f' => 'q3', 'w' => 'q6'],
        Automato::getCarateresParaEstado('q12', Automato::getNumeros()),
        Automato::getCarateresParaEstado('q11', Automato::getLetras(['i', 'f', 'w'])),
    ),
    'q1'  => array_merge(
        ['f' => 'q2'],
        Automato::getCarateresParaEstado('q11', Automato::getNumeros()),
        Automato::getCarateresParaEstado('q11', Automato::getLetras(['f'])),
    ),
    'q2'  => Automato::getCarateresParaEstado('q11', array_merge(Automato::getLetras(), Automato::getNumeros())),
    'q3'  => array_merge(
        ['o' => 'q4'],
        Automato::getCarateresParaEstado('q11', Automato::getNumeros()),
        Automato::getCarateresParaEstado('q11', Automato::getLetras(['o'])),
    ),
    'q4'  => array_merge(
        ['r' => 'q5'],
        Automato::getCarateresParaEstado('q11', Automato::getNumeros()),
        Automato::getCarateresParaEstado('q11', Automato::getLetras(['r'])),
    ),
    'q5'  => Automato::getCarateresParaEstado('q11', array_merge(Automato::getLetras(), Automato::getNumeros())),
    'q6'  => array_merge(
        ['h' => 'q7'],
        Automato::getCarateresParaEstado('q11', Automato::getNumeros()),
        Automato::getCarateresParaEstado('q11', Automato::getLetras(['h'])),
    ),
    'q7'  => array_merge(
        ['i' => 'q8'],
        Automato::getCarateresParaEstado('q11', Automato::getNumeros()),
        Automato::getCarateresParaEstado('q11', Automato::getLetras(['i'])),
    ),
    'q8'  => array_merge(
        ['l' => 'q9'],
        Automato::getCarateresParaEstado('q11', Automato::getNumeros()),
        Automato::getCarateresParaEstado('q11', Automato::getLetras(['l'])),
    ),
    'q9'  => array_merge(
        ['e' => 'q10'],
        Automato::getCarateresParaEstado('q11', Automato::getNumeros()),
        Automato::getCarateresParaEstado('q11', Automato::getLetras(['e'])),
    ),
    'q10' => Automato::getCarateresParaEstado('q11', array_merge(Automato::getLetras(), Automato::getNumeros())),
    'q11' => Automato::getCarateresParaEstado('q11', array_merge(Automato::getLetras(), Automato::getNumeros())),
    'q12' => array_merge(
        Automato::getCarateresParaEstado('q12', Automato::getNumeros()),
        Automato::getCarateresParaEstado('q11', Automato::getLetras()),
    ),
];

$automato = new Automato($alfabeto, $estados, $estadoInicial, $estadosFinais, $delta);

try {
    echo $automato->getTipoEntrada('123412e234234for');
} catch (Exception $ex) {
    echo $ex->getMessage();
}
