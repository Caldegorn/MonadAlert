<?php
// Configuration
$rpcUrl = "https://rpc.testnet.monad.xyz";
$walletAddress = "0xYourMonadTestnetWalletAddress";
$lastBalanceFile = "last_balance.txt";
$alertEmail = "your.email@example.com";

// Function to query balance via JSON-RPC
function getBalance($rpcUrl, $address) {
    $postData = [
        'jsonrpc' => '2.0',
        'method' => 'eth_getBalance',
        'params' => [$address, 'latest'],
        'id' => 1
    ];

    $ch = curl_init($rpcUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);
    if (isset($data['result'])) {
        return hexdec($data['result']); // Balance in Wei
    }
    return false;
}

// Read last balance
$lastBalance = 0;
if (file_exists($lastBalanceFile)) {
    $lastBalance = (float)file_get_contents($lastBalanceFile);
}

// Get current balance
$currentBalance = getBalance($rpcUrl, $walletAddress);

if ($currentBalance === false) {
    echo "Failed to fetch balance.\n";
    exit(1);
}

echo "Current balance (Wei): $currentBalance\n";
echo "Last balance (Wei): $lastBalance\n";

// Check if balance increased
if ($currentBalance > $lastBalance) {
    $difference = $currentBalance - $lastBalance;
    $differenceEth = $difference / 1e18; // Convert Wei to Ether

    // Send alert email
    $subject = "Monad Testnet Faucet Alert";
    $message = "Your wallet $walletAddress received $differenceEth MND tokens from the faucet.";
    $headers = "From: no-reply@yourdomain.com\r\n";

    if (mail($alertEmail, $subject, $message, $headers)) {
        echo "Alert email sent.\n";
        // Update last balance
        file_put_contents($lastBalanceFile, $currentBalance);
    } else {
        echo "Failed to send alert email.\n";
    }
} else {
    echo "No new tokens received.\n";
}
