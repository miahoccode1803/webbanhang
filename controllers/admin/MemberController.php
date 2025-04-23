<?php

class MemberController extends Controller
{
    function __construct()
    {
        $this->folder = "admin";

        if (!isset($_SESSION['admin'])) {
            header("Location: " . INDEX_URL . "indexadmin");
            exit();
        }
    }

    // Hiển thị danh sách thành viên
    function index()
    {
        require_once 'vendor/Model.php';
        require_once 'models/admin/memberModel.php';

        $memberModel = new memberModel;
        $data = $memberModel->getAllMembers();

        $this->render('member', $data, 'THÀNH VIÊN', 'admin');
    }

    // Xử lý thêm, xóa thành viên
    function action()
    {
        require_once 'vendor/Model.php';
        require_once 'models/admin/memberModel.php';

        $memberModel = new memberModel;

        $actionName = $_POST['name'] ?? '';
        $id = $_POST['id'] ?? '';

        switch ($actionName) {
            case 'del':
                if (is_numeric($id)) {
                    $memberModel->delete('thanhvien', 'id = ' . intval($id));
                    echo "Deleted";
                } else {
                    echo "Invalid ID!";
                }
                break;

            case 'add':
                $data = [
                    '', // auto increment id
                    $_POST['name2'] ?? 'No info',
                    $_POST['username'] ?? 'No info',
                    $_POST['password'] ?? 'No info',
                    $_POST['addr'] ?? 'No info',
                    $_POST['tel'] ?? 'No info',
                    $_POST['email'] ?? 'No info',
                    (new DateTime(null, new DateTimeZone('Asia/Ho_Chi_Minh')))->format('Y-m-d H:i:s'),
                    '0' // quyền mặc định
                ];

                if ($memberModel->insert('thanhvien', $data)) {
                    echo "Added";
                } else {
                    echo "Insert failed!";
                }
                break;

            default:
                echo "Error!";
                break;
        }
    }
}
