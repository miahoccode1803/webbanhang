<?php

class CategoryController extends Controller
{
    function __construct()
    {
        $this->folder = "admin";

        // Dùng hằng INDEX_URL thay vì domain cứng
        if (!isset($_SESSION['admin'])) {
            header("Location: " . INDEX_URL . "indexadmin");
            exit();
        }
    }

    // Hiển thị danh mục sản phẩm
    function index()
    {
        require_once 'vendor/Model.php';
        require_once 'models/admin/categoryModel.php';
        $md = new categoryModel;
        $data = $md->getAllCtgrs();

        $this->render('category', $data, 'DANH MỤC SẢN PHẨM', 'admin');
    }

    // Xử lý thêm, xóa, sửa danh mục
    function action()
    {
        require_once 'vendor/Model.php';
        require_once 'models/admin/categoryModel.php';
        $md = new categoryModel;

        $actionName = $_GET['name'] ?? '';
        $id         = $_GET['id'] ?? '';

        switch ($actionName) {
            case 'add':
                $cname    = $_GET['cname'] ?? '';
                $ccountry = $_GET['ccountry'] ?? '';

                if (trim($cname) === '') {
                    echo "Bạn chưa điền tên danh mục!";
                    return;
                }

                $data = ['', $cname, $ccountry];
                if ($md->insert('danhmucsp', $data)) {
                    echo "OK";
                }
                break;

            case 'del':
                if (!empty($id)) {
                    $md->delete('danhmucsp', 'madm = ' . intval($id));
                    echo "OK";
                }
                break;

            case 'edit':
                $n4edit = $_GET['name4edit'] ?? '';
                $c4edit = $_GET['country4edit'] ?? '';

                if (!empty($id)) {
                    $setRow = ['tendm', 'xuatsu'];
                    $setVal = [$n4edit, $c4edit];
                    $md->update('danhmucsp', $setRow, $setVal, 'madm = ' . intval($id));
                    echo "OK";
                }
                break;

            default:
                echo "Thao tác không hợp lệ.";
                break;
        }
    }
}
