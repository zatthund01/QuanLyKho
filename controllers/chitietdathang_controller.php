
<?php
require_once ('controllers/base_controller.php');
require_once ('models/chitietdathang.php');
class ChiTietDatHangController extends BaseController
{
    function  __construct()
    {
        $this->folder = 'chitietdathang';
    }
    public function  index()
    {
        $ctb = ChiTietDatHang::all();
        $data =array('ctb'=> $ctb);
        $this->render('index',$data);
    }
    public function  insert()
    {
        $this->render('insert');
    }
    public function edit()
    {
        $dondathang = DonDatHang::find($_GET['id']);
        $data =array('donban'=> $dondathang);
        $this->render('edit',$data);
    }
}
