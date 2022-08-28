<?php 
    class conexion {
        private $host;
        private $db;
        private $user;
        private $pass;
        private $charset;

        public function __construct()
        {
            $this->host     = "localhost";
            $this->db       = "prueba_geniat";
            $this->user     = "root";
            $this->pass     = "";
            $this->charset  = "utf8mb4";
        }

        function conexion() {
            try {
                $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
                $PDO = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db . ';charset=' . $this->charset, $this->user, $this->pass, $options);
                return $PDO;
            } catch (PDOException $e) {
                print_r('Error en la conexión: ' . $e->getMessage());
            }
        }
    }
?>