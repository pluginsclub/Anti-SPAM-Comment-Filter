<?php
/**
 * Plugin Name:       Anti-SPAM Comment Filter
 * Plugin URI:        https://plugins.club/wordpress/anti-spam-comment-filter/
 * Description:       Filters out SPAM comments and prevents them from being posted on the site.
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            plugins.club
 * Author URI:        https://plugins.club/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// Create the admin menu item and page
function anti_spam_admin_menu() {
  add_options_page('Anti-SPAM Comment Filter', 'Comment Filter', 'manage_options', 'anti-spam-comment-filter', 'anti_spam_options_page');
}
add_action('admin_menu', 'anti_spam_admin_menu');

// Display the admin page
function anti_spam_options_page() {
  ?>
  <div class="wrap">
    <h1>Anti-SPAM Comment Filter</h1>
    <form method="post" action="options.php">
      <?php settings_fields('anti_spam_options_group'); ?>
      <table class="form-table">
        <tr valign="top">
          <th scope="row">Spam Keywords</th>
          <td>
            <input type="text" name="anti_spam_keywords" value="<?php echo get_option('anti_spam_keywords'); ?>" style="width: 80%;" />
            <p class="description">Enter a list of spam keywords separated by commas. If a comment contains any of these keywords, it will be flagged as spam and prevented from being posted.</p>
          </td>
        </tr>
      </table>
      <?php submit_button(); ?>
    </form>
  </div>
  <?php
}

// Register the plugin settings
function anti_spam_register_settings() {
  register_setting('anti_spam_options_group', 'anti_spam_keywords');
}
add_action('admin_init', 'anti_spam_register_settings');

// Check comments for spam keywords
function anti_spam_check($commentdata) {
  // Get the list of spam keywords
  $spam_keywords = explode(",", get_option('anti_spam_keywords'));
  $spam_keywords = array_map('trim', $spam_keywords);
  // Check if the comment contains any of the spam keywords
  foreach($spam_keywords as $keyword) {
    if(stripos($commentdata['comment_content'], $keyword) !== false) {
      // If a spam keyword is found, return an error message
      wp_die("Sorry, your comment contains spam keywords and cannot be posted.");
    }
  }
  // If no spam keywords are found, return the comment data as usual
  return $commentdata;
}
add_filter('preprocess_comment', 'anti_spam_check');
