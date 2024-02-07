<?php

    namespace src\Controller;
    use Src\Models\ProductModel;

    class ProductController {
        private $db = null;
        private $requestMethod = null;
        private $ProductModel;
        private $productId = null;

        public function __construct($db, $requestMethod, array $uri) {
            $this->db = $db;
            $this->requestMethod = $requestMethod;
            $this->ProductModel = new ProductModel($db);
            $this->productId = $uri;
        }

        public function process_request() {
            switch($this->requestMethod) {
                case 'POST':
                        $response = $this->insert_product_from_request();
                break;
                case 'GET':
                    if(isset($this->productId[4]))
                    {
                        if(($this->productId[4] == "category")) {
                            $response = $this->get_products_by_category($this->productId[5]);
                        } elseif ($this->productId[4] == "company") {
                            $response = $this->get_products_by_company($this->productId[5]);
                        } else {
                            $response = $this->get_product($this->productId[4]);
                        }
                    } else {
                        $response = $this->get_all_product();
                    }
                break;

                case 'PUT':
                    $response = $this->update_product_from_request($this->productId[4]);
                break;

                case 'DELETE':
                    $response = $this->delete_product_from_request($this->productId[4]);
                break;

            }
            
            header($response['status_code_header']);
            if(isset($response['body'])) {
                echo $response['body'];
            }
        }

        public function insert_product_from_request() {
            $input = (array) json_decode(file_get_contents('php://input'), TRUE);
            $this->ProductModel->add_product($input);
            $response['status_code_header'] = 'HTTP/1.1 201 Created';
            $response['body'] = null;
            return $response;
        }

        public function get_product($id) {
            $result = $this->ProductModel->get_product($id);
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

        public function get_products_by_category($id) {
            $result = $this->ProductModel->get_products_by_category($id);
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

        public function get_products_by_company($id) {
            $result = $this->ProductModel->get_products_by_company($id);
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

        public function get_all_product() {
            $result = $this->ProductModel->get_all_product((isset($_GET["page"]) ? $_GET["page"] : 1), (isset($_GET["limit"]) ? $_GET["limit"] : 10));
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
 
        public function update_product_from_request($id){
            $input = (array) json_decode(file_get_contents('php://input'), TRUE);
            $this->ProductModel->update_product($input,$id);
            $response['status_code_header'] = 'HTTP/1.1 201 Updated';
            $response['body'] = null;
            return $response;

        }

        public function delete_product_from_request($id){
            $input = (array) json_decode(file_get_contents('php://input'), TRUE);
            $this->ProductModel->delete_product($id);
            $response['status_code_header'] = 'HTTP/1.1 201 Deleted';
            $response['body'] = null;
            return $response;
        }
    }

?>