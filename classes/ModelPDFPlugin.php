<?php

/**
 * Plugin that hooks up specified URL's to render PDF's
 * 
 * @copyright	2015 Pez Cuckow
 * @author pezcuckow
 */
class ModelPDFPlugin
{
	const PageID = 'model_pdf_plugin_id';
	
		public static function activate($networkWide)
		{
			self::init(); // ensure the routes are bound
			
				if ($networkWide && is_multisite()) {
						$sites = wp_get_sites(array(
								'limit' => false
						));
						
						foreach ($sites as $site) {
								switch_to_blog($site['blog_id']);
								self::singleActivate();
								restore_current_blog();
						}
				} else {
						self::singleActivate();
				}
		}
		
		public static function init()
		{
			add_filter('query_vars', function($vars) {
					$vars[] = "model_id";
					$vars[] = "pdf_style";
					return $vars;
			});
					 
			add_filter('rewrite_rules_array', function($rules) {
				$pageID = get_option(self::PageID);
				
				$existingPage = get_post($pageID);
				
					$newRule = array(
						'models/([^/]+)/pdf/?$' => 'index.php?pagename='.$existingPage->post_name.'&model_id=$matches[1]',
						'models/([^/]+)/pdf/([^/]+)/?$' => 'index.php?pagename='.$existingPage->post_name.'&model_id=$matches[1]&pdf_style=$matches[2]'
					);
					
					return $newRule + $rules;
			});
			
			
				global $wp_rewrite;
				$wp_rewrite->flush_rules( false ); // REMOVE ME
		}

		protected static function singleActivate()
		{
			$pageTitle = 'Print to PDF';
			$existingPage = get_page_by_title($pageTitle);
			
			$pageID = 0;
			if (!$existingPage) {
					// Create page array
					$_p = array();
					$_p['post_title'] = $pageTitle;
					$_p['post_content'] = "Generate PDF's.";
					$_p['post_status'] = 'publish';
					$_p['post_type'] = 'page';
					$_p['comment_status'] = 'closed';
					$_p['ping_status'] = 'closed';
					$_p['post_category'] = array(1); // the default
			
					// Insert the page into the database
					$pageID = wp_insert_post($_p);
					
			} else {
				// Plugin may be trashed
				if($existingPage->post_status != 'publish') {
					$existingPage->post_status = 'publish';
					$pageID = wp_update_post( $existingPage );
				}
		add_filter('page_template', function($pageTemplate) {
			$pageID = get_option(self::PageID);
			if($pageID && is_page($pageID)) {
				$page_template = dirname( __FILE__ ) . '/../views/renderPDF.php';
			}

			return $page_template;
		});
			}
			
			delete_option(self::PageID);
			add_option(self::PageID, $pageID);
				
				flush_rewrite_rules();
		}
		

		public static function deactivate()
		{		 
				$pageID = get_option(self::PageID);
				if($pageID) {
						wp_delete_post($pageID); // trash the page
				}
				 
				delete_option(self::PageID);
				 
				flush_rewrite_rules();
		}
		
		public static function includeRequirements()
		{
			if(!file_exists(MPDF_BASE . '/vendor/autoload.php')) {
				return new WP_Error( 'broken', __( "You must run composer before using this plugin", "model_pdf" ) );
			}
			
			require_once (MPDF_BASE . '/vendor/autoload.php');
			
			require_once (MPDF_BASE . '/classes/ModelPDF.php');
			require_once (MPDF_BASE . '/classes/MaverickPDF.php');
			require_once (MPDF_BASE . '/classes/GridLayout.php');
			require_once (MPDF_BASE . '/classes/SplitGrid.php');
			
			return true;
		}
}

?>