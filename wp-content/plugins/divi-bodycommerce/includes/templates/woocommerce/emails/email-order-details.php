<?php
/**
 * Order details table shown in emails.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

include(DE_DB_WOO_PATH . '/titan-framework/titan-framework-embedder.php');
$titan = TitanFramework::getInstance( 'divi-bodyshop-woo' );

// CHECK IF CUSTOM TEMPLTE
$get_enable_email_template = $titan->getOption( 'enable_email_template' );

$get_BodyCommerce_enable_image = $titan->getOption( 'BodyCommerce_enable_image' );
$get_BodyCommerce_enable_image_size = $titan->getOption( 'BodyCommerce_enable_image_size' );
$get_BodyCommerce_customer_sku = $titan->getOption( 'BodyCommerce_customer_sku' );

$get_BodyCommerce_content_before_table = $titan->getOption( 'BodyCommerce_content_before_table' );//DONE
$get_BodyCommerce_content_after_table = $titan->getOption( 'BodyCommerce_content_after_table' );//DONE

$text_align = is_rtl() ? 'right' : 'left';

do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>

<h2>
	<?php
	if ( $sent_to_admin ) {
		$before = '<a class="link" href="' . esc_url( $order->get_edit_order_url() ) . '">';
		$after  = '</a>';
	} else {
		$before = '';
		$after  = '';
	}
	/* translators: %s: Order ID. */
	echo wp_kses_post( $before . sprintf( __( '[Order #%s]', 'woocommerce' ) . $after . ' (<time datetime="%s">%s</time>)', $order->get_order_number(), $order->get_date_created()->format( 'c' ), wc_format_datetime( $order->get_date_created() ) ) );
	?>
</h2>

<div style="margin-bottom: 40px;">

<div style="padding-top:20px;padding-bottom:20px;">
<?php
if ($get_BodyCommerce_content_before_table != ""){
echo $get_BodyCommerce_content_before_table;
}
 ?>
</div>

<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="1">
	<thead>
		<tr>
			<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
			<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
			<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
			<?php

			if ($get_BodyCommerce_enable_image == "yes") {
			$bc_show_image = true;
			}
			else {
			$bc_show_image = false;
			}

			if ($get_BodyCommerce_customer_sku == "yes") {
				$customer_sku = true;
			}
			else {
				$customer_sku = $sent_to_admin;
			}


if ($get_enable_email_template == 1) {

			echo wc_get_email_order_items( $order, array( // WPCS: XSS ok.
				'show_sku'      => $customer_sku,
				'show_image'    => $bc_show_image,
				'image_size'    => array( $get_BodyCommerce_enable_image_size, $get_BodyCommerce_enable_image_size ),
				'plain_text'    => $plain_text,
				'sent_to_admin' => $sent_to_admin,
			) );

}
else {
	echo wc_get_email_order_items( $order, array( // WPCS: XSS ok.
		'show_sku'      => $sent_to_admin,
		'show_image'    => false,
		'image_size'    => array( 32, 32 ),
		'plain_text'    => $plain_text,
		'sent_to_admin' => $sent_to_admin,
	) );
}

			?>
		</tbody>
		<tfoot>
			<?php
			$item_totals = $order->get_order_item_totals();

			if ( $item_totals ) {
				$i = 0;
				foreach ( $item_totals as $total ) {
					$i++;
					?>
					<tr>
						<th class="td" scope="row" colspan="2" style="text-align:<?php echo esc_attr( $text_align ); ?>; <?php echo ( 1 === $i ) ? 'border-top-width: 4px;' : ''; ?>"><?php echo wp_kses_post( $total['label'] ); ?></th>
						<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>; <?php echo ( 1 === $i ) ? 'border-top-width: 4px;' : ''; ?>"><?php echo wp_kses_post( $total['value'] ); ?></td>
					</tr>
					<?php
				}
			}
			if ( $order->get_customer_note() ) {
				?>
				<tr>
					<th class="td" scope="row" colspan="2" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Note:', 'woocommerce' ); ?></th>
					<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php echo wp_kses_post( nl2br( wptexturize( $order->get_customer_note() ) ) ); ?></td>
				</tr>
				<?php
			}
			?>
		</tfoot>
	</table>

	<div style="padding-top:20px;padding-bottom:20px;">
	<?php
  if ($get_BodyCommerce_content_after_table != ""){
  echo $get_BodyCommerce_content_after_table;
  }
   ?>
 </div>

</div>

<?php do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>
