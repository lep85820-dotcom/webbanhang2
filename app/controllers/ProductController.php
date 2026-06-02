<?php
require_once 'app/models/ProductModel.php';
require_once 'app/models/OrderModel.php';
require_once 'app/models/OrderDetailModel.php';
require_once 'app/helpers/SessionHelper.php';

class ProductController {
    private $productModel;
    private $orderModel;
    private $orderDetailModel;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->productModel = new ProductModel($this->db);
        $this->orderModel = new OrderModel($this->db);
        $this->orderDetailModel = new OrderDetailModel($this->db);
    }

    public function list() {
        $products = $this->productModel->getProducts();
        include 'app/views/product/list.php';
    }

    public function show($id) {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            include 'app/views/product/show.php';
        } else {
            echo "Không tìm thấy sản phẩm.";
        }
    }

    public function add() {
        if (!SessionHelper::isAdmin()) {
            header('Location: /webbanhang/Product/list');
            exit();
        }

        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? 0;
            $category_id = $_POST['category_id'] ?? null;
            if ($category_id === '') {
                $category_id = null;
            }

            $image = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = 'uploads/';
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $image = $target_dir . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $image);
            }

            $result = $this->productModel->addProduct($name, $description, $price, $image, $category_id);
            if ($result === true) {
                header('Location: /webbanhang/Product/list');
                exit();
            } else {
                $errors = $result;
            }
        }
        $categories = $this->productModel->getCategories();
        include 'app/views/product/add.php';
    }

    public function edit($id) {
        if (!SessionHelper::isAdmin()) {
            header('Location: /webbanhang/Product/list');
            exit();
        }

        $product = $this->productModel->getProductById($id);
        if (!$product) {
            die('Không tìm thấy sản phẩm.');
        }

        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? 0;
            $category_id = $_POST['category_id'] ?? null;
            if ($category_id === '') {
                $category_id = null;
            }

            $image = $product->image;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $target_dir = 'uploads/';
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $image = $target_dir . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $image);
            }

            $result = $this->productModel->updateProduct($id, $name, $description, $price, $image, $category_id);
            if ($result === true) {
                header('Location: /webbanhang/Product/list');
                exit();
            } else {
                $errors = $result;
            }
        }
        $categories = $this->productModel->getCategories();
        include 'app/views/product/edit.php';
    }

    public function delete($id) {
        if (!SessionHelper::isAdmin()) {
            header('Location: /webbanhang/Product/list');
            exit();
        }

        $this->productModel->deleteProduct($id);
        header('Location: /webbanhang/Product/list');
        exit();
    }

    public function addToCart($id) {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            die('Không tìm thấy sản phẩm.');
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image
            ];
        }

        header('Location: /webbanhang/Product/cart');
        exit();
    }

    public function cart() {
        $cart = $_SESSION['cart'] ?? [];
        include 'app/views/product/cart.php';
    }

    public function updateCart() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? null;
            $quantity = $_POST['quantity'] ?? 1;

            if ($id && isset($_SESSION['cart'][$id])) {
                if ($quantity > 0) {
                    $_SESSION['cart'][$id]['quantity'] = $quantity;
                } else {
                    unset($_SESSION['cart'][$id]);
                }
            }
        }
        header('Location: /webbanhang/Product/cart');
        exit();
    }

    public function removeFromCart($id) {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header('Location: /webbanhang/Product/cart');
        exit();
    }

    public function checkout() {
        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            header('Location: /webbanhang/Product/cart');
            exit();
        }
        include 'app/views/product/checkout.php';
    }

    public function processCheckout() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $payment_method = $_POST['payment_method'] ?? 'cod';
            $cart = $_SESSION['cart'] ?? [];

            if (empty($cart)) {
                header('Location: /webbanhang/Product/cart');
                exit();
            }

            $total_amount = 0;
            foreach ($cart as $item) {
                $total_amount += $item['price'] * $item['quantity'];
            }

            $order_id = $this->orderModel->createOrder($name, $phone, $address, $total_amount);

            if ($order_id) {
                foreach ($cart as $product_id => $item) {
                    $this->orderDetailModel->addOrderDetail(
                        $order_id,
                        $product_id,
                        $item['quantity'],
                        $item['price']
                    );
                }

                if ($payment_method === 'momo') {
                    $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
                    $partnerCode = "MOMOBKUN20180529";
                    $accessKey = "klm05TvNBzhg7h7j";
                    $secretKey = "at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa";

                    $orderInfo = "Thanh toan don hang #" . $order_id . " tai Web Ban Hang";
                    $redirectUrl = "http://localhost:8080/webbanhang/Product/momoReturn";
                    $ipnUrl = "http://localhost:8080/webbanhang/Product/momoIpn";
                    $amount = strval(intval($total_amount));
                    $orderId = strval($order_id) . "_" . time();
                    $requestId = strval($order_id) . "_" . time();
                    $requestType = "captureWallet";
                    $extraData = "";

                    $rawHash = "accessKey=" . $accessKey .
                               "&amount=" . $amount .
                               "&extraData=" . $extraData .
                               "&ipnUrl=" . $ipnUrl .
                               "&orderId=" . $orderId .
                               "&orderInfo=" . $orderInfo .
                               "&partnerCode=" . $partnerCode .
                               "&redirectUrl=" . $redirectUrl .
                               "&requestId=" . $requestId .
                               "&requestType=" . $requestType;

                    $signature = hash_hmac("sha256", $rawHash, $secretKey);

                    $data = [
                        'partnerCode' => $partnerCode,
                        'partnerName' => "Web Ban Hang Test",
                        'storeId' => "MomoStoreTest",
                        'requestId' => $requestId,
                        'amount' => intval($amount),
                        'orderId' => $orderId,
                        'orderInfo' => $orderInfo,
                        'redirectUrl' => $redirectUrl,
                        'ipnUrl' => $ipnUrl,
                        'lang' => 'vi',
                        'extraData' => $extraData,
                        'requestType' => $requestType,
                        'signature' => $signature
                    ];

                    $ch = curl_init($endpoint);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen(json_encode($data))
                    ]);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

                    $result = curl_exec($ch);
                    curl_close($ch);

                    $jsonResult = json_decode($result, true);

                    if (isset($jsonResult['payUrl'])) {
                        header('Location: ' . $jsonResult['payUrl']);
                        exit();
                    } else {
                        $errorMessage = $jsonResult['message'] ?? 'Không thể khởi tạo thanh toán MoMo.';
                        echo "Lỗi thanh toán MoMo Sandbox: " . htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8');
                        exit();
                    }
                } else {
                    unset($_SESSION['cart']);
                    header('Location: /webbanhang/Product/orderConfirmation');
                    exit();
                }
            } else {
                echo "Đã xảy ra lỗi khi tạo đơn hàng. Vui lòng thử lại.";
            }
        }
    }

    public function momoReturn() {
        $partnerCode = $_GET['partnerCode'] ?? '';
        $orderId = $_GET['orderId'] ?? '';
        $requestId = $_GET['requestId'] ?? '';
        $amount = $_GET['amount'] ?? '';
        $orderInfo = $_GET['orderInfo'] ?? '';
        $orderType = $_GET['orderType'] ?? '';
        $transId = $_GET['transId'] ?? '';
        $resultCode = $_GET['resultCode'] ?? '';
        $message = $_GET['message'] ?? '';
        $payType = $_GET['payType'] ?? '';
        $responseTime = $_GET['responseTime'] ?? '';
        $extraData = $_GET['extraData'] ?? '';
        $momoSignature = $_GET['signature'] ?? '';

        $secretKey = "at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa";

        $rawHash = "accessKey=klm05TvNBzhg7h7j" .
                   "&amount=" . $amount .
                   "&extraData=" . $extraData .
                   "&message=" . $message .
                   "&orderId=" . $orderId .
                   "&orderInfo=" . $orderInfo .
                   "&partnerCode=" . $partnerCode .
                   "&paymentOption=" . ($_GET['paymentOption'] ?? '') .
                   "&payType=" . $payType .
                   "&requestId=" . $requestId .
                   "&responseTime=" . $responseTime .
                   "&resultCode=" . $resultCode .
                   "&transId=" . $transId;

        if (!isset($_GET['paymentOption'])) {
            $rawHash = str_replace("&paymentOption=", "", $rawHash);
        }

        $mySignature = hash_hmac("sha256", $rawHash, $secretKey);

        $parts = explode('_', $orderId);
        $real_order_id = intval($parts[0]);

        if ($resultCode == 0) {
            $this->orderModel->updateOrderStatus($real_order_id, 'processing');
            unset($_SESSION['cart']);
            $_SESSION['momo_success'] = "Thanh toán qua ví MoMo thành công cho đơn hàng #$real_order_id!";
            header('Location: /webbanhang/Product/orderConfirmation');
            exit();
        } else {
            $this->orderModel->updateOrderStatus($real_order_id, 'cancelled');
            echo "<div class='container mt-5 text-center'>";
            echo "<h1 class='text-danger'>Thanh toán MoMo thất bại!</h1>";
            echo "<p class='lead'>Chi tiết: " . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . " (Mã lỗi: $resultCode)</p>";
            echo "<a href='/webbanhang/Product/cart' class='btn btn-primary mt-3'>Quay lại giỏ hàng và thử lại</a>";
            echo "</div>";
            exit();
        }
    }

    public function orderConfirmation() {
        include 'app/views/product/orderConfirmation.php';
    }
}
?>
