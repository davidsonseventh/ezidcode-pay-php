/**
 * Ezidcode Pay - Frontend Helper
 * This script helps developers automatically check the payment status.
 */

class EzidcodePayJS {
    /**
     * Start checking transaction status every X seconds
     * @param {string} txId Transaction ID from Ezidcode Pay
     * @param {function} onSuccess Callback if payment is successful
     * @param {function} onFailed Callback if payment fails/expires
     * @param {number} interval Polling interval in milliseconds (Default: 10000ms / 10 seconds)
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
                            clearInterval(polling); // Stop polling if payment is completed
                            if (typeof onSuccess === 'function') onSuccess(data);
                        } else if (data.payment_status === 'failed' || data.payment_status === 'expired') {
                            clearInterval(polling); // Stop polling if payment fails
                            if (typeof onFailed === 'function') onFailed(data);
                        }
                        // If 'pending', let the interval continue
                    }
                })
                .catch(error => console.error('Ezidcode Pay Error:', error));
        }, interval);
    }
}
