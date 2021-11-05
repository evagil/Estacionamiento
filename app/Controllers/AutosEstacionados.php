<?php 

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ModeloAutosEstacionados;

class AutosEstacionados extends BaseController{

    public function index() {
      
       $data['titulo'] = "Listado de Vehiculos Estacionados"; 
       echo view('usuarios/perfil/perfil-header', $data);      
        echo view('vehiculos/listarVehiculosEstacionados');   

        echo view('usuarios/perfil/perfil-footer'); 
    }

    public function listar(){        
        $vehiculo = new ModeloAutosEstacionados();
        $autos = $vehiculo->encontrarVehiculosEstacionados();    
        
        return $this->response->setJSON($autos);
    }
}