<?php

    namespace src\Controller;
    use Src\Models\CategoryModel;

    class CategoryController {
        private $db = null;
        private $requestMethod = null;
        private $CategoryModel;
        private $categoryId = null;

        public function __construct($db, $requestMethod, array $uri) {
            $this->db = $db;
            $this->requestMethod = $requestMethod;
            $this->CategoryModel = new CategoryModel($db);
            $this->categoryId = $uri;
        }

        public function process_request() {
            switch($this->requestMethod) {
                case 'POST':
                        $response = $this->insert_category_from_request();
                break;
                case 'GET':
                    if(isset($this->categoryId[4]))
                    {
                        $response = $this->get_category($this->categoryId[4]);
                    } else {
                        $response = $this->get_all_category();
                    }
                break;

                case 'PUT':
                    $response = $this->update_category_from_request($this->categoryId[4]);
                break;

                case 'DELETE':
                    $response = $this->delete_category_from_request($this->categoryId[4]);
                break;

            }

            header($response['status_code_header']);
            if(isset($response['body'])) {
                echo $response['body'];
            }
        }

        public function insert_category_from_request() {
            $input = (array) json_decode(file_get_contents('php://input'), TRUE);
            $this->CategoryModel->add_category($input);
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = null;
            return $response;
        }

        public function get_category($id) {
            $result = $this->CategoryModel->get_category($id);
            
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

        public function get_all_category() {
            $result = $this->CategoryModel->get_all_category();
            
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
 
        public function update_category_from_request($id){
            $input = (array) json_decode(file_get_contents('php://input'), TRUE);
            $this->CategoryModel->update_category($input,$id);
            $response['status_code_header'] = 'HTTP/1.1 201 Updated';
            $response['body'] = null;
            return $response;

        }

        public function delete_category_from_request($id){
            $input = (array) json_decode(file_get_contents('php://input'), TRUE);
            $this->CategoryModel->delete_category($id);
            $response['status_code_header'] = 'HTTP/1.1 201 Deleted';
            $response['body'] = null;
            return $response;
        }
    }

?>