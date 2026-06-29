<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$action = $data['action'] ?? '';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

switch ($action) {
    case 'add':
        $id     = (int)($data['id'] ?? 0);
        $nama   = htmlspecialchars($data['nama'] ?? '');
        $harga  = (float)($data['harga'] ?? 0);
        $qty    = (int)($data['qty'] ?? 1);
        $gambar = htmlspecialchars($data['gambar'] ?? 'kabin1.svg');
        if ($id && $nama && $harga > 0) {
            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]['qty'] += $qty;
            } else {
                $_SESSION['cart'][$id] = compact('id','nama','harga','qty','gambar');
            }
            echo json_encode(['success'=>true,'total_qty'=>array_sum(array_column($_SESSION['cart'],'qty'))]);
        } else {
            echo json_encode(['success'=>false]);
        }
        break;
    case 'remove':
        $id = (int)($data['id'] ?? 0);
        unset($_SESSION['cart'][$id]);
        echo json_encode(['success'=>true,'total_qty'=>array_sum(array_column($_SESSION['cart'],'qty'))]);
        break;
    case 'update':
        $id  = (int)($data['id'] ?? 0);
        $qty = (int)($data['qty'] ?? 1);
        if (isset($_SESSION['cart'][$id]) && $qty > 0) $_SESSION['cart'][$id]['qty'] = $qty;
        echo json_encode(['success'=>true,'total_qty'=>array_sum(array_column($_SESSION['cart'],'qty'))]);
        break;
    case 'get':
        echo json_encode(['success'=>true,'cart'=>array_values($_SESSION['cart']),'total'=>array_sum(array_map(fn($i)=>$i['harga']*$i['qty'],$_SESSION['cart'])),'qty'=>array_sum(array_column($_SESSION['cart'],'qty'))]);
        break;
    default:
        echo json_encode(['success'=>false]);
}
