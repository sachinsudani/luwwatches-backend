<?php

    namespace src\Controller;
    use Src\Models\CompanyModel;

    class CompanyController {
        private $db = null;
        private $requestMethod = null;
        private $CompanyModel;
        private $companyId = null;

        public function __construct($db, $requestMethod, array $uri) {
            $this->db = $db;
            $this->requestMethod = $requestMethod;
            $this->CompanyModel = new CompanyModel($db);
            $this->companyId = $uri;
        }

        public function process_request() {
            switch($this->requestMethod) {
                case 'POST':
                        $response = $this->insert_company_from_request();
                break;
                case 'GET':
                    $response = $this->get_company($this->companyId[4]);
                break;

                case 'PUT':
                    $response = $this->update_company_from_request($this->companyId[4]);
                break;

                case 'DELETE':
                    $response = $this->delete_company_from_request($this->companyId[4]);
                break;

            }

            header($response['status_code_header']);
            if(isset($response['body'])) {
                echo $response['body'];
            }
        }

        public function insert_company_from_request() {
            $input = (array) json_decode(file_get_contents('php://input'), TRUE);
            $this->CompanyModel->add_company($input);
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = null;
            return $response;
        }

        public function get_company($id) {
            $result = $this->CompanyModel->get_company($id);

            
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
 
        public function update_company_from_request($id){
            $input = (array) json_decode(file_get_contents('php://input'), TRUE);
            $this->CompanyModel->update_company($input,$id);
            $response['status_code_header'] = 'HTTP/1.1 201 Updated';
            $response['body'] = null;
            return $response;

        }

        public function delete_company_from_request($id){
            $input = (array) json_decode(file_get_contents('php://input'), TRUE);
            $this->CompanyModel->delete_company($id);
            $response['status_code_header'] = 'HTTP/1.1 201 Deleted';
            $response['body'] = null;
            return $response;
        }
    }

?>