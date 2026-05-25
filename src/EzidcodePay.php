<?php

namespace EzidcodePay;

class EzidcodePay {
    private $public_key;
    private $base_url = 'https://pay.ezidcode.com';

    /**
     * Inisialisasi Ezidcode Pay SDK
     * * @param string $public_key Public Key dari Dashboard Ezidcode Pay
     */
    public function __construct($public_key) {
        $this->public_key = $public_key;
    }

    /**
     * Membuat tagihan kripto baru
     * * @param string $order_id ID Pesanan dari sistem/database Anda
     * @param float $amount Jumlah tagihan (Fiat)
     * @param string $currency Mata uang fiat (Contoh: 'USD', 'IDR')
     * @return array Response JSON dari API Ezidcode Pay
     */
    public function createInvoice($order_id, $amount, $currency = 'USD') {
        $endpoint = $this->base_url . '/api/create-invoice.php';
        
        $payload = [
            'public_key'  => $this->public_key,
            'order_id_wp' => (string) $order_id, // Mapping ke endpoint backend Ezidcode
            'amount_fiat' => (float) $amount,
            'currency'    => strtoupper($currency)
        ];

        return $this->sendRequest($endpoint, 'POST', $payload);
    }

    /**
     * Mengecek status transaksi
     * * @param string $tx_id Transaction ID dari Ezidcode Pay
     * @return array Response JSON status pembayaran
     */
    public function checkStatus($tx_id) {
        $endpoint = $this->base_url . '/api/check-status.php?tx_id=' . urlencode($tx_id);
        return $this->sendRequest($endpoint, 'GET');
    }

    /**
     * Eksekutor cURL Internal
     */
    private function sendRequest($url, $method = 'GET', $payload = null) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json'
            ]);
        }

        $response = curl_exec($ch);
        $error    = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return ['status' => 'error', 'message' => 'cURL Error: ' . $error];
        }

        $decoded = json_decode($response, true);
if ($decoded === null && json_last_error() !== JSON_ERROR_NONE) {
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    return [
        'status'  => 'error', 
        'message' => "HTTP {$http_code} | Raw Response: " . strip_tags($response)
    ];
}
return $decoded;
    }
}
