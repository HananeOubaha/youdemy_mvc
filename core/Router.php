<?php

class Router
{
    protected $currentController = 'HomeController'; // Contrôleur par défaut
    protected $currentMethod = 'index'; // Méthode par défaut
    protected $params = [];

    public function __construct()
    {
        $url = $this->getUrl();

        // Vérifier si un contrôleur correspondant existe
        if (isset($url[0]) && file_exists(__DIR__ . '/../app/controllers/' . ucfirst($url[0]) . '.php')) {
            $this->currentController = ucfirst($url[0]);
            unset($url[0]);
        }

        // Inclure le contrôleur
        $controllerPath = __DIR__ . '/../app/controllers/' . $this->currentController . '.php';

        if (!file_exists($controllerPath)) {
            die("Erreur 404 : Contrôleur <strong>{$this->currentController}</strong> introuvable.");
        }

        require_once $controllerPath;

        // Vérifier si la classe du contrôleur existe
        if (!class_exists($this->currentController)) {
            die("Erreur : La classe <strong>{$this->currentController}</strong> n'existe pas.");
        }

        // Instancier le contrôleur
        $this->currentController = new $this->currentController;

        // Vérifier si une méthode est définie dans le contrôleur
        if (isset($url[1]) && method_exists($this->currentController, $url[1])) {
            $this->currentMethod = $url[1];
            unset($url[1]);
        } elseif (!method_exists($this->currentController, $this->currentMethod)) {
            die("Erreur 404 : La méthode <strong>{$this->currentMethod}</strong> n'existe pas dans le contrôleur <strong>" . get_class($this->currentController) . "</strong>.");
        }

        // Récupérer les paramètres restants
        $this->params = $url ? array_values($url) : [];

        // Appeler la méthode avec les paramètres
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    private function getUrl()
    {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
