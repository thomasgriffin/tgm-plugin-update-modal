/* ==========================================================
 * modal.js
 * http://thomasgriffin.io/
 * ==========================================================
 * Copyright 2014 Thomas Griffin.
 *
 * Licensed under the GPL License, Version 2.0 or later (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */
jQuery(document).ready(function($){
    // Listen to when the click event is triggered and force a specific class on the body.
    $(document).on('click.tgmPluginUpdateModal', '.tgm-plugin-update-modal', function(e){
        if ( ! $(this).hasClass('thickbox') ) {
            // Prevent the default action from occurring.
            e.preventDefault();

            // We need to add the update-core-php class to force styling for the modal if necessary.
            if ( typeof adminpage != 'undefined' && 'update-core-php' != adminpage ) {
                $('body').addClass('update-core-php');
            }

            // Because WP remove all events tied to an element with the thickbox class, we need to add it now and then trigger a click.
            $(this).addClass('thickbox').click();
        }

        // Register our handler late so that we can attach to the close event for the overlay.
        $('#TB_window').on('tb_unload', function(){
            // We need to remove the update-core-php class if necessary.
            if ( typeof adminpage != 'undefined' && 'update-core-php' != adminpage ) {
                $('body').removeClass('update-core-php');
            }

            // Remove the thickbox class from our link so that we can re-register our click event handler.
            $('.tgm-plugin-update-modal').removeClass('thickbox');
        });
    });
});