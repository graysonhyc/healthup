<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Sydney
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
<?php  if (isset($_SESSION['user'])) {

     echo '<div align="right"><h6 style="color:blue">' . "Hello! " . $_SESSION['user'] . '</h6>' . 
         '<form method="post" action="http://localhost/wordpress/logout.php"><input type="submit"  value="Logout"></form></div>';
 }
 ?>

<div id="secondary" class="widget-area col-md-3" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div><!-- #secondary -->
