<?php

class IndexAdminController extends Controller
{
    function __construct()
    {
        $this->folder = "admin";
    }

    // Trang index mặc định
    function index()
    {
        require_once 'views/admin/index.php';
    }

    // Trang dashboard admin
    function dashboard()
    {
        if (!isset($_SESSION['admin'])) {
            header("Location: " . INDEX_URL . "indexadmin");
            exit();
        }

        require_once 'vendor/Model.php';
        require_once 'models/admin/orderModel.php';
        require_once 'models/admin/memberModel.php';
        require_once 'models/admin/productModel.php';

        $orderModel = new orderModel;
        $memberModel = new memberModel;
        $productModel = new productModel;

        $data = [
            $orderModel->orderToday(),
            $memberModel->memberToday(),
            count($productModel->getAllPrds()),
            $memberModel->allMember()
        ];

        $this->render('dashboard', $data, null, 'admin');
    }

    // Xử lý đăng nhập admin
    function login()
    {
        require_once 'vendor/Model.php';
        require_once 'models/users/userModel.php';

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (trim($username) === '' || trim($password) === '') {
            echo "Không được để trống!";
            return;
        }

        $userModel = new userModel;
        $userData = $userModel->getUserByUsername($username);

        if ($userData) {
            if ($password === $userData['matkhau'] && $userData['quyen'] === '1') {
                $_SESSION['user'] = $userData;
                $_SESSION['admin'] = $userData;
                echo "LoginSuccess";
                return;
            } else {
                echo "Sai tên tài khoản hoặc mật khẩu!";
                return;
            }
        }

        echo "Sai tên tài khoản hoặc mật khẩu!";
    }

    // Xử lý đăng xuất
    function logout()
    {
        session_unset();
        session_destroy();

        if (isset($_COOKIE['user'])) {
            unset($_COOKIE['user']);
            setcookie('user', '', time() - 3600, '/');
        }
    }
}
