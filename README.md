# Ezidcode Pay - Native PHP & JavaScript SDK

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%207.4-8892BF.svg)](https://php.net)
[![JavaScript](https://img.shields.io/badge/JavaScript-ES6%2B-F7DF1E.svg)](https://developer.mozilla.org)

Welcome to the official **Ezidcode Pay SDK** repository for Native PHP and JavaScript. This standalone, platform-agnostic library allows developers to integrate decentralized cryptocurrency payment processing into any custom website, CMS, or enterprise web application without relying on third-party frameworks or heavy dependencies.

With this SDK, you can instantly accept global crypto assets (such as **USDT on the TRON TRC20 network**) directly into your merchant ecosystem.

---

## Table of Contents
1. [Key Features](#key-features)
2. [Prerequisites](#prerequisites)
3. [Repository Structure](#repository-structure)
4. [Installation](#installation)
5. [Backend PHP SDK Reference](#backend-php-sdk-reference)
   - [Initialization](#1-initialization)
   - [Create a Payment Invoice](#2-create-a-payment-invoice)
   - [Check Transaction Status Manually](#3-check-transaction-status-manually)
6. [Frontend JavaScript SDK Reference](#frontend-javascript-sdk-reference)
   - [Real-Time Payment Polling](#1-real-time-payment-polling)
7. [Complete Implementation Example](#complete-implementation-example)
   - [Step A: Create Payment Handler (`create-payment.php`)](#step-a-create-payment-handler-create-paymentphp)
   - [Step B: Customer Checkout Interface (`checkout-view.php`)](#step-b-customer-checkout-interface-checkout-viewphp)
   - [Step C: Automated Webhook Callback (`webhook-listener.php`)](#step-c-automated-webhook-callback-webhook-listenerphp)
8. [Security Protocols & IP Whitelisting](#security-protocols--ip-whitelisting)
9. [Error Codes & Troubleshooting](#error-codes--troubleshooting)
10. [License](#license)

---

## Key Features
- **Zero Framework Overhead:** Pure native PHP and vanilla ES6 JavaScript implementation.
- **Agnostic & Scalable:** Fully compatible with custom PHP applications, Laravel, Symfony, CodeIgniter, or raw HTML environments.
- **Automated Polling Engine:** Lightweight client-side asynchronous engine to detect on-chain completions instantly without hard page refreshes.
- **Enterprise-Grade Security:** Hardened request layer compatible with mandatory multi-layered server-side IP whitelisting.

---

## Prerequisites
Before rolling out production implementations, verify your infrastructure meets the following baseline thresholds:
- **PHP Environment:** Version 7.4 or higher.
- **PHP Extensions:** `curl` (Client URL Library) and `json` extensions must be compiled and active.
- **Network Permissions:** Your server must have outbound SSL routing enabled to query `https://pay.ezidcode.com`.

---

## Repository Structure
Maintain the following file distribution pattern inside your web asset directories:

```text
ezidcode-pay-sdk/
│
├── src/
│   ├── EzidcodePay.php        # Core Backend Class Handler (PHP Namespace Framework)
│   └── ezidcode-pay.js        # Asynchronous Frontend Polling Engine (JavaScript ES6)
│
├── examples/
│   ├── create-payment.php     # Server-side API payload execution mock up
│   ├── checkout-view.php      # Frontend UI invoice rendering layout
│   └── webhook-listener.php   # Asynchronous blockchain validation controller
│
└── README.md                  # System Documentation Ledger
