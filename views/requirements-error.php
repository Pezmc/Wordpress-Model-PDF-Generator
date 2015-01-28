<div class="error">
	<p><?php echo MPDF_NAME; ?> error: Your environment doesn't meet all of the system requirements listed below.</p>

	<ul class="ul-disc">
		<li>
			<strong>PHP <?php echo MPDF_REQUIRED_PHP_VERSION; ?>+</strong>
			<em>(You're running version <?php echo PHP_VERSION; ?>)</em>
		</li>

		<li>
			<strong>WordPress <?php echo MPDF_REQUIRED_WP_VERSION; ?>+</strong>
			<em>(You're running version <?php echo esc_html( $wp_version ); ?>)</em>
		</li>
	</ul>
</div>
