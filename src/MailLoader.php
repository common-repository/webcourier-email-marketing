<?php

class MailLoader {

    public function showPages() {
        // Hook for adding admin menus
        add_action('admin_menu', 'webcourier_mail_pages');

        // action function for above hook
        function webcourier_mail_pages() {

            // Add a new top-level menu (ill-advised):
            add_menu_page('Mail Marketing', 'Mail Marketing', 'manage_options', 'top-level-handle', 'toplevel_page');

            // Add a submenu to the custom top-level menu:
            
            add_submenu_page('top-level-handle', 'Campanhas', 'Campanhas', 'manage_options', 'sub-page-campanhas', 'mt_sublevel_campanhas');
            
            add_submenu_page('top-level-handle', 'Templates', 'Templates', 'manage_options', 'sub-page-templates', 'mt_sublevel_templates');
            
//            add_submenu_page('mt-top-level-handle', 'Sobre', 'Sobre', 'manage_options', 'sub-page-sobre', 'mt_sublevel_sobre');
        }

        // toplevel_page() displays the page content for the custom WebCourier menu
        function toplevel_page() {
            do_shortcode('[webcourier_page_geral_webcourier_mail]');
        }
        // mt_sublevel_page() displays the page content for the first submenu
        // of the custom WebCourier menu
        
        function mt_sublevel_templates(){
            do_shortcode('[webcourier_page_templates]');
        }
        
        function mt_sublevel_campanhas(){
            do_shortcode('[webcourier_page_campanhas]');
        }

    }

    public function doShortCodes() {

        add_shortcode('webcourier_page_geral_webcourier_mail', 'webcourier_get_page_geral_webcourier_mail');

        function webcourier_get_page_geral_webcourier_mail() {
            include(WEBCOURIER_PLUGIN_MAIL_DIR . '/views/geral_webcourier_mail.php');
        }
        
        add_shortcode('webcourier_page_templates', 'webcourier_get_page_templates');
        
        function webcourier_get_page_templates(){
            include(WEBCOURIER_PLUGIN_MAIL_DIR . '/views/templates.php');
        }
        
        add_shortcode('webcourier_page_campanhas', 'webcourier_get_page_campanhas');
        
        function webcourier_get_page_campanhas(){
            include(WEBCOURIER_PLUGIN_MAIL_DIR . '/views/campanhas.php');
        }
    }

    public function loadIcon() {

        function replace_admin_menu_icons_css_mails_marketing() {
          ?>  
            <style>
                #adminmenu #toplevel_page_mt-top-level-handle div.wp-menu-image::before {
                    content: '\f465';
                }
            </style>
            <?php

        }

        add_action('admin_head', 'replace_admin_menu_icons_css_mails_marketing');

        /**
         * Register style sheet.
         */
        function register_webcourier_styles_marketing() {
            wp_register_style('webcourier', plugins_url('webcourier/css/styles_mail_marketing.css'));
            wp_enqueue_style('webcourier');
        }

    }
    
}

