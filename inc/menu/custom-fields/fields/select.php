<span class="button-secondary widefat title">
    <b><?php echo (isset($data['title'])) ? stripcslashes($data['title']).' - ' : '' ; ?></b>
    <?php echo $field_label; ?>
</span>
<div class="inside-contents">
    <table style="width: 100%;">
        <tr>
            <td><?php _e( 'Label', 'real-estate-manager' ); ?></td>
            <td  colspan="2">
                <input type="text" class="widefat label" value="<?php echo (isset($data['title'])) ? stripcslashes($data['title']) : '' ; ?>">
                <input type="hidden" class="editable" value="<?php echo (isset($data['editable']) && $data['editable'] == false) ? 'false' : 'true' ; ?>">
            </td>
        </tr>
        <tr>
            <td><?php _e( 'Data Name (lowercase without spaces)', 'real-estate-manager' ); ?></td>
            <td  colspan="2">
                <input type="text" class="widefat dataname" value="<?php echo (isset($data['key'])) ? $data['key'] : '' ; ?>" <?php echo (isset($data['editable']) && $data['editable'] == false) ? 'disabled' : '' ; ?>>
            </td>
        </tr>
        <tr>
            <td><?php _e( 'Default Selected', 'real-estate-manager' ); ?></td>
            <td  colspan="2">
                <input type="text" class="widefat value" value="<?php echo (isset($data['default'])) ? stripcslashes($data['default']) : '' ; ?>">
            </td>
        </tr>
        <tr>
            <td><?php _e( 'Options (each per line)', 'real-estate-manager' ); ?></td>
            <td  colspan="2">
                <textarea class="widefat options"><?php
                if ( isset($data['options']) ) {
                    if (is_array($data['options'])) {
                        $options = implode("\n", $data['options']);
                        echo stripcslashes($options);
                    } else {
                        echo stripcslashes($data['options']);
                    }
                }
                ?></textarea>
            </td>
        </tr>
        <tr>
            <td><?php _e( 'Help Text', 'real-estate-manager' ); ?></td>
            <td  colspan="2">
                <textarea class="widefat help"><?php echo (isset($data['help'])) ? stripcslashes($data['help']) : '' ; ?></textarea>
            </td>
        </tr>
        <tr>
            <td><?php _e( 'Admin Settings Tab', 'real-estate-manager' ); ?></td>
            <td  colspan="2">
                <select class="widefat tab">
                    <?php
                        $tabs = rem_get_single_property_settings_tabs();
                        foreach ($tabs as $key => $value) {
                            $selected = (isset($data['tab']) && $data['tab'] == $key) ? 'selected' : '' ;
                            echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                        }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><?php _e( 'Accessibility', 'real-estate-manager' ); ?></td>
            <td  colspan="2">
                <select class="widefat accessibility">
                    <option value="public" <?php echo (isset($data['accessibility']) && $data['accessibility'] == 'public') ? 'selected' : '' ; ?>>Public</option>
                    <option value="agent" <?php echo (isset($data['accessibility']) && $data['accessibility'] == 'agent') ? 'selected' : '' ; ?>>Agent</option>
                    <option value="admin" <?php echo (isset($data['accessibility']) && $data['accessibility'] == 'admin') ? 'selected' : '' ; ?>>Admin</option>
                    <option value="disable" <?php echo (isset($data['accessibility']) && $data['accessibility'] == 'disable') ? 'selected' : '' ; ?>>Disable</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><?php _e( 'Required', 'real-estate-manager' ); ?></td>
            <td>
                <label>
                    <input type="checkbox" class="require" <?php echo (isset($data['required']) && $data['required'] == 'true') ? 'checked' : '' ; ?>> <?php _e( 'Enable', 'real-estate-manager' ); ?>
                </label>
            </td>
        </tr>
        <?php 
        $data = isset($data) ? $data : '';
        do_action('rem_after_text_field_admin', $data ); ?>      
    </table>
    <br>
    <button class="button-secondary remove-field" <?php echo (isset($data['editable']) && $data['editable'] == false) ? 'disabled' : '' ; ?>>
        <?php _e( 'Delete', 'real-estate-manager' ); ?>
    </button>
    <p style="clear:both;"></p>
</div>