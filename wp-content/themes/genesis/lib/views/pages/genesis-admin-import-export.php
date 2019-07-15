<?php
/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package StudioPress\Genesis
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://my.studiopress.com/themes/genesis/
 */

?>
<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<table class="form-table">
		<tbody>

			<tr>
				<th scope="row"><strong><?php esc_html_e( 'Import Genesis Settings File', 'genesis' ); ?></strong></th>
				<td>
					<p>
					<?php
					/* translators: JOSN file extension. */
					printf( esc_html__( 'Upload the data file (%s) from your computer and we\'ll import your settings.', 'genesis' ), genesis_code( '.json' ) );
					?>
					</p>
					<p><?php esc_html_e( 'Choose the file from your computer and click "Upload file and Import"', 'genesis' ); ?></p>

						<form enctype="multipart/form-data" method="post" action="<?php echo esc_url( menu_page_url( 'genesis-import-export', 0 ) ); ?>">
							<?php wp_nonce_field( 'genesis-import', 'genesis-import-nonce' ); ?>
							<input type="hidden" name="genesis-import" value="1" />
							<label for="genesis-import-upload">
								<?php
								// translators: Maximum size import files can have.
								printf( esc_html__( 'Upload File (Maximum Size: %s): ', 'genesis' ), esc_html( ini_get( 'post_max_size' ) ) );
								?>
							</label>
							<input type="file" id="genesis-import-upload" name="genesis-import-upload" />
							<?php
							submit_button( __( 'Upload File and Import', 'genesis' ), 'primary', 'upload' );
							?>
						</form>

				</td>
			</tr>

			<tr>
				<th scope="row"><strong><?php esc_html_e( 'Export Genesis Settings File', 'genesis' ); ?></strong></th>
				<td>
					<p>
					<?php
					/* translators: JOSN file extension. */
					printf( esc_html__( 'When you click the button below, Genesis will generate a data file (%s) for you to save to your computer.', 'genesis' ), genesis_code( '.json' ) );
					?>
					</p>
					<p><?php esc_html_e( 'Once you have saved the download file, you can use the import function on another site to import this data.', 'genesis' ); ?></p>

						<form method="post" action="<?php echo esc_url( menu_page_url( 'genesis-import-export', 0 ) ); ?>">
							<?php
							wp_nonce_field( 'genesis-export', 'genesis-export-nonce' );
							$this->export_checkboxes();
							if ( $this->get_export_options() ) {
								submit_button( __( 'Download Export File', 'genesis' ), 'primary', 'download' );
							}
							?>
						</form>

				</td>
			</tr>

			<?php
			/**
			 * Fires on the import export admin page, before the closing tbody tag.
			 *
			 * @since 1.6.0
			 */
			do_action( 'genesis_import_export_form' );
			?>

		</tbody>
	</table>

</div>
