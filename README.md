
# MonadAlert

**Monad Testnet Faucet Alert**

## Overview

MonadAlert is a simple PHP-based alert system designed to monitor your wallet balance on the Monad testnet and notify you when new tokens are received from the Monad Faucet. This helps developers and testers keep track of faucet token distributions automatically.

## Features

- Periodically checks Monad testnet wallet balance via JSON-RPC
- Detects increases in balance indicating faucet token receipt
- Sends alert notifications via email
- Easy to configure and run on any PHP-enabled server
- Suitable for automation with cron jobs

## Prerequisites

- PHP 7.0 or higher with `curl` and `mail` support enabled
- Access to the Monad testnet RPC endpoint (`https://rpc.testnet.monad.xyz`)
- A Monad testnet wallet address to monitor
- An email address to receive alerts

## Installation

1. Clone the repository:

```
git clone https://github.com/Caldegorn/MonadAlert.git
cd MonadAlert
```

2. Configure the script `mon.php`:

- Set your Monad testnet wallet address
- Set the recipient email address for alerts
- Adjust RPC URL if needed

3. (Optional) Set up a cron job to run the script periodically:

```
*/10 * * * * /usr/bin/php /path/to/MonadAlert/mon.php
```

This example runs the script every 10 minutes.

## Usage

Run the script manually:

```
php mon.php
```

The script will:

- Fetch the current balance of your wallet on the Monad testnet
- Compare it with the last recorded balance stored locally
- If the balance has increased, send an alert email notifying you of the new tokens received
- Update the stored balance for future comparisons

## Example Output

```
Current balance (Wei): 1000000000000000000
Last balance (Wei): 0
Alert email sent: You received 1 Monad tokens from the faucet.
```

## Customization

- Modify the alert method (e.g., integrate SMS or Slack notifications)
- Store balance data in a database instead of a file for scalability
- Extend support for multiple wallet addresses

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

