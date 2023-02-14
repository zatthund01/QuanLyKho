<?php
require_once ('models/nhacungcap.php');
//?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-center text-gray-800 ">Nhà Cung Cấp</h1>
<!--<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.-->
<!--    For more information about DataTables, please visit the <a target="_blank"-->
<!--                                                               href="https://datatables.net">official DataTables documentation</a>.</p>-->

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách Nhà cung cấp</h6>
    </div>

    <div class="card-body">
        <a href="index.php?controller=nhacungcap&action=insert" class="btn btn-primary mb-3">Thêm</a>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nhà cung cấp</th>
                    <th>Điện thoại</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Nhà cung cấp</th>
                    <th>Điện thoại</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Action</th>
                </tr>
                </tfoot>
                <tbody>

                <?php
                foreach ($nhacungcap as $item){

                    ?>
                    <form method="post">
                        <tr>
                            <td><?= $item->Id   ?></td>
                            <td><?= $item->TenNCC?></td>
                            <td><?= $item->DienThoai?></td>
                            <td><?= $item->Email?></td>
                            <td><?= $item->DiaChi?></td>
                            <td>
                                <!--                       <a  href="index.php?controller=khachhangs&action=showPost&id=--><!--"  class='btn btn-primary mr-3'>Details</a>-->
                                <a  href="index.php?controller=nhacungcap&action=edit&id=<?= $item->Id?>"  class='btn btn-primary mr-3'>Edit</a>
                                <button type="submit" name="dele" value="<?= $item->Id ?>"    class='btn btn-danger'>Delete</button>
                    </form>
                    </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
if(isset($_POST['dele'])){
    $id =$_POST['dele'];
    NhaCungCap::delete($id);
}
?>


