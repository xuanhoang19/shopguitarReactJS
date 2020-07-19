<?php

$type = $_GET['tp'];
if ($type == 'signup') signup();
elseif ($type == 'login') login();
elseif ($type == 'feed') feed();
elseif ($type == 'feedUpdate') feedUpdate();
elseif ($type == 'feedDelete') feedDelete();
elseif ($type == 'listProductType') ListProductType();
elseif ($type == 'listManuFacturer') ListManuFacturer();
elseif ($type == 'listProductSellFast') ListProductSellFast();
elseif ($type == 'listNewProduct') ListNewProduct();
elseif ($type == 'listProduct') ListProduct();
elseif ($type == 'detailProduct') DetailProduct();
elseif ($type == 'getUser') GetUser();
elseif ($type == 'productCart') ProductCart();
elseif ($type == 'sttOrdersForTheDay') SttOrdersForTheDay();
elseif ($type == 'postOrder') PostOrder();
elseif ($type == 'postOrderDetail') PostOrderDetail();


function PostOrderDetail() {
    require 'config.php';
    $json = json_decode(file_get_contents('php://input'), true);
    $MaChiTietDonDatHang = $json['MaChiTietDonDatHang'];
    $SoLuong = $json['SoLuong'];
    $GiaBan = $json['GiaBan'];
    $MaDonDatHang = $json['MaDonDatHang'];
    $MaSanPham = $json['MaSanPham'];

    $feedData = '';
    if ($GiaBan != 0) {
        $query = "INSERT INTO chitietdondathang ( MaChiTietDonDatHang, SoLuong, GiaBan, MaDonDatHang, MaSanPham)
        VALUES ('$MaChiTietDonDatHang','$SoLuong','$GiaBan','$MaDonDatHang','$MaSanPham')";
        $db->query($query);
    }
    $query = "SELECT * FROM chitietdondathang WHERE MaChiTietDonDatHang = $MaChiTietDonDatHang";
    $result = $db->query($query);

    $feedData = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $feedData = json_encode($feedData);
}
  

function PostOrder() {
    require 'config.php';
    $json = json_decode(file_get_contents('php://input'), true);
    $MaDonHang = $json['MaDonHang'];
    $NgayLap = $json['NgayLap'];
    $TongThanhTien = $json['TongThanhTien'];
    $MaTaiKhoan = $json['MaTaiKhoan'];
    $MaTinhTrang = $json['MaTinhTrang'];

    $feedData = '';
    if ($TongThanhTien != 0) {
        $query = "INSERT INTO dondathang ( MaDonDatHang, NgayLap, TongThanhTien, MaTaiKhoan, MaTinhTrang)
        VALUES ('$MaDonHang','$NgayLap','$TongThanhTien','$MaTaiKhoan','$MaTinhTrang')";
        $db->query($query);
    }
    $query = "SELECT * FROM dondathang WHERE MaDonDatHang = $MaDonHang";
    $result = $db->query($query);

    $feedData = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $feedData = json_encode($feedData);

    echo '{"feedData":' . $feedData . '}';
}

function SttOrdersForTheDay() {
    require 'config.php';
    $json = json_decode(file_get_contents('php://input'), true);
    $day = $json["day"];

    $query = "select count(*) as SoThuTu from dondathang where NgayLap like '$day'";
    $result = $db->query($query);

    $feedData = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $feedData = json_encode($feedData);

    echo '{"feedData":' . $feedData . '}';
}

function ProductCart(){
    require 'config.php';
    $json = json_decode(file_get_contents('php://input'), true);
    $idProduct = $json["idProduct"];

    $query = "select * from sanpham where MaSanPham = $idProduct";
    $result = $db->query($query);

    $feedData = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $feedData = json_encode($feedData);

    echo '{"feedData":' . $feedData . '}';
}

function GetUser(){
    require 'config.php';
    $json = json_decode(file_get_contents('php://input'), true);
    $idUser = $json["idUser"];

    $query = "select * from taikhoan where MaTaiKhoan = $idUser";
    $result = $db->query($query);

    $feedData = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $feedData = json_encode($feedData);

    echo '{"feedData":' . $feedData . '}'; 
}

function DetailProduct(){
    require 'config.php';
    $json = json_decode(file_get_contents('php://input'), true);
    $idDetailProduct = $json["idDetailProduct"];

    $query = "select * from sanpham where MaSanPham = $idDetailProduct";
    $result = $db->query($query);

    $feedData = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $feedData = json_encode($feedData);

    echo '{"feedData":' . $feedData . '}';
}

function ListProduct(){
    require 'config.php';
    $json = json_decode(file_get_contents('php://input'), true);
    $productType = $json['productType'];
    $manuFacturer = $json['manuFacturer'];

    $query = "select * from sanpham where MaLoaiSanPham = $productType and MaHangSanXuat = $manuFacturer";
    $result = $db->query($query);

    $feedData = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $feedData = json_encode($feedData);

    echo '{"feedData":' . $feedData . '}';
}

function ListNewProduct()
{
    require 'config.php';
    $json = json_decode(file_get_contents('php://input'), true);

    $query = "select * from sanpham ORDER BY NgayNhap DESC LIMIT 0,8";
    $result = $db->query($query);

    $feedData = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $feedData = json_encode($feedData);

    echo '{"feedData":' . $feedData . '}';
}

function ListProductSellFast()
{
    require 'config.php';
    $json = json_decode(file_get_contents('php://input'), true);

    $query = "select * from sanpham ORDER BY SoLuongBan DESC LIMIT 0,8";
    $result = $db->query($query);

    $feedData = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $feedData = json_encode($feedData);

    echo '{"feedData":' . $feedData . '}';
}

function ListProductType()  //  loai san pham
{
    require 'config.php';
    $json = json_decode(file_get_contents('php://input'), true);

    $query = "select * from loaisanpham";
    $result = $db->query($query);

    $feedData = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $feedData = json_encode($feedData);

    echo '{"feedData":' . $feedData . '}';
}

function ListManuFacturer () // hang san xuat
{
    require 'config.php';
    $json = json_decode(file_get_contents('php://input'), true);
    $id = $json['id'];

    $query = "select DISTINCT hsx.MaHangSanXuat, hsx.TenHangSanXuat from hangsanxuat hsx, sanpham sp where sp.MaLoaiSanPham = '$id' and hsx.MaHangSanXuat = sp.MaHangSanXuat";
    $result = $db->query($query);

    $feedData = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $feedData = json_encode($feedData);
    echo '{"feedData":' . $feedData . '}';
}

function login()
{
    require 'config.php';
    $json = json_decode(file_get_contents('php://input'), true);
    $username = $json['username'];
    $password = $json['password'];
    $userData = '';
    $query = "select * from taikhoan where TenDangNhap='$username' and MatKhau='$password'";
    $result = $db->query($query);
    $rowCount = $result->num_rows;

    if ($rowCount > 0) {
        $userData = $result->fetch_object();
        $user_id = $userData->MaTaiKhoan;
        $userData = json_encode($userData);
        echo '{"userData":' . $userData . '}';
    } else {
        echo '{"error":"Wrong username and password"}';
    }
}



function signup()
{

    require 'config.php';


    $json = json_decode(file_get_contents('php://input'), true);
    $username = $json['username'];
    $password = $json['password'];
    $name = $json['name'];
    $gmail = $json['gmail'];
    $phone = $json['phone'];
    $address = $json['address'];

    $username_check = preg_match("/^[A-Za-z0-9_]{4,10}$/i", $username);
    $password_check = preg_match('/^[A-Za-z0-9!@#$%^&*()_]{4,20}$/i', $password);
    $gmail_check = preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$/i', $gmail);
    $phone_check = preg_match('/^[0-9]{9,10}$/i', $phone);

    if ($username_check == 0)
        echo '{"error":"Invalid username"}';
    elseif ($gmail_check == 0)
        echo '{"error":"Invalid gmail"}';
    elseif ($password_check == 0)
        echo '{"error":"Invalid password"}';
    elseif ($phone_check == 0)
        echo '{"error":"Invalid phone"}';

    elseif (strlen(trim($username)) > 0 && strlen(trim($password)) > 0 && strlen(trim($gmail)) > 0 &&
        strlen($gmail) > 0 && $username_check > 0 && $password_check > 0 && strlen($phone) > 0 && strlen($address) > 0) {


        $userData = '';

        $result = $db->query("select * from taikhoan where TenDangNhap='$username' or Email='$gmail'");
        $rowCount = $result->num_rows;
        //echo '{"text": "'.$rowCount.'"}';

        if ($rowCount == 0) {

            $db->query("INSERT INTO taikhoan(TenDangNhap,MatKhau,TenHienThi,DiaChi,DienThoai,Email,BiXoa,MaLoaiTaiKhoan)
                            VALUES('$username','$password','$name','$address','$phone','$gmail',0,1)");

            $userData = '';
            $query = "select * from taikhoan where TenDangNhap='$username' and MatKhau='$password'";
            $result = $db->query($query);
            $userData = $result->fetch_object();
            //$user_id = $userData->MaTaiKhoan;
            $userData = json_encode($userData);
            echo '{"userData":' . $userData . '}';
        } else {
            echo '{"error":"username or gmail exists"}';
        }
    }
    else {
        echo '{"text":"Enter valid data2"}';
    }
}


function feed()
{

    require 'config.php';
    $json = json_decode(file_get_contents('php://input'), true);
    $user_id = $json['user_id'];

    $query = "SELECT * FROM feed WHERE user_id=$user_id ORDER BY feed_id DESC LIMIT 10";
    //$query = "SELECT * FROM feed ";
    $result = $db->query($query);

    $feedData = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $feedData = json_encode($feedData);

    echo '{"feedData":' . $feedData . '}';
}


function feedUpdate()
{

    require 'config.php';
    $json = json_decode(file_get_contents('php://input'), true);
    $user_id = $json['user_id'];
    $feed = $json['feed'];

    $feedData = '';
    if ($user_id != 0) {
        $query = "INSERT INTO feed ( feed, user_id) VALUES ('$feed','$user_id')";
        $db->query($query);
    }
    $query = "SELECT * FROM feed WHERE user_id=$user_id ORDER BY feed_id DESC LIMIT 10";
    $result = $db->query($query);

    $feedData = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $feedData = json_encode($feedData);

    echo '{"feedData":' . $feedData . '}';
}

function feedDelete()
{
    require 'config.php';
    $json = json_decode(file_get_contents('php://input'), true);
    $user_id = $json['user_id'];
    $feed_id = $json['feed_id'];

    $query = "Delete FROM feed WHERE user_id=$user_id AND feed_id=$feed_id";
    $result = $db->query($query);
    if ($result) {
        echo '{"success":"Feed deleted"}';
    } else {

        echo '{"error":"Delete error"}';
    }
}
