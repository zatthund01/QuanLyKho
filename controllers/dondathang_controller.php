
<?php
require_once ('controllers/base_controller.php');
require_once ('models/dondathang.php');
class DonDatHangController extends BaseController
{
    function  __construct()
    {
        $this->folder = 'dondathang';
    }
    public function  index()
    {
        $dondathang = DonDatHang::all();
        $data =array('donban'=> $dondathang);
        $this->render('index',$data);
    }
    public function  insert()
    {
        $this->render('insert');
    }
    public function  show()
    {
        $dondathang = DonDatHang::find($_GET['id']);
        $data = array('donban' => $dondathang);
        $this->render('show', $data);
    }
    public function  print()
    {
        $dondathang = DonDatHang::find($_GET['id']);
        $data = array('donban' => $dondathang);
        $this->render('print', $data);
    }

}
