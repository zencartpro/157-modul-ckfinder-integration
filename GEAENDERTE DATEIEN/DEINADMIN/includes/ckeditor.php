<?php
/**
 * Zen Cart German Specific
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2010 Kuroi Web Design
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: ckeditor.php for CKFinder 2022-02-14 20:59:32Z webchills $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
// prepare list of languages supported by this website, so we can tell CKEditor
$var = zen_get_languages();
$jsLanguageLookupArray = "var lang = new Array;\n";
foreach ($var as $key)
{
  $jsLanguageLookupArray .= "  lang[" . $key['id'] . "] = '" . $key['code'] . "';\n";
}
?>
<script>window.jQuery || document.write('<script src="https://code.jquery.com/jquery-2.1.3.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4" crossorigin="anonymous"><\/script>');</script>
<script>window.jQuery || document.write('<script src="includes/javascript/ckfinder-jquery.js"><\/script>');</script>
<script type="text/javascript" src="../<?php echo DIR_WS_EDITORS; ?>ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="../<?php echo DIR_WS_EDITORS ?>ckfinder/ckfinder.js"></script>

<script type="text/javascript">
$(document).ready(function() {
  <?php echo $jsLanguageLookupArray ?>
  $('textarea').each(function() {
    if ($(this).attr('class') == 'editorHook' || ($(this).attr('name') != 'message' && $(this).attr('class') != 'noEditor'))
    {
      index = $(this).attr('name').match(/\d+/);
      if (index == null) index = <?php echo $_SESSION['languages_id'] ?>;
      var editor = CKEDITOR.replace($(this).attr('name'),
        {
          coreStyles_underline : { element : 'u' },
          width : 760,
          language: lang[index]
        });
      if (CKFinder != undefined) {
        CKFinder.setupCKEditor( editor, { language: lang[index] }, { type: 'Files' } );
      }
    }
  });
});
</script>

<?php 
// for pseudo auth, use list of admin-approved IP addresses from the Maintenance list:
file_put_contents('../' . DIR_WS_EDITORS . '.allowed_ips.txt', EXCLUDE_ADMIN_IP_FOR_MAINTENANCE);
// Other options:
// - Edit your /editors/ckeditor/config.js file to control the toolbar buttons, add additional plugins, control the UI color, etc
//
// Advanced:
// https://ckeditor.com/docs/ckeditor4/latest/features/styles.html#the-stylesheet-parser-plugin
// - set custom styles in the /editors/ckeditor/styles.js file
// - import a template-specific stylesheet from catalog-side, using config.contentsCss setting, so dialogs "look like catalog-side" in admin editor
