<?php
// In a real application, developers will include this file
require_once '../src/EzidcodePay.php';

use EzidcodePay\EzidcodePay;

// 1. Initialize API (Developers will insert their Public Key here)
$public_key = 'PUB_16e3f565e09870a4a19b071e31527e66'; 
$ezidcode = new EzidcodePay($public_key);

// 2. Create an Invoice (e.g., product price is $25.50)
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
    die("Failed to create invoice: " . $response['message']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout Example</title>
    <script src="../src/ezidcode-pay.js"></script>
</head>
<body style="font-family: Arial, sans-serif; text-align: center; padding: 50px;">

    <h2>Complete Your Payment</h2>
    <p>Please send exactly <strong><?= $pay_amount ?> <?= $currency ?></strong></p>
    
    <img src="<?= $qr_code ?>" alt="QR Code" style="border: 1px solid #ccc; padding: 10px; border-radius: 8px;">
    
    <p>Wallet Address (TRC20):</p>
    <code style="background: #eee; padding: 10px; display: inline-block; border-radius: 5px;"><?= $pay_address ?></code>

    <h3 id="payment-status" style="color: orange; margin-top: 30px;">⏳ Awaiting Payment...</h3>

    <script>
        // Use JS SDK to check payment status automatically without page refresh
        const txId = "<?= $tx_id ?>";

        EzidcodePayJS.listen(txId, 
            function(successData) {
                // Executed automatically when the buyer completes the transfer
                const statusEl = document.getElementById('payment-status');
                statusEl.innerHTML = "✅ PAYMENT SUCCESSFUL!";
                statusEl.style.color = "green";
                
                // Redirect to success page
                // window.location.href = "success.php";
            }, 
            function(failedData) {
                // Executed automatically if the invoice expires
                const statusEl = document.getElementById('payment-status');
                statusEl.innerHTML = "❌ PAYMENT TIMEOUT";
                statusEl.style.color = "red";
            }
        );
    </script>
</body>
</html>
