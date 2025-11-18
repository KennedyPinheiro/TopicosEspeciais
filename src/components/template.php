<?php
class Template {
    private $vars = [];
    private $componentsPath;
    
    public function __construct($componentsPath = 'components/') {
        $this->componentsPath = $componentsPath;
    }
    
    public function assign($key, $value) {
        $this->vars[$key] = $value;
    }
    
    public function render($template, $data = []) {
  
        $allVars = array_merge($this->vars, $data);
        extract($allVars);
        
    
        $currentPage = $currentPage ?? 'home';
        

        include $this->componentsPath . 'Header.php';
        include $this->componentsPath . 'Navbar.php';
        

        if (file_exists($template)) {
            include $template;
        } else {
            echo "<div class='container mt-4'><div class='alert alert-danger'>Página não encontrada: $template</div></div>";
        }

        include $this->componentsPath . 'Footer.php';
    }
}
?>