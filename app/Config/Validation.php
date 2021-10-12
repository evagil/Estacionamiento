<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;
use \App\Validation\ingresoRules;

class Validation
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        IngresoRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------

    public $formIngreso = [
        'dni' => [
            'rules' => 'required|exact_length[8]|numeric|existeUsuario[usuarios.dni,id_usuario,{id_usuario}]',
            'errors' => [
                'required' => 'Ingrese su dni.',
                'exact_length' => 'El dni debe ser de 8 numeros.',
                'numeric' => 'El dni debe ser numerico.',
                'existeUsuario' => 'El dni no esta asociado a ningun usuario.'
            ]
        ],
        'clave' => [
            'rules' => 'required|coincideClave[usuarios.clave,{dni}]',
            'errors' => [
                'required' => 'Ingrese su clave.',
                'coincideClave' => 'Clave erronea.'
            ]
        ]
    ];
}
