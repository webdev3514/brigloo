<?php 
require_once '../config/config.php';

include_once FL_CRON;
$cron = new cron();  
$cron->add_recurring_pickup();
$cron->change_order_pickup_mail();
                  
