/**
 * Ezidcode Pay - Frontend Helper
 * Script ini membantu developer mengecek status pembayaran secara otomatis
 */

class EzidcodePayJS {
    /**
     * Mulai mengecek status transaksi setiap X detik
     * * @param {string} txId Transaction ID dari Ezidcode Pay
     * @param {function} onSuccess Callback jika pembayaran berhasil
     * @param {function} onFailed Callback jika pembayaran gagal/expired
     * @param {number} interval Interval pengecekan dalam milidetik (Default: 10000ms / 10 detik)
     */
    static listen(txId, onSuccess, onFailed, interval = 10000) {
    // Tambahkan fungsi encodeURIComponent
    const checkEndpoint = `https://pay.ezidcode.com/api/check-status.php?tx_id=${encodeURIComponent(txId)}`;
    
    const polling = setInterval(() => {
        // ... (isi blok fetch di tengah tetap dibiarkan sama) ...
    }, interval);
    
    // Tambahkan return agar developer bisa mengeksekusi clearInterval(polling)
    return polling; 
}
            fetch(checkEndpoint)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        if (data.payment_status === 'paid' || data.payment_status === 'completed') {
                            clearInterval(polling); // Hentikan pengecekan jika sudah lunas
                            if (typeof onSuccess === 'function') onSuccess(data);
                        } else if (data.payment_status === 'failed' || data.payment_status === 'expired') {
                            clearInterval(polling); // Hentikan pengecekan jika gagal
                            if (typeof onFailed === 'function') onFailed(data);
                        }
                        // Jika 'pending', biarkan interval terus berjalan
                    }
                })
                .catch(error => console.error('Ezidcode Pay Error:', error));
        }, interval);
    }
}
