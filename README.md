# Ezidcode Pay - PHP & JavaScript SDK

![Ezidcode Pay](https://ui-avatars.com/api/?name=Ezidcode+Pay&background=0D8ABC&color=fff&rounded=true)

Official PHP & JavaScript SDK for integrating [Ezidcode Pay](https://pay.ezidcode.com) global cryptocurrency payment gateway into your custom web applications.

Accept USDT, BTC, ETH, and other cryptocurrencies on your website directly with zero blockchain programming required.

## Features
* 🚀 **Create Invoices:** Generate crypto payment addresses and QR codes instantly.
* 🔄 **Auto-Polling (JS):** Listen to blockchain confirmations in real-time without refreshing the page.
* 🛡 **Secure:** Communicates securely with the Ezidcode Pay SaaS infrastructure.

## Installation

Download the `src/EzidcodePay.php` and `src/ezidcode-pay.js` files and include them in your project.

## Quick Start (PHP)

### 1. Create a Payment Invoice
Include the PHP SDK and pass your **Public Key** (obtained from your Merchant Dashboard).

```php
require_once 'src/EzidcodePay.php';
use EzidcodePay\EzidcodePay;

$ezidcode = new EzidcodePay('YOUR_PUBLIC_KEY');

// Create an invoice for $50.00
$response = $ezidcode->createInvoice('ORDER_ID_12345', 50.00, 'USD');

if ($response['status'] === 'success') {
    $invoice = $response['data'];
    echo "Please pay: " . $invoice['pay_amount'] . " " . $invoice['pay_currency'];
    echo "Send to: " . $invoice['pay_address'];
    echo "QR Code: <img src='" . $invoice['qr_code'] . "'>";
} else {
    echo "Error: " . $response['message'];
}
