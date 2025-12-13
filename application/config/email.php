<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Email Configuration
 * SMTP settings for sending emails
 */

// SMTP Protocol
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.gmail.com';  // change with SMTP host Anda
$config['smtp_port'] = 587;
$config['smtp_user'] = '';  // change with your configuration email
$config['smtp_pass'] = '';  // change with email smtp pass key
$config['smtp_crypto'] = 'tls';  // 'tls' or 'ssl'
$config['smtp_timeout'] = 30;

// Email Settings
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['wordwrap'] = TRUE;
$config['newline'] = "\r\n";
$config['crlf'] = "\r\n";

// Sender Information
$config['from_email'] = 'noreply@shophub.com';  // change with sender email
$config['from_name'] = 'ShopHub Store';

// Debug mode (set to FALSE in production)
$config['smtp_debug'] = 0;  // 0 = off, 1 = errors, 2 = messages, 3 = verbose
