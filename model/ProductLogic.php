<?php

require_once "DataHandler.php";


class ProductLogic
{


    public function __construct()
    {
        $this->DataHandler = new Datahandler('localhost', 'mysql', 'multiversum', 'admin', 'lhXBKPHM41xukPZ6');
    }

    public function loginForm()
    {
        $login = '<div class="login-wrapper">
            <div class="login-form">
                <div class="brand">
                    <img src="./view/assets/img/vr.svg" alt="">
                </div>
                <form action="./?op=logincheck" method="post">
                    <label for="username">Gebruikersnaam</label>
                    <input type="text" id="username" name=username />
                    <label for="password">Wachtwoord</label>
                    <input type="password" id="password" name=password />
                    <input type="submit" value="Login" />
                </form>
            </div>
        </div>';

        return $login;
    }

    public function login($username,$password)
    {
        try {
            $sql = 'SELECT * FROM users WHERE username=:username';
            $res = $this->DataHandler->prepared($sql);
            $res->bindParam(':username', $username, PDO::PARAM_STR);
            $res->execute();
            if ($res->rowCount() > 0) {
                $res->setFetchMode(PDO::FETCH_ASSOC);
                $user = $res->fetch();
                if (password_verify($password, $user["password"])) {
                    $_SESSION["login"] = TRUE;
                    header("Location: ./?op=overviewproducts");
                } else {
                    header("Location: ./?op=login");
                }
            } else {
                header("Location: ./?op=login");
            }
            
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        header("Location: ./");
    }

    public function deleteConfirmationProduct($id)
    {
        if ((isset($_SESSION["login"])) && ($_SESSION["login"] == TRUE)) {
            $delete = '<div class="admin-page-wrapper">
                <div class="side-nav">
                    <div class="brand">
                        <img src="./view/assets/img/vr.svg" alt="">
                    </div>
                    <div class="admin-menu">
                            <nav class="navigation">
                                <ul class="mainmenu">
                                    <li class="active"><a href="./?op=overviewproducts">Producten</a></li>
                                    <li><label for="content">Content Update +</label><input type="checkbox" id="content">
                                        <ul class="submenu">
                                            <li><a href="./?op=adminUpdateForm">hoofd pagina</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="./?op=adminOverviewOrders">Overzicht orders</a></li>
                                    <li><a href="./?op=logout">Uitloggen</a></li>
                                </ul>
                            </nav>
                        </div>
                </div>
                <div class="admin-page">
                    <div class="confirm-delete-wrapper">
                        <h1>Weet je zeker dat je het product wilt verwijderen?</h1>
                        <div class="confirm-delete">
                            <a href="./?op=overviewproducts"><button>Nee</button></a>
                            <a href="./?op=delete&id='.$id.'"><button>Ja</button></a>
                        </div>
                    </div>
                </div>
            </div>';

            return $delete;
        } else {
            header("Location: ./");
        }
    }

    public function deleteProduct($id)
    {
        try {
            if ((isset($_SESSION["login"])) && ($_SESSION["login"] == TRUE)) {
                $sql = 'DELETE FROM product WHERE id=:id';
                $res = $this->DataHandler->prepared($sql);
                $res->bindParam(':id', $id, PDO::PARAM_INT);
                $res->execute();
                return;
            } else {
                header("Location: ./");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function archiveProduct($id)
    {
        try {
            if ((isset($_SESSION["login"])) && ($_SESSION["login"] == TRUE)) {
                $sql = 'SELECT archieved FROM product WHERE id=:id';
                $res = $this->DataHandler->prepared($sql);
                $res->bindParam(':id', $id, PDO::PARAM_INT);
                $res->execute();
                $res->setFetchMode(PDO::FETCH_ASSOC);
                $archieved = $res->fetch();
                $archieved = $archieved["archieved"];

                if ($archieved == 0) {
                    $archieved = 1;
                } else {
                    $archieved = 0;
                }

                $sql = 'UPDATE `product` SET archieved=:archieved WHERE id=:id';
                $res = $this->DataHandler->prepared($sql);
                $res->bindParam(':id', $id, PDO::PARAM_INT);
                $res->bindParam(':archieved', $archieved, PDO::PARAM_BOOL);
                $res->execute();
                return;
            } else {
                header("Location: ./");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function createProductForm()
    {
        if ((isset($_SESSION["login"])) && ($_SESSION["login"] == TRUE)) {
            echo "test";
            $product = '<div class="admin-page-wrapper">
                    <div class="side-nav">
                        <div class="brand">
                            <img src="./view/assets/img/vr.svg" alt="">
                        </div>
                        <div class="admin-menu">
                            <nav class="navigation">
                                <ul class="mainmenu">
                                    <li class="active"><a href="./?op=overviewproducts">Producten</a></li>
                                    <li><label for="content">Content Update +</label><input type="checkbox" id="content">
                                        <ul class="submenu">
                                            <li><a href="./?op=adminUpdateForm">hoofd pagina</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="./?op=adminOverviewOrders">Overzicht orders</a></li>
                                    <li><a href="./?op=logout">Uitloggen</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="admin-page">
                        <div class="admin-create-wrapper">
                            <h1>Product toevoegen</h1>
                            <div class="admin-create-product">
                                <form action="./?op=create" method="post" enctype="multipart/form-data">
                                    <table style="float: left;">
                                        <tr>
                                            <th>Titel</th>
                                            <td><input type="text" name="title" required></td>
                                        </tr>
                                        <tr>
                                            <th>EAN</th>
                                            <td><input type="text" name="ean"></td>
                                        </tr>
                                        <tr>
                                            <th>SKU</th>
                                            <td><input type="text" name="sku"></td>
                                        </tr>
                                        <tr>
                                            <th>Prijs</th>
                                            <td><input type="number" name="price"></td>
                                        </tr>
                                        <tr>
                                            <th>Merk</th>
                                            <td><input type="text" name="brand"></td>
                                        </tr>
                                        <tr>
                                            <th>Platform</th>
                                            <td><input type="text" name="platform"></td>
                                        </tr>
                                        <tr>
                                            <th>Resolutie</th>
                                            <td><input type="text" name="resolution"></td>
                                        </tr>
                                        <tr>
                                            <th>Gezichtsveld</th>
                                            <td><input type="number" name="pov"></td>
                                        </tr>
                                        <tr>
                                            <th>Refresh rate</th>
                                            <td><input type="number" name="refresh"></td>
                                        </tr>
                                        <tr>
                                            <th>Minimum mobiel groote</th>
                                            <td><input type="number" name="min_phone_size"></td>
                                        </tr>
                                        <tr>
                                            <th>Maximum mobiel groote</th>
                                            <td><input type="number" name="max_phone_size"></td>
                                        </tr>
                                        <tr>
                                            <th>kabel connecties</th>
                                            <td><input type="text" name="connection_c"></td>
                                        </tr>
                                        <tr>
                                            <th>Wifi connecties</th>
                                            <td><input type="text" name="connection_w"></td>
                                        </tr>
                                        <tr>
                                            <th>Controllers</th>
                                            <td><input type="number" name="controllers"></td>
                                        </tr>
                                        <tr>
                                            <th>Kabels</th>
                                            <td><input type="text" name="cables"></td>
                                        </tr>
                                        <tr>
                                            <th>Tracking stations</th>
                                            <td><input type="number" name="tracking_stations"></td>
                                        </tr>
                                        <tr>
                                            <th>Hoogte (cm)</th>
                                            <td><input type="number" name="height"></td>
                                        </tr>
                                        <tr>
                                            <th>Breedte (cm)</th>
                                            <td><input type="number" name="width"></td>
                                        </tr>
                                        <tr>
                                            <th>Diepte (cm)</th>
                                            <td><input type="number" name="dept"></td>
                                        </tr>
                                        <tr>
                                            <th>Gewicht (gram)</th>
                                            <td><input type="number" name="weight"></td>
                                        </tr>
                                        <tr>
                                            <th>Kleur</th>
                                            <td><input type="text" name="color"></td>
                                        </tr>
                                        <tr>
                                            <th>Uitgave jaar</th>
                                            <td><input type="date" name="released"></td>
                                        </tr>
                                        <tr>
                                            <th>Serie</th>
                                            <td><input type="text" name="series"></td>
                                        </tr>
                                        <tr>
                                            <th>Foto</th>
                                            <td><input type="file" name="img_path" id="fileToUpload" required></td>
                                        </tr>
                                    </table>
                                    <table style="float: right;">
                                        <tr>
                                            <th>Heeft eigen display</th>
                                            <td>
                                                <input type="radio" value="1" id="own_display_true" name="own_display">
                                                <label for="own_display_true">Ja</label>
                                                <input type="radio" value="0" id="own_display_false" name="own_display">
                                                <label for="own_display_false">Nee</label>
                                                <input type="radio" value="0" id="own_display_false" name="own_display" hidden checked>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Accelerometer</th>
                                            <td>
                                                <input type="radio" value="1" id="accelerometer_true" name="accelerometer">
                                                <label for="accelerometer_true">Ja</label>
                                                <input type="radio" value="0" id="accelerometer_false" name="accelerometer">
                                                <label for="accelerometer_false">Nee</label>
                                                <input type="radio" value="0" id="accelerometer_false" name="accelerometer" hidden checked>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Camera</th>
                                            <td>
                                                <input type="radio" value="1" id="camera_true" name="camera">
                                                <label for="camera_true">Ja</label>
                                                <input type="radio" value="0" id="camera_false" name="camera">
                                                <label for="camera_false">Nee</label>
                                                <input type="radio" value="0" id="camera_false" name="camera" hidden checked>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Gyroscoop</th>
                                            <td>
                                                <input type="radio" value="1" id="gyroscoop_true" name="gyroscoop">
                                                <label for="gyroscoop_true">Ja</label>
                                                <input type="radio" value="0" id="gyroscoop_false" name="gyroscoop">
                                                <label for="gyroscoop_false">Nee</label>
                                                <input type="radio" value="0" id="gyroscoop_false" name="gyroscoop" hidden checked>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Koptelefoon</th>
                                            <td>
                                                <input type="radio" value="1" id="headphone_true" name="headphone">
                                                <label for="headphone_true">Ja</label>
                                                <input type="radio" value="0" id="headphone_false" name="headphone">
                                                <label for="headphone_false">Nee</label>
                                                <input type="radio" value="0" id="headphone_false" name="headphone" hidden checked>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Microfoon</th>
                                            <td>
                                                <input type="radio" value="1" id="microphone_true" name="microphone">
                                                <label for="microphone_true">Ja</label>
                                                <input type="radio" value="0" id="microphone_false" name="microphone">
                                                <label for="microphone_false">Nee</label>
                                                <input type="radio" value="0" id="microphone_false" name="microphone" hidden checked>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Herstelbare lensen</th>
                                            <td>
                                                <input type="radio" value="1" id="adjustable_lenses_true" name="adjustable_lenses">
                                                <label for="adjustable_lenses_true">Ja</label>
                                                <input type="radio" value="0" id="adjustable_lenses_false" name="adjustable_lenses">
                                                <label for="adjustable_lenses_false">Nee</label>
                                                <input type="radio" value="0" id="adjustable_lenses_false" name="adjustable_lenses" hidden checked>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Oog volgend</th>
                                            <td>
                                                <input type="radio" value="1" id="eyetracking_true" name="eyetracking">
                                                <label for="eyetracking_true">Ja</label>
                                                <input type="radio" value="0" id="eyetracking_false" name="eyetracking">
                                                <label for="eyetracking_false">Nee</label>
                                                <input type="radio" value="0" id="eyetracking_false" name="eyetracking" hidden checked>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Hand tracerend</th>
                                            <td>
                                                <input type="radio" value="1" id="handtracking_true" name="handtracking">
                                                <label for="handtracking_true">Ja</label>
                                                <input type="radio" value="0" id="handtracking_false" name="handtracking">
                                                <label for="handtracking_false">Nee</label>
                                                <input type="radio" value="0" id="handtracking_false" name="handtracking" hidden checked>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Magnetometer</th>
                                            <td>
                                                <input type="radio" value="1" id="magnetometer_true" name="magnetometer">
                                                <label for="magnetometer_true">Ja</label>
                                                <input type="radio" value="0" id="magnetometer_false" name="magnetometer">
                                                <label for="magnetometer_false">Nee</label>
                                                <input type="radio" value="0" id="magnetometer_false" name="magnetometer" hidden checked>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Speakers</th>
                                            <td>
                                                <input type="radio" value="1" id="speakers_true" name="speakers">
                                                <label for="speakers_true">Ja</label>
                                                <input type="radio" value="0" id="speakers_false" name="speakers">
                                                <label for="speakers_false">Nee</label>
                                                <input type="radio" value="0" id="speakers_false" name="speakers" hidden checked>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Bluethooth</th>
                                            <td>
                                                <input type="radio" value="1" id="connection_b_true" name="connection_b">
                                                <label for="connection_b_true">Ja</label>
                                                <input type="radio" value="0" id="connection_b_false" name="connection_b">
                                                <label for="connection_b_false">Nee</label>
                                                <input type="radio" value="0" id="connection_b_false" name="connection_b" hidden checked>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Afstands bediening</th>
                                            <td>
                                                <input type="radio" value="1" id="remote_controll_true" name="remote_controll">
                                                <label for="remote_controll_true">Ja</label>
                                                <input type="radio" value="0" id="remote_controll_false" name="remote_controll">
                                                <label for="remote_controll_false">Nee</label>
                                                <input type="radio" value="0" id="remote_controll_false" name="remote_controll" hidden checked>
                                            </td>
                                        </tr>
                                    </table>
                                    <br>
                                    <div class="description">
                                        <label for="description">Description</label>
                                        <textarea id="description" name="description"></textarea>
                                    </div>

                                    <input type="submit" value="Send">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>';

            return $product;
        } else {
            header("Location: ./");
        }
    }

    public function createProduct($title, $ean, $sku, $price, $img_path, $description, $brand, $platform, $own_display, $resolution, $pov, $refresh, $min_phone_size, $max_phone_size, $accelerometer, $camera, $gyroscoop, $headphone, $microphone, $adjustable_lenses, $eyetracking, $handtracking, $magnetometer, $speakers, $connection_c, $connection_w, $connection_b, $remote_controll, $controllers, $cables, $tracking_stations, $height, $width, $dept, $weight, $color, $released, $series)
    {
        try {
            if ((isset($_SESSION["login"])) && ($_SESSION["login"] == TRUE)) {
                if ($img_path['size'] == 0 && $img_path['error'] == 4)
                {
                    $img_path = "";
                } else {
                    $img_path = $this->uploadFile($img_path);
                }

                $sql = "INSERT INTO `product` (`id`, `title`, `ean`, `sku`, `price`, `img_path`, `description`, `brand`, `platform`, `own_display`, `resolution`, `pov`, `refresh`, `min_phone_size`, `Max_phone_size`, `accelerometer`, `camera`, `gyroscoop`, `headphone`, `microphone`, `adjustable_lenses`, `eyetracking`, `handtracking`, `magnetometer`, `speakers`, `connection_c`, `connection_w`, `connection_b`, `remote_controll`, `controllers`, `cables`, `tracking_stations`, `height`, `width`, `dept`, `weight`, `color`, `released`, `series`) 
                VALUES (NULL, :title, :ean, :sku, :price, :img_path, :description, :brand, :platform, :own_display, :resolution, :pov, :refresh, :min_phone_size, :max_phone_size, :accelerometer, :camera, :gyroscoop, :headphone, :microphone, :adjustable_lenses, :eyetracking, :handtracking, :magnetometer, :speakers, :connection_c, :connection_w, :connection_b, :remote_controll, :controllers, :cables, :tracking_stations, :height, :width, :dept, :weight, :color, :released, :series)";
                $res = $this->DataHandler->prepared($sql);
                $res->bindParam(':title', $title, PDO::PARAM_STR);
                $res->bindParam(':ean', $ean, PDO::PARAM_STR);
                $res->bindParam(':sku', $sku, PDO::PARAM_STR);
                $res->bindParam(':price', $price, PDO::PARAM_INT);
                $res->bindParam(':img_path', $img_path, PDO::PARAM_STR);
                $res->bindParam(':description', $description, PDO::PARAM_STR);
                $res->bindParam(':brand', $brand, PDO::PARAM_STR);
                $res->bindParam(':platform', $platform, PDO::PARAM_STR);
                $res->bindParam(':own_display', $own_display, PDO::PARAM_BOOL);
                $res->bindParam(':resolution', $resolution, PDO::PARAM_STR);
                $res->bindParam(':pov', $pov, PDO::PARAM_INT);
                $res->bindParam(':refresh', $refresh, PDO::PARAM_INT);
                $res->bindParam(':min_phone_size', $min_phone_size, PDO::PARAM_INT);
                $res->bindParam(':max_phone_size', $max_phone_size, PDO::PARAM_INT);
                $res->bindParam(':accelerometer', $accelerometer, PDO::PARAM_BOOL);
                $res->bindParam(':camera', $camera, PDO::PARAM_BOOL);
                $res->bindParam(':gyroscoop', $gyroscoop, PDO::PARAM_BOOL);
                $res->bindParam(':headphone', $headphone, PDO::PARAM_BOOL);
                $res->bindParam(':microphone', $microphone, PDO::PARAM_BOOL);
                $res->bindParam(':adjustable_lenses', $adjustable_lenses, PDO::PARAM_BOOL);
                $res->bindParam(':eyetracking', $eyetracking, PDO::PARAM_BOOL);
                $res->bindParam(':handtracking', $handtracking, PDO::PARAM_BOOL);
                $res->bindParam(':magnetometer', $magnetometer, PDO::PARAM_BOOL);
                $res->bindParam(':speakers', $speakers, PDO::PARAM_BOOL);
                $res->bindParam(':connection_c', $connection_c, PDO::PARAM_STR);
                $res->bindParam(':connection_w', $connection_w, PDO::PARAM_STR);
                $res->bindParam(':connection_b', $connection_b, PDO::PARAM_BOOL);
                $res->bindParam(':remote_controll', $remote_controll, PDO::PARAM_BOOL);
                $res->bindParam(':controllers', $controllers, PDO::PARAM_INT);
                $res->bindParam(':cables', $cables, PDO::PARAM_STR);
                $res->bindParam(':tracking_stations', $tracking_stations, PDO::PARAM_INT);
                $res->bindParam(':height', $height, PDO::PARAM_INT);
                $res->bindParam(':width', $width, PDO::PARAM_INT);
                $res->bindParam(':dept', $dept, PDO::PARAM_INT);
                $res->bindParam(':weight', $weight, PDO::PARAM_INT);
                $res->bindParam(':color', $color, PDO::PARAM_STR);
                $res->bindParam(':released', $released, PDO::PARAM_STR);
                $res->bindParam(':series', $series, PDO::PARAM_STR);
                $results = $res->execute();
                return $results;
            } else {
                header("Location: ./");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function uploadFile($file)
    {
        if ((isset($_SESSION["login"])) && ($_SESSION["login"] == TRUE)) {
            $target_dir = "./view/assets/img/";
            $target_file = $target_dir . basename($file["name"]);

            if (!file_exists('./view/assets/img')) {
                mkdir('./view/assets/img', 0777, true);
            }

            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                $file["url"] = $target_file;
            }

            return $file["url"];
        } else {
            header("Location: ./");
        }
    }

    public function readProduct($id)
    {
        try {
            $sql = 'SELECT * FROM product WHERE id=:id';
            $res = $this->DataHandler->prepared($sql);
            $res->bindParam(':id', $id, PDO::PARAM_INT);
            $res->execute();
            $res->setFetchMode(PDO::FETCH_ASSOC);
            $results = $res->fetch();
            return $results;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function readProducts()
    {
        try {
            $sql = 'SELECT * FROM Product';
            $res = $this->DataHandler->readsData($sql);
            $results = $res->fetchAll();
            return $results;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function readAllProducts()
    {

        try {
            $sql = 'SELECT COUNT(*) FROM product';
            $res = $this->DataHandler->readsData($sql);
            $total = $res->fetchColumn();
            if ($total > 0) {
                $limit = 10;

                $pages = ceil($total / $limit);

                $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
                    'options' => array(
                        'default'   => 1,
                        'min_range' => 1,
                    ),
                )));

                $offset = ($page - 1)  * $limit;

                $prevlink = ($page > 1) ? '<a href="?page=1" title="First page"><<</a> <a href="?page=' . ($page - 1) . '" title="Previous page"><</a>' : '<span class="disabled">&laquo;</span> <span class="disabled"><</span>';

                $nextlink = ($page < $pages) ? '<a href="?page=' . ($page + 1) . '" title="Next page">></a> <a href="?page=' . $pages . '" title="Last page">>></a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">></span>';

                $pagenation = '<div class="pagenation-wrapper">';
                $pagenation .= '<div id="paging"><p>' . $prevlink . ' Page ' . $page . ' of ' . $pages . ' pages ' . $nextlink . ' </p></div>';
                $pagenation .= '</div>';

                $sql = "SELECT * FROM content WHERE content_id=1";
                $res = $this->DataHandler->prepared($sql);
                $res->execute();
                $res->setFetchMode(PDO::FETCH_ASSOC);
                $content = $res->fetch();

                $sql = "SELECT * FROM product WHERE archieved=FALSE ORDER BY id LIMIT :limit OFFSET :offset";
                $res = $this->DataHandler->prepared($sql);

                $res->bindParam(':limit', $limit, PDO::PARAM_INT);
                $res->bindParam(':offset', $offset, PDO::PARAM_INT);
                $res->execute();

                if ($res->rowCount() > 0) {
                    $res->setFetchMode(PDO::FETCH_ASSOC);
                    $iterator = new IteratorIterator($res);

                    $products = "<div class=\"product-wrapper\">";
                    $products .= "<h1>" . $content["content"] . "</h1>";
                    $products .= "<div class=\"products\">";
                    foreach ($iterator as $row) {
                        $products .= "<a href=\"./?op=details&id=" . $row["id"] . "\" class=\"box\">";
                        $products .= "<div class=\"product-details\">";
                        $products .= "<div class=\"product-title\">";
                        $products .= "<p>" . $row["title"] . "</p>";
                        $products .= "</div>";
                        $products .= "<div class=\"product-image\">";
                        $products .= "<img src=\"" . $row["img_path"] . "\" alt=\"\">";
                        $products .= "</div>";
                        $products .= "<div class=\"product-price\">";
                        $products .= "<p>€ " . $row["price"] . "</p>";
                        $products .= "</div>";
                        $products .= "</div>";
                        $products .= "</a>";
                    }
                    $products .= "</div>";
                    $products .= "</div>";
                    $products .= $pagenation;
                    return $products;
                } else {
                    $products = '<div class="error-product-grid-wrapper">
                        <div class="error-product-grid">
                        <h1>Oops...</h1>
                        <p>We konden geen producten vinden!</p>
                        </div>
                    </div>';
                    return $products;
                }
            } else {
                $products = '<div class="error-product-grid-wrapper">
                    <div class="error-product-grid">
                    <h1>Oops...</h1>
                    <p>We konden geen producten vinden!</p>
                    </div>
                </div>';
                return $products;
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function readDetailsProduct($id)
    {
        try {
            $sql = 'SELECT * FROM product WHERE id=:id AND archieved=FALSE';
            $res = $this->DataHandler->prepared($sql);
            $res->bindParam(':id', $id, PDO::PARAM_INT);
            $res->execute();
            if ($res->rowCount() > 0) {
                $res->setFetchMode(PDO::FETCH_ASSOC);
                $results = $res->fetch();

                $own_display = ($results["own_display"] == TRUE) ? "Ja" : "Nee";
                $accelerometer = ($results["accelerometer"] == TRUE) ? "Ja" : "Nee";
                $gyroscoop = ($results["gyroscoop"] == TRUE) ? "Ja" : "Nee";
                $camera = ($results["camera"] == TRUE) ? "Ja" : "Nee";
                $headphone = ($results["headphone"] == TRUE) ? "Ja" : "Nee";
                $microphone = ($results["microphone"] == TRUE) ? "Ja" : "Nee";
                $adjustable_lenses = ($results["adjustable_lenses"] == TRUE) ? "Ja" : "Nee";
                $eyetracking = ($results["eyetracking"] == TRUE) ? "Ja" : "Nee";
                $handtracking = ($results["handtracking"] == TRUE) ? "Ja" : "Nee";
                $magnetometer = ($results["magnetometer"] == TRUE) ? "Ja" : "Nee";
                $speakers = ($results["speakers"] == TRUE) ? "Ja" : "Nee";
                $remote_controll = ($results["remote_controll"] == TRUE) ? "Ja" : "Nee";
                $connection_b = ($results["connection_b"] == TRUE) ? "Ja" : "Nee";
                $details = '<div class="product-container">
                <div class="product-box">
                <div class="top-details">
                <div class="img-container">
                <img src="' . $results["img_path"] . '" alt="">
                </div>
                <div class="product-details">
                <div class="product-title">
                <h1>' . $results["title"] . '</h1>
                </div>
                <div class="product-price">
                <p>Prijs: € ' . $results["price"] . '</p>
                </div>
                <div class="add-button">
                <a href="./?op=checkout&id=' . $results["id"] . '"><button>Afrekenen</button></a>
                </div>
                </div>
                </div>
                <div class="discription">
                <h1>Descriptie</h1>
                <p>' . $results["description"] . '</p>
                </div>
                <div class="specs">
                <h1 class="spec-center">Specificaties</h1>
                <div class="spec-container">
                <table>
                <tr>
                <th>Merk</th>
                <td>' . $results["brand"] . '</td>
                </tr>
                <tr>
                <th>Platform</th>
                <td>' . $results["platform"] . '</td>
                </tr>
                <tr>
                <th>EAN</th>
                <td>' . $results["ean"] . '</td>
                </tr>
                <tr>
                <th>SKU</th>
                <td>' . $results["sku"] . '</td>
                </tr>
                <tr>
                <th>Released</th>
                <td>' . $results["released"] . '</td>
                </tr>
                <tr>
                <th>Series</th>
                <td>' . $results["series"] . '</td>
                </tr>
                </table>
                <br>
                <table>
                <tr>
                <th>Own Display</th>
                <td>' . $own_display . '</td>
                </tr>
                <tr>
                <th>Resolution</th>
                <td>' . $results["resolution"] . '</td>
                </tr>
                <tr>
                <th>Point of View</th>
                <td>' . $results["pov"] . '</td>
                </tr>
                <tr>
                <th>Refresh Rate</th>
                <td>' . $results["refresh"] . '</td>
                </tr>
                </table>
                <br>
                <table>
                <tr>
                <th>Minimale telefoon grootte</th>
                <td>' . $results["min_phone_size"] . '</td>
                </tr>
                <tr>
                <th>Maximale telefoon grootte</th>
                <td>' . $results["max_phone_size"] . '</td>
                </tr>
                <tr>
                <th>Accelerometer</th>
                <td>' . $accelerometer . '</td>
                </tr>
                <tr>
                <th>Gyroscoop</th>
                <td>' . $gyroscoop . '</td>
                </tr>
                <tr>
                <th>Camera</th>
                <td>' . $camera . '</td>
                </tr>
                <tr>
                <th>Headphone</th>
                <td>' . $headphone . '</td>
                </tr>
                <tr>
                <th>Microphone</th>
                <td>' . $microphone . '</td>
                </tr>
                <tr>
                <th>Adjustable_lenses</th>
                <td>' . $adjustable_lenses . '</td>
                </tr>
                <tr>
                <th>Eyetracking</th>
                <td>' . $eyetracking . '</td>
                </tr>
                <tr>
                <th>Handtracking</th>
                <td>' . $handtracking . '</td>
                </tr>
                <tr>
                <th>Magnetometer</th>
                <td>' . $magnetometer . '</td>
                </tr>
                <tr>
                <th>Speakers</th>
                <td>' . $speakers . '</td>
                </tr>
                </table>
                <table>
                <tr>
                <th>Kabel Connecties</th>
                <td>' . $results["connection_c"] . '</td>
                </tr>
                <tr>
                <th>Internet Connectie</th>
                <td>' . $results["connection_w"] . '</td>
                </tr>
                <tr>
                <th>Bluetooth</th>
                <td>' . $connection_b . '</td>
                </tr>
                </table>
                <br>
                <table>
                <tr>
                <th>Remote controll</th>
                <td>' . $remote_controll . '</td>
                </tr>
                <tr>
                <th>Controllers</th>
                <td>' . $results["controllers"] . '</td>
                </tr>
                <tr>
                <th>Kabels</th>
                <td>' . $results["cables"] . '</td>
                </tr>
                <tr>
                <th>Tracking stations</th>
                <td>' . $results["tracking_stations"] . '</td>
                </tr>
                </table>
                <br>
                <table>
                <tr>
                <th>Hoogte</th>
                <td>' . $results["height"] . '</td>
                </tr>
                <tr>
                <th>Breedte</th>
                <td>' . $results["width"] . '</td>
                </tr>
                <tr>
                <th>Diepte</th>
                <td>' . $results["dept"] . '</td>
                </tr>
                <tr>
                <th>Gewicht</th>
                <td>' . $results["weight"] . '</td>
                </tr>
                <tr>
                <th>Kleur</th>
                <td>' . $results["color"] . '</td>
                </tr>
                </table>
                </div>
                </div>
                </div>
                </div>';

                return $details;
            } else {
                $details = '<div class="no-product-found-container">
                    <div class="no-product-found">
                        <h1>Helaas...</h1>
                        <p>Dit product bestaat niet!</p>
                        <button><a href="./">Terug naar de voorpagina</a></button>
                    </div>
                </div>';
                return $details;
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function readContactDetails()
    {
        try {
            $sql = 'SELECT * FROM contact';
            $res = $this->DataHandler->readsData($sql);
            $results = $res->fetchAll();
        } catch (Exception $e) {
            throw $e;
        }

        $contact = '<div class="main-container">
        <div class="contact-container">
        <div id="map"></div>
        <div class="contact-box">
        <h1>Waar zijn wij gevestiged?</h1><br>';
        foreach ($results as $key => $results2) {
            $contact .= '<p><b>Provincie </b>' . $results2["state"] . '</p>';
            $contact .= '<p><b>Stad: </b>' . $results2["city"] . '</p>';
            $contact .= '<p><b>Straat </b>' . $results2["street"] . '</p>';
            $contact .= '<p><b>Postcode </b>' . $results2["postcode"] . '</p>';
        }
        $contact .= '</div>
        </div>
        <div class="contactForm">
        <form action="?op=contactMail" method="post">
        <h1>Contacteer ons!</h1>
        <p>Vul alstublieft deze formulier in</p>
        <label for="naam"><b>Naam</b></label>
        <input type="text" placeholder="Uw naam" name="name">
        <label for="onderwerp"><b>Onderwerp</b></label>
        <input type="text" placeholder="Onderwerp betreffende contact" name="subject">
        <label for="email"><b>Email</b></label>
        <input type="text" placeholder="Uw email" name="email" required>
        <label for="descriptie"><b>Descriptie</b></label>
        <textarea type="text" name="description"></textarea>
        <button type="submit" class="sendContactForm">Versturen</button>
        </form>
        </div>
        </div>';

        return $contact;
    }

    public function collectUpdateContentPage()
    {
        try {
            if ((isset($_SESSION["login"])) && ($_SESSION["login"] == TRUE)) {
                $sql = 'SELECT * FROM content WHERE content_id=1';
                $res = $this->DataHandler->readsData($sql);
                $res->setFetchMode(PDO::FETCH_ASSOC);
                $content = $res->fetch();
                $update = '<div class="admin-page-wrapper">
                <div class="side-nav">
                <div class="brand">
                <img src="./view/assets/img/vr.svg" alt="">
                </div>
                <div class="admin-menu">
                <nav class="navigation">
                <ul class="mainmenu">
                <li><a href="./?op=overviewproducts">Producten</a></li>
                <li><label for="content">Content Update +</label><input type="checkbox" id="content" checked>
                <ul class="submenu">
                <li class="active"><a href="./?op=adminUpdateForm">hoofd pagina</a></li>
                </ul>
                </li>
                <li><a href="./?op=adminOverviewOrders">Overzicht orders</a></li>
                <li><a href="./?op=logout">Uitloggen</a></li>
                </ul>
                </nav>
                </div>
                </div>
                <div class="admin-page">
                <div class="adminUpdateForm">
                <h1>Voorpagina</h1>
                <form action="./?op=adminUpdateContent" method="post">
                <textarea style="width:500px;height:200px;" name="call_to_action">' . $content["content"] . '</textarea>
                <input type="submit" class="adminUpdateForm-btn" value="Update">
                </div>
                </div>
                </div>';

                return $update;
            } else {
                header("Location: ./");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateContentPage($call_to_action)
    {
        try {
            if ((isset($_SESSION["login"])) && ($_SESSION["login"] == TRUE)) {
                $sql = 'UPDATE content SET content = :content WHERE content_id=1';
                $res = $this->DataHandler->prepared($sql);
                $res->bindParam(':content', $call_to_action, PDO::PARAM_STR);
                $res->execute();
                header("Location: ./?op=adminUpdateForm");
            } else {
                header("Location: ./");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function sendContactMail($name, $subject, $email, $description)
    {
        $mailAddress = 'no.reply.multiversum@gmail.com';
        mail($mailAddress, $subject, $description, $email);
        return;
    }

    public function readCheckoutForm($id)
    {
        try {
            $sql = 'SELECT * FROM product WHERE id=:id';
            $res = $this->DataHandler->prepared($sql);
            $res->bindParam(':id', $id, PDO::PARAM_INT);
            $res->execute();
            $res->setFetchMode(PDO::FETCH_ASSOC);
            $results = $res->fetch();
        } catch (Exception $e) {
            throw $e;
        }

        $btw = $results["price"] * 0.21;
        $total = $btw + $results["price"];

        $form = '<div class="checkout-wrapper">
        <div class="checkout-container">
        <div class="product-checkout">
        <table>
        <tr>
        <th></th>
        <th>Product</th>
        <th>Prijs</th>
        </tr>
        <tr>
        <td><img src="' . $results["img_path"] . '" alt=""></td>
        <td>' . $results["title"] . '</td>
        <td>' . $results["price"] . '</td>
        </tr>
        <tr class="btw">
        <td></td>
        <td>BTW 21%</td>
        <td>' . $btw . '</td>
        </tr>
        <tr class="total">
        <td></td>
        <td>Totaal:</td>
        <td>' . $total . '</td>
        </tr>
        </table>
        </div>

        <div class="checkout-form">
        <div class="checkout-form-container">
        <form action="./?op=createOrder" method="post">
        <input type="text" hidden name="product" value="' . $results["title"] . '">
        <input type="text" hidden name="id" value="' . $results["id"] . '">
        <input type="text" hidden name="total_price" value="' . $total . '">
        <input type="date" hidden name="order_date" value="' . date('Y-m-d') . '">

        <label for="male">Dhr* </label><input type="radio" value="male" name="sex" id="male" checked>
        <label for="female">Mvr* </label><input type="radio" value="female" name="sex" id="female">
        
        <br><br>

        <label for="firstname">Voornaam *</label><br>
        <input type="text" id="firstname" name="firstname" required>
        <br>
        <label for="insertion">Tussen voegsel *</label><br>
        <input type="text" class="smoll" id="insertion" name="insertion" required>
        <br>
        <label for="lastname">Achternaam *</label><br>
        <input type="text" id="lastname" name="lastname" required>
        <br>
        <label for="city">Stad *</label><br>
        <input type="text" id="city" name="city" required>
        <br>
        <label for="street">Straat *</label><br>
        <input type="text" id="street" name="street" required>
        <br>
        <label for="house">Huisnummer *</label><br>
        <input type="text" class="smoll" id="house" name="house" required>
        <br>
        <label for="zipcode">postcode *</label><br>
        <input type="text" id="zipcode" name="zipcode" required>
        <br>
        <label for="mail">E-mail *</label><br>
        <input type="text" id="mail" name="mail" required>
        <br>
        <label for="phone">Telefoon *</label><br>
        <input type="text" id="phone" name="phone" required>
        <input type="submit" value="Send" require>
        
        </form>
        </div>
        </div>
        </div>
        </div>';


        return $form;
    }

    public function createOrder($product, $id, $total_price, $sex, $firstname, $insertion, $lastname, $city, $street, $house, $zipcode, $mail, $phone, $order_date)
    {
        try {
            $sql = "INSERT INTO `orders` (`order_id`,`product_id`, `total_price`, `sex`, `firstname`, `insertion`, `lastname`, `city`, `street`, `house`, `zipcode`, `mail`, `phone`, `order_date`) 
            VALUES (NULL, :product_id, :total_price, :sex, :firstname, :insertion, :lastname, :city, :street, :house, :zipcode, :mail, :phone, :order_date)";
            $res = $this->DataHandler->prepared($sql);
            $res->bindParam(':product_id', $id, PDO::PARAM_INT);
            $res->bindParam(':total_price', $total_price, PDO::PARAM_INT);
            $res->bindParam(':sex', $sex, PDO::PARAM_STR);
            $res->bindParam(':firstname', $firstname, PDO::PARAM_STR);
            $res->bindParam(':insertion', $insertion, PDO::PARAM_STR);
            $res->bindParam(':lastname', $lastname, PDO::PARAM_STR);
            $res->bindParam(':city', $city, PDO::PARAM_STR);
            $res->bindParam(':street', $street, PDO::PARAM_STR);
            $res->bindParam(':house', $house, PDO::PARAM_STR);
            $res->bindParam(':zipcode', $zipcode, PDO::PARAM_STR);
            $res->bindParam(':mail', $mail, PDO::PARAM_STR);
            $res->bindParam(':phone', $phone, PDO::PARAM_STR);
            $res->bindParam(':order_date', $order_date, PDO::PARAM_STR);
            $res->execute();

            $email = 'no.reply.multiversum@gmail.com';
            $description = "Dank u voor uw aankoop door omstandig heden met het corona kan het wat langer duuren voordat wij uw product kunnen leveren wij vragen hiervoor uw begrip.
            \r\n
            Product:" . $product . "\r\n
            Prijs:" . $total_price;
            mail($mail, "Multiversum Verkoop bevestiging", $description, $email);
            return;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function readOverviewOrders()
    {   
        try {
            if ((isset($_SESSION["login"])) && ($_SESSION["login"] == TRUE)) {
                $sql = 'SELECT * FROM orders JOIN product ON orders.product_id=product.id';
                $res = $this->DataHandler->readsData($sql);
                $results = $res->fetchAll();
                $overview = '<div class="admin-page-wrapper">
                <div class="side-nav">
                <div class="brand">
                <img src="./view/assets/img/vr.svg" alt="">
                </div>
                <div class="admin-menu">
                                <nav class="navigation">
                                    <ul class="mainmenu">
                                        <li><a href="./?op=overviewproducts">Producten</a></li>
                                        <li><label for="content">Content Update +</label><input type="checkbox" id="content">
                                            <ul class="submenu">
                                                <li><a href="./?op=adminUpdateForm">hoofd pagina</a></li>
                                            </ul>
                                        </li>
                                        <li class="active"><a href="./?op=adminOverviewOrders">Overzicht orders</a></li>
                                        <li><a href="./?op=logout">Uitloggen</a></li>
                                    </ul>
                                </nav>
                            </div>
                </div>
                <div class="admin-page">
                <div class="overview-orders">
                <table>
                <tr>
                <th>Prijs</th>
                <th>Product</th>
                <th>Naam</th>
                <th>Stad</th>
                <th>Straat</th>
                <th>Huisnummer</th>
                <th>Postcode</th>
                <th>E-mail</th>
                <th>Telefoon</th>
                <th>Aankoop datum</th>
                </tr>
                </div>
                </div>';

                foreach ($results as $order) {
                    $fullname = $order["firstname"] . " " . $order["lastname"];
                    $overview .= '<tr>
                    <td>' . $order["total_price"] . '</td>
                    <td>' . $order["title"] . '</td>
                    <td>' . $fullname . '</td>
                    <td>' . $order["city"] . '</td>
                    <td>' . $order["street"] . '</td>
                    <td>' . $order["house"] . '</td>
                    <td>' . $order["zipcode"] . '</td>
                    <td>' . $order["mail"] . '</td>
                    <td>' . $order["phone"] . '</td>
                    <td>' . $order["order_date"] . '</td>
                    </tr>';
                }
                $overview .= '</table></div></div>';
                return $overview;
            } else {
                header("Location: ./");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateProductoverview()
    {
        try {
            if ((isset($_SESSION["login"])) && ($_SESSION["login"] == 1)) {
                $sql = 'SELECT * FROM product';
                $res = $this->DataHandler->readsData($sql);
                $results = $res->fetchAll();

                $overview = '<div class="admin-page-wrapper">
                <div class="side-nav">
                    <div class="brand">
                        <img src="./view/assets/img/vr.svg" alt="">
                    </div>
                    <div class="admin-menu">
                            <nav class="navigation">
                                <ul class="mainmenu">
                                    <li class="active"><a href="./?op=overviewproducts">Producten</a></li>
                                    <li><label for="content">Content Update +</label><input type="checkbox" id="content">
                                        <ul class="submenu">
                                            <li><a href="./?op=adminUpdateForm">hoofd pagina</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="./?op=adminOverviewOrders">Overzicht orders</a></li>
                                    <li><a href="./?op=logout">Uitloggen</a></li>
                                </ul>
                            </nav>
                        </div>
                </div>
                <div class="admin-page">
                    <div class="overview-products">
                    <table>
                    <tr>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    <div class="add-product">
                    <button><a href="./?op=createform">Product Toevoegen +</a></button>
                    </div>
                    </td>
                    </tr>
                    <tr>
                    <th>Product</th>
                    <th>Aanpassen</th>
                    <th>Archiveren</th>
                    <th>Verwijderen</th>
                    </tr>';
                foreach ($results as $product) {
                    $overview .= '<tr>
                        <td>' . $product["title"] . '</td>
                        <td><a href="./?op=updateform&id=' . $product["id"] . '">Edit</a></td>';
                    if ($product["archieved"] == 0) {
                        $archieved = "Archiveer";
                    } else {
                        $archieved = "De-archiveer";
                    }
                    $overview .= '<td><a href="./?op=archiveproductconfirm&id=' . $product["id"] . '">'.$archieved.'</a></td>
                        <td><a href="./?op=deleteproductconfirm&id=' . $product["id"] . '">Verwijder</a></td>
                        </tr>';
                }
                $overview .= '
                    </table>
                    </div>
                </div>';

                return $overview;
            } else {
                header("Location: ./");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateProductForm($id)
    {
        try {
            if ((isset($_SESSION["login"])) && ($_SESSION["login"] == TRUE)) {
                $sql = 'SELECT * FROM product WHERE id=:id';
                $res = $this->DataHandler->prepared($sql);
                $res->bindParam(':id', $id, PDO::PARAM_INT);
                $res->execute();
                $res->setFetchMode(PDO::FETCH_ASSOC);
                $product = $res->fetch();

                $form = '<div class="admin-page-wrapper">
                <div class="side-nav">
                    <div class="brand">
                        <img src="./view/assets/img/vr.svg" alt="">
                    </div>
                    <div class="admin-menu">
                            <nav class="navigation">
                                <ul class="mainmenu">
                                    <li class="active"><a href="./?op=overviewproducts">Producten</a></li>
                                    <li><label for="content">Content Update +</label><input type="checkbox" id="content">
                                        <ul class="submenu">
                                            <li><a href="./?op=adminUpdateForm">hoofd pagina</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="./?op=adminOverviewOrders">Overzicht orders</a></li>
                                    <li><a href="./?op=logout">Uitloggen</a></li>
                                </ul>
                            </nav>
                        </div>
                </div>
                <div class="admin-page">
                <div class="admin-update-product">
                <form action="./?op=updateproduct" method="post" enctype="multipart/form-data">
                <input type="text" name="id" hidden value="' . $product["id"] . '">
                <table style="float:left;">
                <tr>
                <th>Titel</th>
                <td><input type="text" name="title" value="' . $product["title"] . '"></td>
                </tr>
                <tr>
                <th>EAN</th>
                <td><input type="text" name="ean" value="' . $product["ean"] . '"></td>
                </tr>
                <tr>
                <th>SKU</th>
                <td><input type="text" name="sku" value="' . $product["sku"] . '"></td>
                </tr>
                <tr>
                <th>Prijs</th>
                <td><input type="number" name="price" value="' . $product["price"] . '"></td>
                </tr>
                <tr>
                <th>Merk</th>
                <td><input type="text" name="brand" value="' . $product["brand"] . '"></td>
                </tr>
                <tr>
                <th>Platform</th>
                <td><input type="text" name="platform" value="' . $product["platform"] . '"></td>
                </tr>
                <tr>
                <th>Resolutie</th>
                <td><input type="text" name="resolution" value="' . $product["resolution"] . '"></td>
                </tr>
                <tr>
                <th>Gezichtsveld</th>
                <td><input type="number" name="pov" value="' . $product["pov"] . '"></td>
                </tr>
                <tr>
                <th>Refresh rate</th>
                <td><input type="number" name="refresh" value="' . $product["refresh"] . '"></td>
                </tr>
                <tr>
                <th>Minimum mobiel groote</th>
                <td><input type="number" name="min_phone_size" value="' . $product["min_phone_size"] . '"></td>
                </tr>
                <tr>
                <th>Maximum mobiel groote</th>
                <td><input type="number" name="max_phone_size" value="' . $product["max_phone_size"] . '"></td>
                </tr>
                <tr>
                <th>kabel connecties</th>
                <td><input type="text" name="connection_c" value="' . $product["connection_c"] . '"></td>
                </tr>
                <tr>
                <th>Wifi connecties</th>
                <td><input type="text" name="connection_w" value="' . $product["connection_w"] . '"></td>
                </tr>
                <tr>
                <th>Controllers</th>
                <td><input type="number" name="controllers" value="' . $product["controllers"] . '"></td>
                </tr>
                <tr>
                <th>Kabels</th>
                <td><input type="text" name="cables" value="' . $product["cables"] . '"></td>
                </tr>
                <tr>
                <th>Tracking stations</th>
                <td><input type="number" name="tracking_stations" value="' . $product["tracking_stations"] . '"></td>
                </tr>
                <tr>
                <th>Hoogte (cm)</th>
                <td><input type="number" name="height" value="' . $product["height"] . '"></td>
                </tr>
                <tr>
                <th>Breedte (cm)</th>
                <td><input type="number" name="width" value="' . $product["width"] . '"></td>
                </tr>
                <tr>
                <th>Diepte (cm)</th>
                <td><input type="number" name="dept" value="' . $product["dept"] . '"></td>
                </tr>
                <tr>
                <th>Gewicht (gram)</th>
                <td><input type="number" name="weight" value="' . $product["weight"] . '"></td>
                </tr>
                <tr>
                <th>Kleur</th>
                <td><input type="text" name="color" value="' . $product["color"] . '"></td>
                </tr>
                <tr>
                <th>Uitgave jaar</th>
                <td><input type="date" name="released" value="' . $product["released"] . '"></td>
                </tr>
                <tr>
                <th>Serie</th>
                <td><input type="text" name="series" value="' . $product["series"] . '"></td>
                </tr>
                <tr>
                <th>Foto</th>
                <td><input type="file" name="img_path" id="fileToUpload"></td>
                </tr>
                </table>
                <table style="float:right;">
                <tr>
                <th>Heeft eigen display</th>
                <td>';
                if ($product["own_display"]) {
                    $form .= '<input type="radio" value="1" id="own_display_true" name="own_display" checked>
                    <label for="own_display_true">Ja</label>
                    <input type="radio" value="0" id="own_display_false" name="own_display">
                    <label for="own_display_false">Nee</label>';
                } else {
                    $form .= '<input type="radio" value="1" id="own_display_true" name="own_display">
                    <label for="own_display_true">Ja</label>
                    <input type="radio" value="0" id="own_display_false" name="own_display" checked>
                    <label for="own_display_false">Nee</label>';
                }
                $form .= '</td>
                </tr>
                <tr>
                <th>Accelerometer</th>
                <td>';
                if ($product["accelerometer"]) {
                    $form .= '<input type="radio" value="1" id="accelerometer_true" name="accelerometer" checked>
                    <label for="accelerometer_true">Ja</label>
                    <input type="radio" value="0" id="accelerometer_false" name="accelerometer">
                    <label for="accelerometer_false">Nee</label>';
                } else {
                    $form .= '<input type="radio" value="1" id="accelerometer_true" name="accelerometer">
                    <label for="accelerometer_true">Ja</label>
                    <input type="radio" value="0" id="accelerometer_false" name="accelerometer" checked>
                    <label for="accelerometer_false">Nee</label>';
                }
                $form .= '</td>
                </tr>
                <tr>
                <th>Camera</th>
                <td>';
                if ($product["camera"]) {
                    $form .= '<input type="radio" value="1" id="camera_true" name="camera" checked>
                    <label for="camera_true">Ja</label>
                    <input type="radio" value="0" id="camera_false" name="camera">
                    <label for="camera_false">Nee</label>';
                } else {
                    $form .= '<input type="radio" value="1" id="camera_true" name="camera">
                    <label for="camera_true">Ja</label>
                    <input type="radio" value="0" id="camera_false" name="camera" checked>
                    <label for="camera_false">Nee</label>';
                }
                $form .= '</td>
                </tr>
                <tr>
                <th>Gyroscoop</th>
                <td>';
                if ($product["gyroscoop"]) {
                    $form .= '<input type="radio" value="1" id="gyroscoop_true" name="gyroscoop" checked>
                    <label for="gyroscoop_true">Ja</label>
                    <input type="radio" value="0" id="gyroscoop_false" name="gyroscoop">
                    <label for="gyroscoop_false">Nee</label>';
                } else {
                    $form .= '<input type="radio" value="1" id="gyroscoop_true" name="gyroscoop">
                    <label for="gyroscoop_true">Ja</label>
                    <input type="radio" value="0" id="gyroscoop_false" name="gyroscoop" checked>
                    <label for="gyroscoop_false">Nee</label>';
                }
                $form .= '</td>
                </tr>
                <tr>
                <th>Koptelefoon</th>
                <td>';
                if ($product["headphone"]) {
                    $form .= '<input type="radio" value="1" id="headphone_true" name="headphone" checked>
                    <label for="headphone_true">Ja</label>
                    <input type="radio" value="0" id="headphone_false" name="headphone">
                    <label for="headphone_false">Nee</label>';
                } else {
                    $form .= '<input type="radio" value="1" id="headphone_true" name="headphone">
                    <label for="headphone_true">Ja</label>
                    <input type="radio" value="0" id="headphone_false" name="headphone" checked>
                    <label for="headphone_false">Nee</label>';
                }
                $form .= '</td>
                </tr>
                <tr>
                <th>Microfoon</th>
                <td>';
                if ($product["microphone"]) {
                    $form .= '<input type="radio" value="1" id="microphone_true" name="microphone" checked>
                    <label for="microphone_true">Ja</label>
                    <input type="radio" value="0" id="microphone_false" name="microphone">
                    <label for="microphone_false">Nee</label>';
                } else {
                    $form .= '<input type="radio" value="1" id="microphone_true" name="microphone">
                    <label for="microphone_true">Ja</label>
                    <input type="radio" value="0" id="microphone_false" name="microphone" checked>
                    <label for="microphone_false">Nee</label>';
                }
                $form .= '</td>
                </tr>
                <tr>
                <th>Herstelbare lensen</th>
                <td>';
                if ($product["adjustable_lenses"]) {
                    $form .= '<input type="radio" value="1" id="adjustable_lenses_true" name="adjustable_lenses" checked>
                    <label for="adjustable_lenses_true">Ja</label>
                    <input type="radio" value="0" id="adjustable_lenses_false" name="adjustable_lenses">
                    <label for="adjustable_lenses_false">Nee</label>';
                } else {
                    $form .= '<input type="radio" value="1" id="adjustable_lenses_true" name="adjustable_lenses">
                    <label for="adjustable_lenses_true">Ja</label>
                    <input type="radio" value="0" id="adjustable_lenses_false" name="adjustable_lenses" checked>
                    <label for="adjustable_lenses_false">Nee</label>';
                }
                $form .= '</td>
                </tr>
                <tr>
                <th>Oog volgend</th>
                <td>';
                if ($product["eyetracking"]) {
                    $form .= '<input type="radio" value="1" id="eyetracking_true" name="eyetracking" checked>
                    <label for="eyetracking_true">Ja</label>
                    <input type="radio" value="0" id="eyetracking_false" name="eyetracking">
                    <label for="eyetracking_false">Nee</label>';
                } else {
                    $form .= '<input type="radio" value="1" id="eyetracking_true" name="eyetracking">
                    <label for="eyetracking_true">Ja</label>
                    <input type="radio" value="0" id="eyetracking_false" name="eyetracking" checked>
                    <label for="eyetracking_false">Nee</label>';
                }
                $form .= '</td>
                </tr>
                <tr>
                <th>Hand tracerend</th>
                <td>';
                if ($product["handtracking"]) {
                    $form .= '<input type="radio" value="1" id="handtracking_true" name="handtracking" checked>
                    <label for="handtracking_true">Ja</label>
                    <input type="radio" value="0" id="handtracking_false" name="handtracking">
                    <label for="handtracking_false">Nee</label>';
                } else {
                    $form .= '<input type="radio" value="1" id="handtracking_true" name="handtracking">
                    <label for="handtracking_true">Ja</label>
                    <input type="radio" value="0" id="handtracking_false" name="handtracking" checked>
                    <label for="handtracking_false">Nee</label>';
                }
                $form .= '</td>
                </tr>
                <tr>
                <th>Magnetometer</th>
                <td>';
                if ($product["magnetometer"]) {
                    $form .= '<input type="radio" value="1" id="magnetometer_true" name="magnetometer" checked>
                    <label for="magnetometer_true">Ja</label>
                    <input type="radio" value="0" id="magnetometer_false" name="magnetometer">
                    <label for="magnetometer_false">Nee</label>';
                } else {
                    $form .= '<input type="radio" value="1" id="magnetometer_true" name="magnetometer">
                    <label for="magnetometer_true">Ja</label>
                    <input type="radio" value="0" id="magnetometer_false" name="magnetometer" checked>
                    <label for="magnetometer_false">Nee</label>';
                }
                $form .= '</td>
                </tr>
                <tr>
                <th>Speakers</th>
                <td>';
                if ($product["speakers"]) {
                    $form .= '<input type="radio" value="1" id="speakers_true" name="speakers" checked>
                    <label for="speakers_true">Ja</label>
                    <input type="radio" value="0" id="speakers_false" name="speakers">
                    <label for="speakers_false">Nee</label>';
                } else {
                    $form .= '<input type="radio" value="1" id="speakers_true" name="speakers">
                    <label for="speakers_true">Ja</label>
                    <input type="radio" value="0" id="speakers_false" name="speakers" checked>
                    <label for="speakers_false">Nee</label>';
                }
                $form .= '</td>
                </tr>
                <tr>
                <th>Bluethooth</th>
                <td>';
                if ($product["connection_b"]) {
                    $form .= '<input type="radio" value="1" id="connection_b_true" name="connection_b" checked>
                    <label for="connection_b_true">Ja</label>
                    <input type="radio" value="0" id="connection_b_false" name="connection_b">
                    <label for="connection_b_false">Nee</label>';
                } else {
                    $form .= '<input type="radio" value="1" id="connection_b_true" name="connection_b">
                    <label for="connection_b_true">Ja</label>
                    <input type="radio" value="0" id="connection_b_false" name="connection_b" checked>
                    <label for="connection_b_false">Nee</label>';
                }
                $form .= '</td>
                </tr>
                <tr>
                <th>Afstands bediening</th>
                <td>';
                if ($product["remote_controll"]) {
                    $form .= '<input type="radio" value="1" id="remote_controll_true" name="remote_controll" checked>
                    <label for="remote_controll_true">Ja</label>
                    <input type="radio" value="0" id="remote_controll_false" name="remote_controll">
                    <label for="remote_controll_false">Nee</label>';
                } else {
                    $form .= '<input type="radio" value="1" id="remote_controll_true" name="remote_controll">
                    <label for="remote_controll_true">Ja</label>
                    <input type="radio" value="0" id="remote_controll_false" name="remote_controll" checked>
                    <label for="remote_controll_false">Nee</label>';
                }
                $form .= '</td>
                </tr>
                </table>
                <div class="description">
                <label for="description">Description</label>
                <br>
                <textarea id="description" name="description">' . $product["description"] . '</textarea>
                </div>
                <input type="submit" value="Send">
                </form>
                </div>
                </div>
                </div>';

                return $form;
            } else {
                header("Location: ./");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
    
    public function comfirmedProduct($text)
    {   
        if ((isset($_SESSION["login"])) && ($_SESSION["login"] == TRUE)) {
            $model = '<div class="admin-page-wrapper">
                <div class="side-nav">
                    <div class="brand">
                        <img src="./view/assets/img/vr.svg" alt="">
                    </div>
                    <div class="admin-menu">
                            <nav class="navigation">
                                <ul class="mainmenu">
                                    <li class="active"><a href="./?op=overviewproducts">Producten</a></li>
                                    <li><label for="content">Content Update +</label><input type="checkbox" id="content">
                                        <ul class="submenu">
                                            <li><a href="./?op=adminUpdateForm">hoofd pagina</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="./?op=adminOverviewOrders">Overzicht orders</a></li>
                                    <li><a href="./?op=logout">Uitloggen</a></li>
                                </ul>
                            </nav>
                        </div>
                </div>
                <div class="admin-page">
                    <div class="confirm-message">
                    <p>'.$text.'<p>
                    <button><a href="./?op=overviewproducts">Terug naar overview</a></button>
                    </div>
                </div>
            </div>';
            return $model;
        } else {
            header("Location: ./");
        }
    }

    public function updateProduct($id, $title, $ean, $sku, $price, $img_path, $description, $brand, $platform, $own_display, $resolution, $pov, $refresh, $min_phone_size, $max_phone_size, $accelerometer, $camera, $gyroscoop, $headphone, $microphone, $adjustable_lenses, $eyetracking, $handtracking, $magnetometer, $speakers, $connection_c, $connection_w, $connection_b, $remote_controll, $controllers, $cables, $tracking_stations, $height, $width, $dept, $weight, $color, $released, $series)
    {   
        try {
            if ((isset($_SESSION["login"])) && ($_SESSION["login"] == TRUE)) {
                if ($img_path['size'] == 0 && $img_path['error'] == 4)
                {
                    $sql = 'SELECT img_path FROM product WHERE id=:id';
                    $res = $this->DataHandler->prepared($sql);
                    $res->bindParam(':id', $id, PDO::PARAM_INT);
                    $res->execute();
                    $res->setFetchMode(PDO::FETCH_ASSOC);
                    $img_path = $res->fetch();
                    $img_path = $img_path["img_path"];
                } else {
                    $img_path = $this->uploadFile($img_path);
                }

                $sql = "UPDATE product SET title=:title,
                ean=:ean,
                sku=:sku, 
                price=:price, 
                img_path=:img_path, 
                description=:description, 
                brand=:brand, 
                platform=:platform, 
                own_display=:own_display, 
                resolution=:resolution, 
                pov=:pov, 
                refresh=:refresh, 
                min_phone_size=:min_phone_size, 
                max_phone_size=:max_phone_size, 
                accelerometer=:accelerometer, 
                camera=:camera, 
                gyroscoop=:gyroscoop, 
                headphone=:headphone, 
                microphone=:microphone, 
                adjustable_lenses=:adjustable_lenses,
                eyetracking=:eyetracking, 
                handtracking=:handtracking, 
                magnetometer=:magnetometer,
                speakers=:speakers, 
                connection_c=:connection_c,
                connection_w=:connection_w,
                connection_b=:connection_b,
                remote_controll=:remote_controll, 
                controllers=:controllers, 
                cables=:cables, 
                tracking_stations=:tracking_stations, 
                height=:height, 
                width=:width, 
                dept=:dept, 
                weight=:weight, 
                color=:color,
                released=:released, 
                series=:series
                WHERE id=:id";
                $res = $this->DataHandler->prepared($sql);
                $res->bindParam(':id', $id, PDO::PARAM_INT);
                $res->bindParam(':title', $title, PDO::PARAM_STR);
                $res->bindParam(':ean', $ean, PDO::PARAM_STR);
                $res->bindParam(':sku', $sku, PDO::PARAM_STR);
                $res->bindParam(':price', $price, PDO::PARAM_INT);
                $res->bindParam(':img_path', $img_path, PDO::PARAM_STR);
                $res->bindParam(':description', $description, PDO::PARAM_STR);
                $res->bindParam(':brand', $brand, PDO::PARAM_STR);
                $res->bindParam(':platform', $platform, PDO::PARAM_STR);
                $res->bindParam(':own_display', $own_display, PDO::PARAM_BOOL);
                $res->bindParam(':resolution', $resolution, PDO::PARAM_STR);
                $res->bindParam(':pov', $pov, PDO::PARAM_INT);
                $res->bindParam(':refresh', $refresh, PDO::PARAM_INT);
                $res->bindParam(':min_phone_size', $min_phone_size, PDO::PARAM_INT);
                $res->bindParam(':max_phone_size', $max_phone_size, PDO::PARAM_INT);
                $res->bindParam(':accelerometer', $accelerometer, PDO::PARAM_BOOL);
                $res->bindParam(':camera', $camera, PDO::PARAM_BOOL);
                $res->bindParam(':gyroscoop', $gyroscoop, PDO::PARAM_BOOL);
                $res->bindParam(':headphone', $headphone, PDO::PARAM_BOOL);
                $res->bindParam(':microphone', $microphone, PDO::PARAM_BOOL);
                $res->bindParam(':adjustable_lenses', $adjustable_lenses, PDO::PARAM_BOOL);
                $res->bindParam(':eyetracking', $eyetracking, PDO::PARAM_BOOL);
                $res->bindParam(':handtracking', $handtracking, PDO::PARAM_BOOL);
                $res->bindParam(':magnetometer', $magnetometer, PDO::PARAM_BOOL);
                $res->bindParam(':speakers', $speakers, PDO::PARAM_BOOL);
                $res->bindParam(':connection_c', $connection_c, PDO::PARAM_STR);
                $res->bindParam(':connection_w', $connection_w, PDO::PARAM_STR);
                $res->bindParam(':connection_b', $connection_b, PDO::PARAM_BOOL);
                $res->bindParam(':remote_controll', $remote_controll, PDO::PARAM_BOOL);
                $res->bindParam(':controllers', $controllers, PDO::PARAM_INT);
                $res->bindParam(':cables', $cables, PDO::PARAM_STR);
                $res->bindParam(':tracking_stations', $tracking_stations, PDO::PARAM_INT);
                $res->bindParam(':height', $height, PDO::PARAM_INT);
                $res->bindParam(':width', $width, PDO::PARAM_INT);
                $res->bindParam(':dept', $dept, PDO::PARAM_INT);
                $res->bindParam(':weight', $weight, PDO::PARAM_INT);
                $res->bindParam(':color', $color, PDO::PARAM_STR);
                $res->bindParam(':released', $released, PDO::PARAM_STR);
                $res->bindParam(':series', $series, PDO::PARAM_STR);
                $res->execute();
                return;
            } else {
                header("Location: ./");
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
}
