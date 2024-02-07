<?php

    namespace src\Controller;
    use Src\Models\StockModel;

    class StockController {
        private $db = null;
        private $requestMethod = null;
        private $StockModel;
        private $stockId = null;

        public function __construct($db, $requestMethod, array $uri) {
            $this->db = $db;
            $this->requestMethod = $requestMethod;
            $this->StockModel = new StockModel($db);
            $this->stockId = $uri;
        }

        public function process_request() {
            switch($this->requestMethod) {
                case 'POST':
                        $response = $this->insert_stock_from_request();
                break;
                case 'GET':
                    $response = $this->get_stock($this->stockId[4]);
                break;

                case 'PUT':
                    $response = $this->update_stock_from_request($this->stockId[4]);
                break;

                case 'DELETE':
                    $response = $this->delete_stock_from_request($this->stockId[4]);
                break;

            }

            header($response['status_code_header']);
            if(isset($response['body'])) {
                echo $response['body'];
            }
        }

        public function insert_stock_from_request() {
            $input = (array) json_decode(file_get_contents('php://input'), TRUE);
            $this->StockModel->add_stock($input);
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = null;
            return $response;
        }

        public function get_stock($id) {
            $result = $this->StockModel->get_stock($id);

            
                try {
                    $response['status_code_header'] = "HTTP/1.1 200 OK";
                    $response['body'] = json_encode($result);
                    return $response;
                } catch(\Exception $ex) {
                    $response['status_code_header'] = "HTTP/1.1 401 Unauthorised";
                    $response['body'] = "{ERROR : " . $ex->getMessage() . "}";
                    return $response;
                }
        }
 
        public function update_stock_from_request($id){
            $input = (array) json_decode(file_get_contents('php://input'), TRUE);
            $this->StockModel->update_stock($input,$id);
            $response['status_code_header'] = 'HTTP/1.1 201 Updated';
            $response['body'] = null;
            return $response;

        }

        public function delete_stock_from_request($id){
            $input = (array) json_decode(file_get_contents('php://input'), TRUE);
            $this->StockModel->delete_stock($id);
            $response['status_code_header'] = 'HTTP/1.1 201 Deleted';
            $response['body'] = null;
            return $response;
        }
    }

?>