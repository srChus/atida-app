<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 */
class ProductsController extends AppController
{
	
	public function initialize(): void
    {
        parent::initialize();

        $this->loadModel("Products");
    }


	// List products api
    public function index()
    {
        $this->request->allowMethod(["get"]);

        $Products = $this->Products->find()->toList();

        $this->set([
            "status" => true,
            "message" => "Products list",
            "data" => $Products
        ]);

        $this->viewBuilder()->setOption("serialize", ["status", "message", "data"]);
    }

     // Add products api
    public function add()
    {
         $this->request->allowMethod(["post"]);

        // form data
         $formData = $this->request->getData();
       
        // code check rules
        $productData = $this->Products->find()->where([
            "code" => $formData['code']
        ])->first();

        if (!empty($productData)) {
            // already exists
            $status = false;
            $message = "Product code already exists";
        } else {
            // insert new product
            $productObject = $this->Products->newEmptyEntity();

            $productObject = $this->Products->patchEntity($productObject, $formData);

            if ($this->Products->save($productObject)) {
                // success response
                $status = true;
                $message = "Product has been created";
            } else {
                // error response
                $status = false;
                $message = "Failed to create product";
            }
        }

        $this->set([
            "status" => $status,
            "message" => $message
        ]);

        $this->viewBuilder()->setOption("serialize", ["status", "message"]);
    }


    // Update product
    public function update()
    {
        $this->request->allowMethod(["put", "post"]);

        $product_id = $this->request->getParam("id");

        $productInfo = $this->request->getData();

        // employee check
        $product = $this->Products->get($product_id);

        if (!empty($product)) {
            // product exists
            $product = $this->Products->patchEntity($product, $productInfo);

            if ($this->Products->save($product)) {
                // success response
                $status = true;
                $message = "Product has been updated";
            } else {
                // error response
                $status = false;
                $message = "Failed to update product";
            }
        } else {
            // product not found
            $status = false;
            $message = "Product Not Found";
        }

        $this->set([
            "status" => $status,
            "message" => $message
        ]);

        $this->viewBuilder()->setOption("serialize", ["status", "message"]);
    }



     // Delete product api
    public function delete()
    {
        $this->request->allowMethod(["post"]);
        
        $product_id = $this->request->getParam("id");

        $product = $this->Products->get($product_id);

        if (!empty($product)) {
            // product found
            if ($this->Products->delete($product)) {
                // product deleted
                $status = true;
                $message = "Product has been deleted";
            } else {
                // failed to delete
                $status = false;
                $message = "Failed to delete product";
            }
        } else {
            // not found
            $status = false;
            $message = "Product doesn't exists";
        }

        $this->set([
            "status" => $status,
            "message" => $message
        ]);

        $this->viewBuilder()->setOption("serialize", ["status", "message"]);
    }


     // Update product
    public function stockUpdate()
    {
        $this->request->allowMethod(["put", "post"]);
        $product_id = $this->request->getParam("id");
        $productInfo = $this->request->getData();

        // product check
        $product = $this->Products->get($product_id);

        //var_dump($product["stock"]);

        if (!empty($product)) {
                // product exists
		 	$product_data = [
		       "stock" => $product["stock"]+$productInfo["stock"]
		    ];

			$product = $this->Products->patchEntity($product, $product_data);

            if ($this->Products->save($product)) {
                // success response
                $status = true;
                $message = "Product has been updated";
            } else {
                // error response
                $status = false;
                $message = "Failed to update product";
            }
        } else {
            // product not found
            $status = false;
            $message = "Product Not Found";
        }

        $this->set([
            "status" => $status,
            "message" => $message
        ]);

        $this->viewBuilder()->setOption("serialize", ["status", "message"]);
    }



}
