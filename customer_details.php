<?php  session_start();
  require_once('functions/function.php');
  $oIslogged->check();
  $oPageContent->get_header();
  $oPageContent->get_content('customer/customer_details');
  $oPageContent->get_footer();
 ?>
