
<?php
require_once ('connection.php');
require_once ('models/khachhang.php');
require_once ('models/nhanvien.php');
require_once ('models/sanpham.php');
require_once ('models/dondathang.php');
require_once ('models/chitietdathang.php');

$list = [];
$db =DB::getInstance();
$reg = $db->query('select * from NhanVien');
foreach ($reg->fetchAll() as $item){
    $list[] =new NhanVien($item['Id'],$item['TenNV'],$item['DienThoai'],$item['Email'],$item['DiaChi'],$item['TaiKhoan'],$item['MatKhau'],$item['IsActive']);
}
//echo $list[0]->TaiKhoan;
//end load nhan vien
//load khach hang
$list1 = [];
$db1 =DB::getInstance();
$reg1 = $db1->query('select * from KhachHang');
foreach ($reg1->fetchAll() as $item){
    $list1[] =new KhachHang($item['Id'],$item['TenKH'],$item['DienThoai'],$item['Email'],$item['DiaChi']);
}
//$data1 =array('khachhang'=> $list1);
//end load nhan vien
$sp = [];
$db_sp =DB::getInstance();
$reg_sp = $db_sp->query('SELECT sp.Id,sp.TenSP,dvt.DonVi,ncc.TenNCC,sp.GiaMua,sp.GiaBan,sp.SoLuong FROM SanPham sp JOIN DonViTinh dvt JOIN NhaCungCap ncc ON sp.IdNCC = ncc.Id AND sp.IdDVT = dvt.Id');
foreach ($reg_sp->fetchAll() as $item){
    $sp[] =new SanPham($item['Id'], $item['TenSP'], $item['DonVi'],$item['TenNCC'], $item['GiaMua'], $item['GiaBan'], $item['SoLuong']);
}

?>
<form  method="post" name="add">
  <div class="form-group">
      <FIELDSET style="border-collapse: collapse;border: 1px solid red" class="ml-5 mr-5">
          <legend class="ml-2">Đơn hàng</legend>
    <div class="form-group ml-5">
        <div class="col-md-12 mb-3">
            <label for="validationDefault01">Khách Hàng</label>
            <select class="form-control" name="khachhang">
                <optgroup style="color: #1cc6a4" label="Chọn Khách Hàng">
                <?php
                foreach ($list1 as $item){
                    echo  "<option value='$item->Id'>".$item->TenKH."</option>";
                }
                ?>
                </optgroup>
            </select>
        </div>
    </div>
       <div class="form-inline ml-5">


       </div>
        <div class="form-row">
        <div class="form-group col-md-4 ml-5">
            <label for="validationDefault02">Ngày bán</label>
            <input type="datetime-local" class="form-control" name="ngayban">
        </div>

            <div class="form-group col-md-4 ml-5">
                <label for="validationDefault02">Trạng thái</label>
                <select class="form-control" name="trangthai" >
                    <option value="">Chọn trạng thái</option>
                    <option value="1">Đã nhận hàng</option>
                    <option value="0">Chưa nhận hàng</option>
                </select>
            </div>
          <div class="form-group col-md-2 ml-5">
              <label for="validationDefault02">Nhân viên</label>
              <select class="form-control" name="nhanvien">

                  <?php
                  foreach ($list as $item){
                    //if ($item->TaiKhoan == $_SESSION['username'])
                      echo "<option value='$item->Id'>".$item->TenNV."</option>";
                  }
                  ?>

              </select>
          </div>

        </div>
      </FIELDSET>
<!--   end //-->
    <FIELDSET style="border-collapse: collapse;border: 1px solid red" class="mt-5 ml-5 mr-5">
        <legend class="ml-2">Chi tiết đơn</legend>
    <div class="form-row ml-4">

        <div class="col-md-4 form-group mb-3">
            <label class="" for="validationDefault01">Sản Phẩm</label>
           <select class="form-control" id="sp_ma" name="sp_ma">
               <optgroup label="chọn sản phẩm">
                   <?php
                   foreach ($sp as $item){
                       echo "<option value='$item->Id' data-sp_sl='$item->SoLuong' data-sp_gia='$item->GiaBan' >".$item->TenSP."</option>";
                   }
                   ?>
               </optgroup>
           </select>
        </div>
        <div class="col-md-3 form-group mb-3">
            <label for="validationDefault01">Số lượng</label>
            <input type="number" class="form-control" value="1" id="soluong" name="soluong"  placeholder="Số lượng" >
        </div>
        <div class="col-md-1 form-group mb-3">
            <label for="validationDefault01">Action</label>

          <input class="form-control btn btn-outline-primary" id="btnThemSanPham" value="thêm">
        </div>

    </div>

        <table id="tblChiTietDonHang" class="table table-bordered">
            <thead>
            <th>Sản phẩm</th>
            <th>Số lượng</th>
            <th>Đơn giá</th>
            <th>Thành tiền</th>
            <th>Hành động</th>
            </thead>
            <tbody>
            </tbody>
        </table>
    </FIELDSET>
      <button type="submit" name="add" class=" mt-2 ml-5 btn-danger btn">Tạo </button>
  </div>

</form>
<?php


// mảng array do đặt tên name="sp_dh_dongia[]"
if (isset($_POST['add'])){
    $arr_sp_ma = $_POST['sp_ma'];                   // mảng array do đặt tên name="sp_ma[]"
    $arr_sp_dh_soluong = $_POST['sp_dh_soluong'];   // mảng array do đặt tên name="sp_dh_soluong[]"
    $arr_sp_dh_dongia = $_POST['sp_dh_dongia'];// mảng array do đặt tên name="sp_dh_dongia[]"
    $arr_sp = $_POST['sp_dh_sl'];
    $arr_sp_dh_tong=[];
    $tongdon=0;
    $date = date('m/d/Y h:i:s a', time());
  for ($i = 0;$i< count($arr_sp_ma);$i++){
    $arr_sp_dh_tong[$i] = $arr_sp_dh_soluong[$i]*$arr_sp_dh_dongia[$i];
      $tongdon+=$arr_sp_dh_tong[$i];
  }
//    echo print_r($arr_sp_dh_tong);
//    echo  number_format($tongdon,0,".",",");


    //khach hàng đơn
    $khachhang = $_POST['khachhang']; //id khach hang
    $nhanvien = $_POST['nhanvien'];     //id nhan vien
    $trangthai = $_POST['trangthai'];   //trang thai don
    $ngayban = $_POST['ngayban'];   //trang thai don
    DonDatHang::add($ngayban,$nhanvien,$khachhang,$tongdon,$trangthai);

    $dondathang = [];
    $db_db =DB::getInstance();
    $reg_db = $db_db->query('SELECT * FROM DonBan ORDER BY Id DESC');
    foreach ($reg_db->fetchAll() as $item){
        $dondathang[] =new DonDatHang($item['Id'],$item['NgayBan'],$item['IdNV'],$item['IdKH'],$item['Tong'],$item['TrangThai']);;
    }
    echo $dondathang[0]->Id;
    $IdDon = $dondathang[0]->Id;
    echo $khachhang;
    echo  $nhanvien;
    echo $trangthai;

    for($i = 0; $i < count($arr_sp_ma); $i++) {

        $sp_ma = $arr_sp_ma[$i];
        $sp_dh_soluong = $arr_sp_dh_soluong[$i];
        $sp_dh_dongia = $arr_sp_dh_dongia[$i];
        $thanhtien =$arr_sp_dh_tong[$i];
        $soluongcu = $arr_sp[$i];
    ChiTietDatHang::add($IdDon,$sp_ma,0,$sp_dh_dongia,$sp_dh_soluong,$thanhtien);
    SanPham::updatesl($sp_ma,$soluongcu+$sp_dh_soluong);
    }
        header('location:index.php?controller=dondathang');
}
?>
