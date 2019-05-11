<span class="button-secondary widefat title">
    <?php _e( 'Select Box', 'real-estate-manager' ); ?>
    <?php echo (isset($data['title'])) ? ' - '.stripcslashes($data['title']) : '' ; ?>
</span>
<div class="inside-contents">
    <table style="width: 100%;">
        <tr>
            <td><?php _e( 'Label', 'real-estate-manager' ); ?></td>
            <td>
                <input type="text" class="widefat label" value="<?php echo (isset($data['title'])) ? stripcslashes($data['title']) : '' ; ?>">
            </td>
        </tr>
        <tr>
            <td><?php _e( 'Data Name (lowercase without spaces)', 'real-estate-manager' ); ?></td>
            <td>
                <input type="text" class="widefat dataname" value="<?php echo (isset($data['key'])) ? $data['key'] : '' ; ?>">
            </td>
        </tr>
        <tr>
            <td><?php _e( 'Default Selected', 'real-estate-manager' ); ?></td>
            <td>
                <input type="text" class="widefat value" value="<?php echo (isset($data['default'])) ? stripcslashes($data['default']) : '' ; ?>">
            </td>
        </tr>
        <tr>
            <td><?php _e( 'Options (each per line)', 'real-estate-manager' ); ?></td>
            <td>
                <textarea class="widefat options"><?php
                    if (isset($data['options']) && $data['options'] != '') {
                        $option_values = explode("\n", $data['options']);
                        foreach ($option_values as $opt) {
                            echo stripcslashes($opt)."\n";
                        }
                    }
                ?></textarea>
            </td>
        </tr>
        <tr>
            <td><?php _e( 'Help Text', 'real-estate-manager' ); ?></td>
            <td>
                <textarea class="widefat help"><?php echo (isset($data['help'])) ? stripcslashes($data['help']) : '' ; ?></textarea>
            </td>
        </tr>
        <tr>
            <td><?php _e( 'Display on', 'real-estate-manager' ); ?></td>
            <td>
                <label>
                    <input type="checkbox" class="display-cb" value="register" <?php echo (isset($data['display']) && in_array('register', $data['display'])) ? 'checked' : '' ; ?>>
                    <?php _e( 'Registration Form', 'real-estate-manager' ); ?>
                </label>
                <label>
                    <input type="checkbox" class="display-cb" value="admin" <?php echo (isset($data['display']) && in_array('admin', $data['display'])) ? 'checked' : '' ; ?>>
                    <?php _e( 'Admin Profile Edit', 'real-estate-manager' ); ?>
                </label>
                <br>
                <label>
                    <input type="checkbox" class="display-cb" value="edit" <?php echo (isset($data['display']) && in_array('edit', $data['display'])) ? 'checked' : '' ; ?>>
                    <?php _e( 'Frontend Edit', 'real-estate-manager' ); ?>
                </label>
                <label>
                    <input type="checkbox" class="display-cb" value="card" <?php echo (isset($data['display']) && in_array('card', $data['display'])) ? 'checked' : '' ; ?>>
                    <?php _e( 'Agent Card Icons', 'real-estate-manager' ); ?>
                </label>
                <label>
                    <input type="checkbox" class="display-cb" value="content" <?php echo (isset($data['display']) && in_array('content', $data['display'])) ? 'checked' : '' ; ?>>
                    <?php _e( 'Agent Page', 'real-estate-manager' ); ?>
                </label>
            </td>
        </tr>
        <tr>
            <td><?php _e( 'Admin Settings Tab', 'real-estate-manager' ); ?></td>
            <td>
                <select class="widefat tab">
                    <?php
                        foreach ($tabs as $key => $value) {
                            $selected = (isset($data['tab']) && $data['tab'] == $key) ? 'selected' : '' ;
                            echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                        }
                    ?>
                </select>
            </td>
        </tr>
    </table>
    <br>
    <button class="button-secondary remove-field"><?php _e( 'Delete', 'real-estate-manager' ); ?></button>
    <p style="clear:both;"></p>
</div>