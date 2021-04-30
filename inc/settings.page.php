<?php $settings = post_color_settings(); ?>

<div class="wrap">
	<h2><?php _e( 'Post Color Settings', 'post-color' ); ?></h2>

	<form id="post-color-settings-form" method="post" action="options.php">
		<?php settings_fields( 'post-color' ); ?>

		<table class="form-table">
			<tbody>

			<tr valign="top">
				<th scope="row">
					<?php _e( 'Post Types', 'post-color' ) ?>
				</th>
				<td>
                    <ul>
	                    <?php $post_types = post_color_available_post_types();
                        foreach ( $post_types as $post_type ) : ?>
                            <li>
                                <label>
                                    <input type="checkbox" value="<?php echo $post_type->name; ?>" name="post-color[post-types][]"
                                        <?php checked( true, array_diff( array_column( $post_types, 'name' ), $settings['post-types'] ) && in_array( $post_type->name, $settings['post-types'] ) ); ?> />
	                                <?php echo $post_type->label; ?>
                                </label>
                            </li>
	                    <?php endforeach; ?>
                    </ul>
                    <p class="description">
                        <?php _e( 'Select the posts types where the editor should have the possibility to set the post color.<br />You can also leave all checkboxes unchecked to enable it for all.', 'post-color' ) ?>
                    </p>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php _e( 'Background Colors', 'post-color' ); ?>
				</th>
				<td>
                    <?php foreach ( $settings['background'] as $color ) {
                        post_color_picker_input( 'background', $color );
	                    echo ' ';
                    } ?>
                    <div class="wp-picker-container add-post-color" data-scope="background" title="<?php _e( 'Add color', 'post-color' ); ?>">
                        <button type="button" class="button wp-color-result" aria-expanded="false">
                            <span class="wp-color-result-text"><?php _e( 'Add color', 'post-color' ); ?></span>
                        </button>
                    </div>

                    <p class="description"><?php _e( '<i>Empty</i> the color to erase it. Any changes here has no effect on the colors already selected in posts/pages.', 'post-color' ); ?></p>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php _e( 'Text Colors', 'post-color' ); ?>
				</th>
				<td>
					<?php foreach ( $settings['text'] as $color ) {
						post_color_picker_input( 'text', $color );
						echo ' ';
					} ?>
                    <div class="wp-picker-container add-post-color" data-scope="text" title="<?php _e( 'Add color', 'post-color' ); ?>">
                        <button type="button" class="button wp-color-result" aria-expanded="false">
                            <span class="wp-color-result-text"><?php _e( 'Add color', 'post-color' ); ?></span>
                        </button>
                    </div>

                    <p class="description"><?php _e( '<i>Empty</i> the color to erase it. Any changes here has no effect on the colors already selected in posts/pages.', 'post-color' ); ?></p>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php _e( 'Custom Colors' ); ?>
				</th>
				<td>
                    <input type="checkbox" value="1" name="post-color[custom]"<?php checked( '1', $settings['custom'] ); ?> />
                    <?php _e( 'The editor can choose individual colors.', 'post-color' ); ?>
				</td>
			</tr>

			<tr valign="top">
				<th scope="row">
					<?php _e( 'Block colors', 'post-color' ); ?>
				</th>
				<td>
                    <input type="checkbox" value="1" name="post-color[block]"<?php checked( '1', $settings['block'] ); ?> />
                    <?php _e( "Apply these settings also to the editor's block colors.", 'post-color' ); ?>
				</td>
			</tr>

			</tbody>
		</table>

		<?php submit_button(); ?>

	</form>
</div>