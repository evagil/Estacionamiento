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

    public $formAdministrador = [
        'nombre' => [
            'rules' => 'required|min_length[3]|max_length[30]',
            'errors' => [
                'required' => 'El nombre es requerido.',
                'min_length' => 'El nombre debe ser minimo de 3 letras.',
                'max_length' => 'El nombre debe ser maximo de 30 letras.'
            ]
        ],
        'apellido' => [
            'rules' => 'required|min_length[3]|max_length[255]',
            'errors' => [
                'required' => 'El apellido es requerido.',
                'min_length' => 'El apellido debe ser minimo de 3 letras.',
                'max_length' => 'El apellido debe ser maximo de 255 letras.'
            ]
        ],
        'dni' => [
            'rules' => 'required|exact_length[8]|numeric|is_unique[usuarios.dni,id_usuario,{id_usuario}]',
            'errors' => [
                'required' => 'El dni es requerido.',
                'exact_length' => 'El dni debe ser de 8 numeros.',
                'numeric' => 'El dni debe ser numerico.',
                'is_unique' => 'Ese dni ya existe.'
            ]
        ],
        'email' => [
            'rules' => 'required|valid_email',
            'errors' => [
                'required' => 'El email es requerido.',
                'valid_email' => 'El email no tiene un formato valido.'
            ]
        ],
        'id_rol' => [
            'rules' => 'required|numeric',
            'errors' => [
                'required' => 'El rol es requerido.',
                'numeric' => 'El rol debe ser numerico.'
            ]
        ],
        'clave' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'La clave es requerida.'
            ]
        ],
        'confirmarClave' => [
            'rules' => 'matches[clave]',
            'errors' => [
                'matches' => 'Las claves no coinciden.'
            ]
        ]
    ];

    public $formUsuario = [
        'nombre' => [
            'rules' => 'required|min_length[3]|max_length[30]',
            'errors' => [
                'required' => 'El nombre es requerido.',
                'min_length' => 'El nombre debe ser minimo de 3 letras.',
                'max_length' => 'El nombre debe ser maximo de 30 letras.'
            ]
        ],
        'apellido' => [
            'rules' => 'required|min_length[3]|max_length[255]',
            'errors' => [
                'required' => 'El apellido es requerido.',
                'min_length' => 'El apellido debe ser minimo de 3 letras.',
                'max_length' => 'El apellido debe ser maximo de 255 letras.'
            ]
        ],
        'dni' => [
            'rules' => 'required|exact_length[8]|numeric|is_unique[usuarios.dni,id_usuario,{id_usuario}]',
            'errors' => [
                'required' => 'El dni es requerido.',
                'exact_length' => 'El dni debe ser de 8 numeros.',
                'numeric' => 'El dni debe ser numerico.',
                'is_unique' => 'Ese dni ya existe.'
            ]
        ],
        'email' => [
            'rules' => 'required|valid_email',
            'errors' => [
                'required' => 'El email es requerido.',
                'valid_email' => 'El email no tiene un formato valido.'
            ]
        ],
        'clave' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'La clave es requerida.'
            ]
        ],
        'confirmarClave' => [
            'rules' => 'matches[clave]',
            'errors' => [
                'matches' => 'Las claves no coinciden.'
            ]
        ]
    ];

    public $formEditarAdministrador = [
        'nombre' => [
            'rules' => 'required|min_length[3]|max_length[30]',
            'errors' => [
                'required' => 'El nombre es requerido.',
                'min_length' => 'El nombre debe ser minimo de 3 letras.',
                'max_length' => 'El nombre debe ser maximo de 30 letras.'
            ]
        ],
        'apellido' => [
            'rules' => 'required|min_length[3]|max_length[255]',
            'errors' => [
                'required' => 'El apellido es requerido.',
                'min_length' => 'El apellido debe ser minimo de 3 letras.',
                'max_length' => 'El apellido debe ser maximo de 255 letras.'
            ]
        ],
        'dni' => [
            'rules' => 'required|exact_length[8]|numeric|is_unique[usuarios.dni,id_usuario,{id_usuario}]',
            'errors' => [
                'required' => 'El dni es requerido.',
                'exact_length' => 'El dni debe ser de 8 numeros.',
                'numeric' => 'El dni debe ser numerico.',
                'is_unique' => 'Ese dni ya existe.'
            ]
        ],
        'email' => [
            'rules' => 'required|valid_email',
            'errors' => [
                'required' => 'El email es requerido.',
                'valid_email' => 'El email no tiene un formato valido.'
            ]
        ],
        'id_rol' => [
            'rules' => 'required|numeric',
            'errors' => [
                'required' => 'El rol es requerido.',
                'numeric' => 'El rol debe ser numerico.'
            ]
        ]
    ];

    public $formEditarUsuario = [
        'nombre' => [
            'rules' => 'required|min_length[3]|max_length[30]',
            'errors' => [
                'required' => 'El nombre es requerido.',
                'min_length' => 'El nombre debe ser minimo de 3 letras.',
                'max_length' => 'El nombre debe ser maximo de 30 letras.'
            ]
        ],
        'apellido' => [
            'rules' => 'required|min_length[3]|max_length[255]',
            'errors' => [
                'required' => 'El apellido es requerido.',
                'min_length' => 'El apellido debe ser minimo de 3 letras.',
                'max_length' => 'El apellido debe ser maximo de 255 letras.'
            ]
        ],
        'dni' => [
            'rules' => 'required|exact_length[8]|numeric|is_unique[usuarios.dni,id_usuario,{id_usuario}]',
            'errors' => [
                'required' => 'El dni es requerido.',
                'exact_length' => 'El dni debe ser de 8 numeros.',
                'numeric' => 'El dni debe ser numerico.',
                'is_unique' => 'Ese dni ya existe.'
            ]
        ],
        'email' => [
            'rules' => 'required|valid_email',
            'errors' => [
                'required' => 'El email es requerido.',
                'valid_email' => 'El email no tiene un formato valido.'
            ]
        ],
        'clave' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'La clave es requerida.'
            ]
        ],
        'confirmarClave' => [
            'rules' => 'matches[clave]',
            'errors' => [
                'matches' => 'Las claves no coinciden.'
            ]
        ]
    ];

    public $formAuto = [
        'patente' => [
            'rules' => 'required|exact_length[7]', // patente solo numerica?
            'errors' => [
                'required' => 'Ingrese la patente.',
                'exact_length' => 'La patente debe ser de 7 numeros.' // hay patentes con menos numeros? Deben ser 7 si o si?
            ]
        ],
        'marca' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Ingrese la marca.'
            ]
        ],
        'modelo' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Ingrese el modelo.'
            ]
        ]
    ];
}
