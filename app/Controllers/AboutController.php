<?php

namespace App\Controllers;

class AboutController extends BaseController
{
    public function sobre()
    {
        $pageTitle = 'Sobre - Sistema IF';
        $currentPage = 'sobre';
        
        $infoSistema = [
            'versao' => '1.0.0',
            'desenvolvedor' => 'Kennedy Pinheiro',
            'instituicao' => 'IFNMG - Campus Almenara',
            'ano' => date('Y'),
            'tecnologias' => ['PHP', 'MySQL', 'HTML5', 'CSS3', 'JavaScript', 'Bootstrap 5']
        ];
        
        $this->render('sobre', compact('pageTitle', 'currentPage', 'infoSistema'));
    }
}
?>