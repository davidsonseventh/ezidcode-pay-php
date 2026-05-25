<?php
// Di aplikasi sungguhan, developer akan memanggil file ini
require_once '../src/EzidcodePay.php';

use EzidcodePay\EzidcodePay;

// 1. Inisialisasi API (Developer akan memasukkan Public Key mereka)
$public_key = 'PUB_16e3f565e09870a4a19b071e31527e66'; 
$ezidcode = new EzidcodePay($public_key);

// 2. Buat Tagihan (Misalnya harga barang $25.50)
$order_id = 'INV-' . time();
$response = $ezidcode->createInvoice($order_id, 25.50, 'USD');

if ($response['status'] === 'success') {
    $invoice = $response['data'];
    $tx_id = $invoice['tx_id'];
    $qr_code = $invoice['qr_code'];
    $pay_address = $invoice['pay_address'];
    $pay_amount = $invoice['pay_amount'];
    $currency = $invoice['pay_currency'];
} else {
    die("Gagal membuat tagihan: " . $response['message']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout Example</title>
    <script src="../src/ezidcode-pay.js"></script>
</head>
<body style="font-family: Arial, sans-serif; text-align: center; padding: 50px;">

    <h2>Selesaikan Pembayaran Anda</h2>
    <p>Silakan kirim tepat <strong><?= $pay_amount ?> <?= $currency ?></strong></p>
    
    <img src="<?= $qr_code ?>" alt="QR Code" style="border: 1px solid #ccc; padding: 10px; border-radius: 8px;">
    
    <p>Alamat Dompet (TRC20):</p>
    <code style="background: #eee; padding: 10px; display: inline-block; border-radius: 5px;"><?= $pay_address ?></code>

    <h3 id="payment-status" style="color: orange; margin-top: 30px;">⏳ Menunggu Pembayaran...</h3>

    <script>
        // Gunakan JS SDK untuk mengecek status lunas otomatis tanpa refresh halaman
        const txId = "<?= $tx_id ?>";

        EzidcodePayJS.listen(txId, 
            function(successData) {
                // Dieksekusi otomatis saat pembeli selesai transfer
                const statusEl = document.getElementById('payment-status');
                statusEl.innerHTML = "✅ PEMBAYARAN BERHASIL!";
                statusEl.style.color = "green";
                
                // Redirect ke halaman sukses
                // window.location.href = "success.php";
            }, 
            function(failedData) {
                // Dieksekusi otomatis jika tagihan expired
                const statusEl = document.getElementById('payment-status');
                statusEl.innerHTML = "❌ WAKTU PEMBAYARAN HABIS";
                statusEl.style.color = "red";
            }
        );
    </script>
</body>
</html>
