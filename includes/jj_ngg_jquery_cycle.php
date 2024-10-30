<?php

class JJ_NGG_JQuery_Cycle extends WP_Widget
{
  
  function JJ_NGG_JQuery_Cycle()
  {
    $widget_ops = array('classname' => 'jj-nexgen-jquery_cycle', 'description' => "Allows you to pick a gallery from the 'NextGen Gallery' plugin to use with 'JQuery Cycle Lite'");
    $this->WP_Widget('jj-nexgen-jquery_cycle', 'JJ NextGEN JQuery Cycle', $widget_ops);
  }
  
  function widget($args, $instance)
  {
    global $wpdb;
    extract($args);

    // Set params
    $title = apply_filters('widget_title', $instance['title']);
    $html_id = $this->get_val($instance, 'html_id', 'cycle_lite');
    $order = $this->get_val($instance, 'order', 'asc', false);
    $shuffle = $this->get_val($instance, 'shuffle');
    $limit = $this->get_val_numeric($instance, 'max_pictures');
    $gallery = $this->get_val_numeric($instance, 'gallery');
    $width = $this->get_val_numeric($instance, 'width');
    $height = $this->get_val_numeric($instance, 'height'); 
    $center = $this->get_val($instance, 'center');
    $shortcode = $this->get_val($instance, 'shortcode');  
    
    // Set cycle lite params
    $timeout = $this->get_val_numeric($instance, 'timeout');
    $speed = $this->get_val_numeric($instance, 'speed');
    $sync = $this->get_val_numeric($instance, 'sync');
    $fit = $this->get_val_numeric($instance, 'fit');
    $pause = $this->get_val_numeric($instance, 'pause');
    $delay = $this->get_val_numeric($instance, 'delay');   

    // SQL defaults
    $sql_order = '';
    $sql_where = ' WHERE exclude = 0';
    $sql_limit = '';
    
    // Set SQL order
    if($order == 'random')
    {
      $sql_order = 'RAND()';
    }
    elseif($order == 'asc') 
    {
       $sql_order = 'galleryid ASC';
    }        
    elseif($order == 'desc') 
    {
      $sql_order = 'galleryid DESC';
    }
    elseif($order == 'sortorder')
    {
      $sql_order = 'sortorder ASC';
    }
    else
    {
      $sql_order = 'galleryid ASC';
    }

    if($gallery != '')
    {
      $sql_where .= ' AND galleryid = ' . $gallery;
    }
    
    // Set limit defaults
    if(is_numeric($limit)) 
    {
      $sql_limit = ' LIMIT 0, ' . $limit;
    }        

    $results = $wpdb->get_results("SELECT * FROM $wpdb->nggpictures" . $sql_where . " ORDER BY " . $sql_order . $sql_limit);
    $p_size = 0;
    if(is_array($results))
    {
       $p_size = count($results);
    }
    
    $output = '';                
    if($p_size > 0) 
    {         
      if($title != '')
      {      
        if($shortcode != '1')
        {      
          $output .= "\n" . $before_title . $title . $after_title;
        }
        else
        {
          $output .= "\n<h3>" . $title . "</h3>";
        }
      }
                      
      $style_outer = '';
      $style_inner = '';
      if($center == '1' && $width != '')
      {
        $style_outer = "text-align:center;";
        $style_inner = "text-align:left;margin-right:auto;margin-left:auto;";
      }               
      if($width != '')
      {
        $style_inner .= "width:" . $width . "px;";
      } 
      if($height != '')
      {
        $style_outer .= "height:" . $height . "px;overflow:hidden;";
        $style_inner .= "height:" . $height . "px;overflow:hidden;";        
      }
      if($style_outer != '')
      {
        $style_outer = " style=\"" . $style_outer . "\"";
      }
      if($style_inner != '')
      {
        $style_inner = " style=\"" . $style_inner . "\"";
      }      
      $output .= "\n<div id=\"" . $html_id . "_container\" class=\"cycle_lite_container\"" . $style_outer . ">";      
      $output .= "\n  <div id=\"" . $html_id . "\"" . $style_inner . ">";
      $image_alt = null;
      $image_description = null;
      foreach($results as $result) 
      {
        $gallery = $wpdb->get_row("SELECT * FROM $wpdb->nggallery WHERE gid = '" . $result->galleryid . "'");
        foreach($gallery as $key => $value) 
        {
            $result->$key = $value;
        }        
        $image = new nggImage($result);    
        $image_alt = trim($image->alttext);   
        $image_description = trim($image->description);                   
                
        // check that alt is url with a simple validation
        $use_url = false;        
        if($image_alt != '' && (substr($image_alt, 0, 1) == '/' || substr($image_alt, 0, 4) == 'http' || substr($image_alt, 0, 3) == 'ftp'))
        {
          $use_url = true;
        }
        // if alt isn't a url make it the alt text to backwards support nextgen galleries
        elseif($image_alt != '') 
        {
          $image_description = $image_alt;
        }
                
        if($use_url != '')
        {
          $output .= "<a href=\"" . esc_attr($image_alt) . "\">";
        }
        
        if($image_description != '')
        {
          $image_description = "alt=\"" . esc_attr($image_description) . "\" ";
        }
        else
        {
          $image_description = '';
        }
                  
        $width_d = '';
        $height_d = '';
        if($width != '' && $height != '')
        {        
          $width_d = " width=\"" . $width . "\"";
          $height_d = " height=\"" . $height . "\"";  
        }     
        $output .= "<img src=\"" . $image->imageURL . "\" " . $image_description . $width_d . $height_d . " border=\"0\" />";
        
        if($use_url != '')
        {
          $output .= "</a>";
        }                
      }
      $output .= "\n  </div>";
      $output .= "\n</div>";
    }    
    
    // Cycle Lite arguments
    $javascript_args = array();
    
    if($timeout != "") { $javascript_args[] = "timeout: " . $timeout; }
    if($speed != "") { $javascript_args[] = "speed: " . $speed; }
    if($height != "") { $javascript_args[] = "height: " . $height; }
    if($sync != "") { $javascript_args[] = "sync: " . $sync; }
    if($fit != "") { $javascript_args[] = "fit: " . $fit; }
    if($pause != "") { $javascript_args[] = "pause: " . $pause; }
    if($delay != "") { $javascript_args[] = "delay: " . $delay; }
    
    // Add javascript
    $output .= "\n<script type=\"text/javascript\">";
    // Shuffle results on random order so even if page is cached the order will be different each time
    if($order == 'random' && $shuffle == 'true')
    {
      $output .= "\n  jQuery('div#" . $html_id . "').jj_ngg_shuffle();";
    }
    $output .= "\n  jQuery('div#" . $html_id . "').jjcycle(";
    if(count($javascript_args) > 0)
    {
      $output .= "{" . implode(",", $javascript_args) . "}";
    }
    $output .= ");";        
    $output .= "\n</script>\n";
 
    if($shortcode != '1')
    {      
      echo $before_widget . "\n<ul class=\"ul_jj_cycle\" style=\"list-style-type:none;margin:0;padding:0;\">\n    <li class=\"li_jj_cycle\" style=\"margin:0;padding:0;\">" . $output . "\n    </li>\n  </ul>\n" . $after_widget;
    }
    else
    {
      echo $output;
    }
  }

  function get_val($instance, $key, $default = '', $escape = true)
  {
    $val = '';
    if(isset($instance[$key]))
    {
      $val = trim($instance[$key]);
    }
    if($val == '')
    {
      $val = $default;
    }
    if($escape)
    {
      $val = esc_attr($val);
    }
    return $val;
  }
  
  function get_val_numeric($instance, $key, $default = '')
  {
    $val = $this->get_val($instance, $key, $default, false);
    if($val != '' && !is_numeric($val))
    {
      $val = '';
    }
    return $val;
  }

  function form($instance)
  {
    global $wpdb;
    $instance = wp_parse_args((array) $instance, array(
      'title' => '',
      'gallery' => '',
      'html_id' => 'cycle_lite',
      'order' => 'random',
      'shuffle' => 'false',
      'max_pictures' => '',
      'width' => '200',
      'height' => '200',
      'center' => '',      
      
      // cycle lite settings
      'timeout' => '',
      'speed' => '',
      'sync' => '',
      'fit' => '',
      'pause' => '',
      'delay' => ''
    ));
    $order_values = array('random' => 'Random', 'asc' => 'Latest First', 'desc' => 'Oldest First', 'sortorder' => 'NextGen Sortorder');
    $galleries = $wpdb->get_results("SELECT * FROM $wpdb->nggallery ORDER BY name ASC");
?>
  <p>
    <label for="<?php echo $this->get_field_id('title'); ?>"><strong>Widget title:</strong></label><br />
    <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>"  class="widefat" />
  </p>
  <p>
    <label><strong>Select a gallery to use:</strong></label><br />
    <?php if(is_array($galleries) && count($galleries) > 0) { ?>
      <select id="<?php echo $this->get_field_id('gallery'); ?>" name="<?php echo $this->get_field_name('gallery'); ?>" class="widefat">
        <option value="">All images</option>
        <?php 
          $gallery_selected = '';        
          foreach($galleries as $gallery)
          {       
            if($gallery->gid == $instance['gallery'])
            {
              $gallery_selected = " selected=\"selected\"";
            }
            else
            {
              $gallery_selected = "";
            }
            echo "<option value=\"" . $gallery->gid . "\"" . $gallery_selected . ">" . $gallery->name . "</option>";
        } ?>
      </select>
    <?php }else{ ?>
      No galleries found
    <?php } ?>
  </p>  
  <p>
    <label for="<?php echo $this->get_field_id('order'); ?>"><strong>Order:</strong></label><br />
    <select id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>" class="widefat">
      <?php 
        $order_selected = '';        
        foreach($order_values as $key => $value) 
        {       
          if($key == $instance['order'])
          {
            $order_selected = " selected=\"selected\"";
          }
          else
          {
            $order_selected = "";
          }
          echo "<option value=\"" . $key . "\"" . $order_selected . ">" . $value . "</option>";
      } ?>
    </select>
  </p>
  <p>
    <label><strong>Shuffle:</strong> <small>(Only for random order)</small></label><br />
    <input type="radio" id="<?php echo $this->get_field_id('shuffle'); ?>_true" name="<?php echo $this->get_field_name('shuffle'); ?>" value="true" style="vertical-align: middle;"<?php if($instance['shuffle'] == 'true') { echo " checked=\"checked\""; } ?> /><label for="<?php echo $this->get_field_id('shuffle'); ?>_true" style="vertical-align: middle;">true</label>
    <input type="radio" id="<?php echo $this->get_field_id('shuffle'); ?>_false" name="<?php echo $this->get_field_name('shuffle'); ?>" value="false" style="vertical-align: middle;"<?php if($instance['shuffle'] == 'false') { echo " checked=\"checked\""; } ?> /><label for="<?php echo $this->get_field_id('shuffle'); ?>_false" style="vertical-align: middle;">false</label>          
  </p>   
  <p>
    <label for="<?php echo $this->get_field_id('max_pictures'); ?>"><strong>Max pictures:</strong> (Leave blank for all)</label><br />
    <input type="text" id="<?php echo $this->get_field_id('max_pictures'); ?>" name="<?php echo $this->get_field_name('max_pictures'); ?>" value="<?php echo $instance['max_pictures']; ?>" size="3" />
  </p>
  <p>
    <label for="<?php echo $this->get_field_id('html_id'); ?>"><strong>HTML id:</strong></label><br />
    <input type="text" id="<?php echo $this->get_field_id('html_id'); ?>" name="<?php echo $this->get_field_name('html_id'); ?>" value="<?php echo $instance['html_id']; ?>" class="widefat" />
  </p>  
  <p>
    <label for="<?php echo $this->get_field_id('width'); ?>"><strong>Image width:</strong></label><br />
    <input type="text" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo $instance['width']; ?>" size="3" />
  </p>
  <p>
    <label for="<?php echo $this->get_field_id('height'); ?>"><strong>Image height:</strong></label><br />
    <input type="text" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" value="<?php echo $instance['height']; ?>" size="3" />
  </p>    
  <p>
    <input type="checkbox" id="<?php echo $this->get_field_id('center'); ?>" style="vertical-align: middle;" name="<?php echo $this->get_field_name('center'); ?>" value="1"<?php if($instance['center'] == '1') { echo " checked=\"checked\""; } ?> />
    <label for="<?php echo $this->get_field_id('center'); ?>" style="vertical-align: middle;"><strong>Center content</strong></label><br />
  </p>  
  <div class="javascript_settings" style="display: none; border: 1px solid #cccccc; background-color: #f0f0f0;">
    <div style="padding: 10px;">
      <p><a href="http://jquery.malsup.com/cycle/lite/" target="jj_nextgen_jquery">Visit Cycle Lite configuration page</a></p>
      <p>Leave blank to use defaults.</p> 
      <p>
        <label for="<?php echo $this->get_field_id('timeout'); ?>"><strong>timeout:</strong></label>
        <input type="text" id="<?php echo $this->get_field_id('timeout'); ?>" name="<?php echo $this->get_field_name('timeout'); ?>" value="<?php echo $instance['timeout']; ?>" size="3" />
      </p>
      <p>
        <label for="<?php echo $this->get_field_id('speed'); ?>"><strong>speed:</strong></label>
        <input type="text" id="<?php echo $this->get_field_id('speed'); ?>" name="<?php echo $this->get_field_name('speed'); ?>" value="<?php echo $instance['speed']; ?>" size="3" />
      </p>
      <p>
        <label><strong>sync:</strong></label>
        <input type="radio" id="<?php echo $this->get_field_id('sync'); ?>_default" name="<?php echo $this->get_field_name('sync'); ?>" value="" style="vertical-align: middle;"<?php if($instance['sync'] == '') { echo " checked=\"checked\""; } ?> /><label for="<?php echo $this->get_field_id('sync'); ?>_default" style="vertical-align: middle;">default</label>
        <input type="radio" id="<?php echo $this->get_field_id('sync'); ?>_1" name="<?php echo $this->get_field_name('sync'); ?>" value="1" style="vertical-align: middle;"<?php if($instance['sync'] == '1') { echo " checked=\"checked\""; } ?> /><label for="<?php echo $this->get_field_id('sync'); ?>_1" style="vertical-align: middle;">true</label>
        <input type="radio" id="<?php echo $this->get_field_id('sync'); ?>_0" name="<?php echo $this->get_field_name('sync'); ?>" value="0" style="vertical-align: middle;"<?php if($instance['sync'] == '0') { echo " checked=\"checked\""; } ?> /><label for="<?php echo $this->get_field_id('sync'); ?>_0" style="vertical-align: middle;">false</label>          
      </p>
      <p>
        <label><strong>fit:</strong></label>
        <input type="radio" id="<?php echo $this->get_field_id('fit'); ?>_default" name="<?php echo $this->get_field_name('fit'); ?>" value="" style="vertical-align: middle;"<?php if($instance['fit'] == '') { echo " checked=\"checked\""; } ?> /><label for="<?php echo $this->get_field_id('fit'); ?>_default" style="vertical-align: middle;">default</label>
        <input type="radio" id="<?php echo $this->get_field_id('fit'); ?>_1" name="<?php echo $this->get_field_name('fit'); ?>" value="1" style="vertical-align: middle;"<?php if($instance['fit'] == '1') { echo " checked=\"checked\""; } ?> /><label for="<?php echo $this->get_field_id('fit'); ?>_1" style="vertical-align: middle;">true</label>
        <input type="radio" id="<?php echo $this->get_field_id('fit'); ?>_0" name="<?php echo $this->get_field_name('fit'); ?>" value="0" style="vertical-align: middle;"<?php if($instance['fit'] == '0') { echo " checked=\"checked\""; } ?> /><label for="<?php echo $this->get_field_id('fit'); ?>_0" style="vertical-align: middle;">false</label>          
      </p>
      <p>
        <label><strong>pause:</strong></label>
        <input type="radio" id="<?php echo $this->get_field_id('pause'); ?>_default" name="<?php echo $this->get_field_name('pause'); ?>" value="" style="vertical-align: middle;"<?php if($instance['pause'] == '') { echo " checked=\"checked\""; } ?> /><label for="<?php echo $this->get_field_id('pause'); ?>_default" style="vertical-align: middle;">default</label>
        <input type="radio" id="<?php echo $this->get_field_id('pause'); ?>_1" name="<?php echo $this->get_field_name('pause'); ?>" value="1" style="vertical-align: middle;"<?php if($instance['pause'] == '1') { echo " checked=\"checked\""; } ?> /><label for="<?php echo $this->get_field_id('pause'); ?>_1" style="vertical-align: middle;">true</label>
        <input type="radio" id="<?php echo $this->get_field_id('pause'); ?>_0" name="<?php echo $this->get_field_name('pause'); ?>" value="0" style="vertical-align: middle;"<?php if($instance['pause'] == '0') { echo " checked=\"checked\""; } ?> /><label for="<?php echo $this->get_field_id('pause'); ?>_0" style="vertical-align: middle;">false</label>          
      </p>
      <p>
        <label for="<?php echo $this->get_field_id('delay'); ?>"><strong>delay:</strong></label>
        <input type="text" id="<?php echo $this->get_field_id('delay'); ?>" name="<?php echo $this->get_field_name('delay'); ?>" value="<?php echo $instance['delay']; ?>" size="3" />
      </p>                                                                                                                                                                           
    </div>
  </div>  
  <p><a href="#" onclick="jQuery(this).parent().prev('div.javascript_settings').toggle();return false;">Cycle Lite Settings</a></p>     
<?php
  }

  function update($new_instance, $old_instance)
  {
    $new_instance['title'] = esc_attr($new_instance['title']);
    return $new_instance;
  }
}