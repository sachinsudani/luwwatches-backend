<?php

    namespace src\Controller;
    use Src\Models\CartModel;

    class CartController {
        private $db = null;
        private $requestMethod = null;
        private $CartModel;
        private $user = null;
        private $uri = null;

        public function __construct($db, $requestMethod, $uri, array $user) {
            $this->db = $db;
            $this->requestMethod = $requestMethod;
            $this->CartModel = new CartModel($db);
            $this->user = $user;
            $this->uri = $uri;
        }

        public function process_request() {
            switch($this->requestMethod) {
                case 'POST':
                        $response = $this->add_to_cart();
                break;
                
                case 'GET':
                    if(isset($this->uri[4])) {
                        if($this->uri[4] == "all")
                        $response = $this->get_orders();
                    } else {
                        $response = $this->get_cart();
                    }
                break;

                case 'UPDATE':
                    if(isset($this->uri[4])) {
                        if($this->uri[4] == "order")
                        $response = $this->place_order();
                    } else {
                        $response = $this->update_cart();
                    }
                break;
            }
            header($response['status_code_header']);
            if(isset($response['body'])) {
                echo $response['body'];
            }
        }

        public function add_to_cart() {
            $result = $this->CartModel->add_to_cart($this->user);
            $response['status_code_header'] = 'HTTP/1.1 200 Ok';
            $response['body'] = json_encode("{message: $result}");
            return $response;
        }

        public function get_cart() {
            $result = $this->CartModel->get_cart($this->user);
            $response['status_code_header'] = 'HTTP/1.1 200 Ok';
            $response['body'] = json_encode($result);
            return $response;
        }

        public function get_orders() {
            $result = $this->CartModel->get_orders();
            $response['status_code_header'] = 'HTTP/1.1 200 Ok';
            $response['body'] = json_encode($result);
            return $response;
        }
        
        public function update_cart() {
            $result =$this->CartModel->update_cart($this->user);
            $response['status_code_header'] = 'HTTP/1.1 201 Updated';
            $response['body'] = null;
            return $response;
        }

        public function place_order() {
            $result =$this->CartModel->place_order($this->user);
            $response['status_code_header'] = 'HTTP/1.1 201 Updated';
            $response['body'] = null;
            return $response;
        }
    }

?>