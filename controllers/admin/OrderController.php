class OrderController extends Controller
{
    function __construct()
    {
        $this->folder = "admin";
        // Kiểm tra session admin
        if (!isset($_SESSION['admin'])) {
            // Cập nhật lại URL sử dụng domain ảo
            $url = "http://" . $_SERVER['HTTP_HOST'] . "/WBH_MVC/indexadmin";
            header("Location: $url");
        }
    }

    function index()
    {
        require_once 'vendor/Model.php';
        require_once 'models/admin/orderModel.php';
        $md = new orderModel;
        $data = $md->getAllOrders();
        $this->render('order', $data, 'GIAO DỊCH', 'admin');
    }

    function gerOrderById()
    {
        require_once 'vendor/Model.php';
        require_once 'models/admin/orderModel.php';
        $md = new orderModel;
        $magd = isset($_GET['magd']) ? $_GET['magd'] : '';
        $data = $md->gerOrderById();
        $tmp = array_values($data[0]);
        $rs = "array(";
        $x = '';
        foreach ($tmp as $key => $value) {
            if ($key % 2 != 0) {
                continue;
            }
            $rs .= "'" . $key . "'=>'" . $value . "',";
        }
        echo $rs;
    }

    function action()
    {
        $slt = $action = '';
        if (isset($_GET['selected'])) {
            $slt = $_GET['selected'];
        }
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
        }
        if ($slt == '') {
            echo "Bạn chưa chọn giao dịch!";
            return;
        }

        require_once 'vendor/Model.php';
        require_once 'models/admin/orderModel.php';
        $md = new orderModel;

        for ($i = 0; $i < count($slt); $i++) {
            switch ($action) {
                case 'shipped':
                    $md->update('giaodich', 'tinhtrang', '1', "magd = '" . $slt[$i] . "'");
                    break;
                case 'unshipped':
                    $md->update('giaodich', 'tinhtrang', '0', "magd = '" . $slt[$i] . "'");
                    break;
                case 'del':
                    $md->delete('giaodich', "magd = '" . $slt[$i] . "'");
                    break;
                case 'cancel':
                    $md->update('giaodich', 'tinhtrang', '2', "magd = '" . $slt[$i] . "'");
                    break;
                default:
                    echo "Error!";
                    break;
            }
        }
        echo "success";
    }
}
