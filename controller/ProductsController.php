<?php

require_once 'model/ProductLogic.php';

class ProductsController
{
    public function __construct()
    {
        $this->ProductLogic = new ProductLogic();
    }

    public function handleRequest()
    {
        try {
            $op = isset($_REQUEST['op']) ? $_REQUEST['op'] : null;
            switch ($op) {
                case 'create':
                    $this->collectCreateProduct(
                        $_REQUEST["title"],
                        $_REQUEST["ean"],
                        $_REQUEST["sku"],
                        $_REQUEST["price"],
                        $_FILES["img_path"],
                        $_REQUEST["description"],
                        $_REQUEST["brand"],
                        $_REQUEST["platform"],
                        $_REQUEST["own_display"],
                        $_REQUEST["resolution"],
                        $_REQUEST["pov"],
                        $_REQUEST["refresh"],
                        $_REQUEST["min_phone_size"],
                        $_REQUEST["max_phone_size"],
                        $_REQUEST["accelerometer"],
                        $_REQUEST["camera"],
                        $_REQUEST["gyroscoop"],
                        $_REQUEST["headphone"],
                        $_REQUEST["microphone"],
                        $_REQUEST["adjustable_lenses"],
                        $_REQUEST["eyetracking"],
                        $_REQUEST["handtracking"],
                        $_REQUEST["magnetometer"],
                        $_REQUEST["speakers"],
                        $_REQUEST["connection_c"],
                        $_REQUEST["connection_w"],
                        $_REQUEST["connection_b"],
                        $_REQUEST["remote_controll"],
                        $_REQUEST["controllers"],
                        $_REQUEST["cables"],
                        $_REQUEST["tracking_stations"],
                        $_REQUEST["height"],
                        $_REQUEST["width"],
                        $_REQUEST["dept"],
                        $_REQUEST["weight"],
                        $_REQUEST["color"],
                        $_REQUEST["released"],
                        $_REQUEST["series"]
                    );
                    break;
                case 'overviewproducts':
                    $this->collectProductOverview();
                    break;
                case 'updateform':
                    $this->collectUpdateProductForm($_REQUEST["id"]);
                    break;
                case 'updateproduct':
                    $this->collectUpdateProduct(
                        $_REQUEST["id"],
                        $_REQUEST["title"],
                        $_REQUEST["ean"],
                        $_REQUEST["sku"],
                        $_REQUEST["price"],
                        $_FILES["img_path"],
                        $_REQUEST["description"],
                        $_REQUEST["brand"],
                        $_REQUEST["platform"],
                        $_REQUEST["own_display"],
                        $_REQUEST["resolution"],
                        $_REQUEST["pov"],
                        $_REQUEST["refresh"],
                        $_REQUEST["min_phone_size"],
                        $_REQUEST["max_phone_size"],
                        $_REQUEST["accelerometer"],
                        $_REQUEST["camera"],
                        $_REQUEST["gyroscoop"],
                        $_REQUEST["headphone"],
                        $_REQUEST["microphone"],
                        $_REQUEST["adjustable_lenses"],
                        $_REQUEST["eyetracking"],
                        $_REQUEST["handtracking"],
                        $_REQUEST["magnetometer"],
                        $_REQUEST["speakers"],
                        $_REQUEST["connection_c"],
                        $_REQUEST["connection_w"],
                        $_REQUEST["connection_b"],
                        $_REQUEST["remote_controll"],
                        $_REQUEST["controllers"],
                        $_REQUEST["cables"],
                        $_REQUEST["tracking_stations"],
                        $_REQUEST["height"],
                        $_REQUEST["width"],
                        $_REQUEST["dept"],
                        $_REQUEST["weight"],
                        $_REQUEST["color"],
                        $_REQUEST["released"],
                        $_REQUEST["series"]
                    );
                    break;
                case 'deleteproductconfirm':
                    $this->collectDeleteConfirm($_REQUEST["id"]);
                    break;
                case 'delete':
                    $this->collectDeleteProduct($_REQUEST["id"]);
                    break;
                case 'reads':
                    $this->collectAllProducts();
                    break;
                case 'createform':
                    $this->collectCreateProductForm();
                    break;
                case 'adminUpdateForm':
                    $this->collectUpdateContentPage();
                    break;
                case 'adminUpdateContent':
                    $this->updateContentPage($_REQUEST["call_to_action"]);
                    break;
                case 'adminOverviewOrders':
                    $this->overviewOrders();
                    break;
                case 'details':
                    $this->collectDetailsProduct($_REQUEST['id']);
                    break;
                case 'contact':
                    $this->collectContactDetails();
                    break;
                case 'policy':
                    $this->collectPolicy();
                    break;
                case 'privecy':
                    $this->collectPrivecy();
                    break;
                case 'checkout':
                    $this->collectCheckoutForm(
                        $_REQUEST["id"]
                    );
                    break;
                case 'createOrder';
                    $this->checkOut(
                        $_REQUEST["product"],
                        $_REQUEST["id"],
                        $_REQUEST["total_price"],
                        $_REQUEST["sex"],
                        $_REQUEST["firstname"],
                        $_REQUEST["insertion"],
                        $_REQUEST["lastname"],
                        $_REQUEST["city"],
                        $_REQUEST["street"],
                        $_REQUEST["house"],
                        $_REQUEST["zipcode"],
                        $_REQUEST["mail"],
                        $_REQUEST["phone"],
                        $_REQUEST["order_date"]
                    );
                    break;
                case 'contactMail':
                    $this->sendContactMail(
                        $_REQUEST['name'],
                        $_REQUEST['subject'],
                        $_REQUEST['email'],
                        $_REQUEST['description']
                    );
                    break;
                case 'archiveproductconfirm':
                    $this->archiveproduct($_REQUEST["id"]);
                    break;
                case 'login':
                    $this->collectLoginForm();
                    break;
                case 'logincheck':
                    $this->login($_REQUEST["username"], $_REQUEST["password"]);
                    break;
                case 'logout':
                    $this->logout();
                    break;
                default:
                    $this->collectAllProducts();
                    break;
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function collectLoginForm()
    {
        $login = $this->ProductLogic->loginform();

        require_once "./view/login.php";
    }

    public function login($username,$password)
    {
        $this->ProductLogic->login($username,$password);
    }

    public function logout()
    {
        $this->ProductLogic->logout();
    }

    public function archiveproduct($id)
    {
        $this->ProductLogic->archiveProduct($id);

        header("Location: ./?op=overviewproducts");
    }

    public function collectDeleteConfirm($id)
    {
        $overview = $this->ProductLogic->deleteConfirmationProduct($id);

        require_once "./view/product.php";
    }

    public function collectDeleteProduct($id)
    {
        $this->ProductLogic->deleteProduct($id);

        $overview = $this->ProductLogic->comfirmedProduct("Het product is succesvol verwijderd");

        require_once "./view/product.php";
    }

    public function collectCreateProduct($title, $ean, $sku, $price, $img_path, $description, $brand, $platform, $own_display, $resolution, $pov, $refresh, $min_phone_size, $max_phone_size, $accelerometer, $camera, $gyroscoop, $headphone, $microphone, $adjustable_lenses, $eyetracking, $handtracking, $magnetometer, $speakers, $connection_c, $connection_w, $connection_b, $remote_controll, $controllers, $cables, $tracking_stations, $height, $width, $dept, $weight, $color, $released, $series)
    {
        $this->ProductLogic->createProduct($title, $ean, $sku, $price, $img_path, $description, $brand, $platform, $own_display, $resolution, $pov, $refresh, $min_phone_size, $max_phone_size, $accelerometer, $camera, $gyroscoop, $headphone, $microphone, $adjustable_lenses, $eyetracking, $handtracking, $magnetometer, $speakers, $connection_c, $connection_w, $connection_b, $remote_controll, $controllers, $cables, $tracking_stations, $height, $width, $dept, $weight, $color, $released, $series);
        
        $overview = $this->ProductLogic->comfirmedProduct("Het product is succesvol aangemaakt");

        require_once "./view/product.php";
    }

    public function collectProductOverview()
    {
       $overview = $this->ProductLogic->updateProductoverview();

       require_once "./view/product.php";
    }

    public function collectUpdateProductForm($id)
    {
        $overview = $this->ProductLogic->updateProductForm($id);

        require_once "./view/product.php";
    }

    public function collectUpdateProduct($id, $title, $ean, $sku, $price, $img_path, $description, $brand, $platform, $own_display, $resolution, $pov, $refresh, $min_phone_size, $max_phone_size, $accelerometer, $camera, $gyroscoop, $headphone, $microphone, $adjustable_lenses, $eyetracking, $handtracking, $magnetometer, $speakers, $connection_c, $connection_w, $connection_b, $remote_controll, $controllers, $cables, $tracking_stations, $height, $width, $dept, $weight, $color, $released, $series)
    {
        $this->ProductLogic->updateProduct($id, $title, $ean, $sku, $price, $img_path, $description, $brand, $platform, $own_display, $resolution, $pov, $refresh, $min_phone_size, $max_phone_size, $accelerometer, $camera, $gyroscoop, $headphone, $microphone, $adjustable_lenses, $eyetracking, $handtracking, $magnetometer, $speakers, $connection_c, $connection_w, $connection_b, $remote_controll, $controllers, $cables, $tracking_stations, $height, $width, $dept, $weight, $color, $released, $series);
        
        $overview = $this->ProductLogic->comfirmedProduct("Het product is succesvol geüpdate");

        require_once "./view/product.php";
    }

    public function collectCreateProductForm()
    {
        $product = $this->ProductLogic->createProductForm();

        require_once "./view/addProduct.php";
    }

    public function collectUpdateContentPage()
    {
        $admin = $this->ProductLogic->collectUpdateContentPage();
                
        require_once "./view/adminPortal.php";
    }

    public function updateContentPage($call_to_action)
    {
        $this->ProductLogic->updateContentPage($call_to_action);
    }

    public function overviewOrders()
    {
        $orders = $this->ProductLogic->readOverviewOrders();

        require_once "./view/overviewOrders.php";
    }

    public function collectAllProducts()
    {
        $allproducts = $this->ProductLogic->readAllProducts();

        require_once "./view/productGrid.php";
    }

    public function collectDetailsProduct($id)
    {
        $detailsproduct = $this->ProductLogic->readDetailsProduct($id);

        require_once "./view/details.php";
    }

    public function collectContactDetails()
    {
        $contact = $this->ProductLogic->readContactDetails();

        require_once "./view/contact.php";
    }

    public function collectPolicy()
    {
        require_once "./view/policy.php";
    }

    public function collectPrivecy()
    {
        require_once "./view/privacy.php";
    }

    public function sendContactMail($name, $subject, $email, $description)
    {
        $this->ProductLogic->sendContactMail($name, $subject, $email, $description);
        $contact = $this->ProductLogic->readContactDetails();
        require_once "./view/contact.php";
    }

    public function collectCheckoutForm($id)
    {
        $checkout = $this->ProductLogic->readCheckoutForm($id);
        require_once "./view/checkOutForm.php";
    }

    public function checkOut($product, $id, $total_price, $sex, $firstname, $insertion, $lastname, $city, $street, $house, $zipcode, $mail, $phone, $order_date)
    {
        $this->ProductLogic->createOrder($product, $id, $total_price, $sex, $firstname, $insertion, $lastname, $city, $street, $house, $zipcode, $mail, $phone, $order_date);
        require_once "./view/confirmation.php";

    }
}
