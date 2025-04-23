class ProductAdminController extends Controller
{
    function __construct()
    {
        $this->folder = "admin";
        if (!isset($_SESSION['admin'])) {
            $baseURL = "http://" . $_SERVER['HTTP_HOST'] . "/WBH_MVC/indexadmin";
            header("Location: $baseURL");
        }
    }

    function index()
    {
        require_once 'vendor/Model.php';
        require_once 'models/admin/productModel.php';
        $md = new productModel;
        $data = $md->getAllPrds();
        $this->render('product', $data, 'SẢN PHẨM', 'admin');
    }
}
