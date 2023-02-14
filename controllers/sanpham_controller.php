<?php
require_once ('controllers/base_controller.php');
require_once ('models/sanpham.php');

class SanPhamController extends BaseController
{
    function __construct()
    {
        $this->folder='sanpham';
    }
    public function index()
    {
        $sanpham = SanPham::all();
        $data =array('sanpham'=>$sanpham);
        $this->render('index',$data);
    }
    public function insert()
    {
        $this->render('insert');
    }
    public function edit()
    {
        $sanpham = SanPham::find($_GET['id']);
        $data = array('sanpham'=>$sanpham);
        $this->render('edit', $data);
    }
    public function search(){
        if(isset($_POST['TenSanPham'])){
            $CheckSanPham = SanPham::find($_POST['TenSanPham']);
            $data = array('sanpham'=>$CheckSanPham);
            $this -> render('search', $data);
        }
    }
    
}