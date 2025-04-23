<?php

class AnalyticsController extends Controller
{
    function __construct()
    {
        $this->folder = "admin";
        
        // Kiểm tra đăng nhập admin, redirect sử dụng INDEX_URL thay vì domain cứng
        if (!isset($_SESSION['admin'])) {
            header("Location: " . INDEX_URL . "indexadmin");
            exit(); // Quan trọng: dừng script sau khi redirect
        }
    }

    // Trang chính của Analytics
    function index()
    {
        require_once 'vendor/Model.php';
        // Nếu cần dùng dữ liệu, bạn có thể mở comment dưới đây:
        require_once 'models/admin/memberModel.php';
         $md = new memberModel;
         $data = $md->getAllMembers();

        $this->render('analytics', null, 'ANALYTICS', 'admin');
    }

    // Trang phân tích thành viên
    function memberAnalytics()
    {
        require_once 'vendor/Model.php';
        // require_once 'models/admin/memberModel.php';
        // $md = new memberModel;
        // $data = $md->getAllMembers();

        $this->render('memberAnalytics', null, 'MEMBER ANALYTICS', 'admin');
    }
}
