<!-- Accordeon -->
<div class="row">
<div class="marg20">
    <div class="ac-container">
        <div>
            <input id="ac-4" name="accordion-2" type="radio" checked/>
            <label for="ac-4"><?php echo lang_check('LOCATION');?></label>
            <article class="ac-small">
                <p>{estate_data_address}</p>
            </article>
        </div>
        <div>
            <input id="ac-6" name="accordion-2" type="radio" />
            <label for="ac-6">{options_name_21}</label>
            <article class="ac-small">
                <ul class="widget-content amenities clearfix">
                    <?php if(isset($category_options_21))foreach($category_options_21 as $val): ?>
                        <?php if($val['is_checkbox']):?>
                        <li>
                            <i class="<?php if(isset($val['option_value'])):?>fa fa-check<?php else:?> unchecked<?php endif;?>"></i><?php echo $val['option_name'];?><?php echo $val['icon'];?>
                        </li>
                        <?php endif;?>
                    <?php endforeach; ?>
                </ul>
            </article>
        </div>
        <div>
            <input id="ac-7" name="accordion-2" type="radio" />
            <label for="ac-7">{options_name_52}</label>
            <article class="ac-small">
                <ul class="widget-content amenities clearfix">
                    <?php if(isset($category_options_52))foreach($category_options_52 as $val): ?>
                        <?php if($val['is_checkbox']):?>
                        <li>
                            <i class="<?php if(isset($val['option_value'])):?>fa fa-check<?php else:?> unchecked<?php endif;?>"></i><?php echo $val['option_name'];?><?php echo $val['icon'];?>
                        </li>
                        <?php endif;?>
                    <?php endforeach; ?>
                </ul>
            </article>
        </div>
        <div>
            <input id="ac-8" name="accordion-2" type="radio" />
            <label for="ac-8">{options_name_43}</label>
            <article class="ac-small">
                <ul class="widget-content amenities clearfix">
                    {category_options_43}
                    {is_text}
                    <li>
                        {icon} {option_name}:&nbsp;&nbsp;{option_prefix}{option_value}{option_suffix}
                    </li>
                    {/is_text}
                    {/category_options_43}
                </ul>
            </article>
        </div>
        <div>
            <input id="ac-9" name="accordion-2" type="radio" />
            <label for="ac-9">{options_name_59}</label>
            <article class="ac-small ac-1">
                <?php if(file_exists(FCPATH.'templates/'.$settings_template.'/assets/js/dpejes/dpe.js')): ?>
                    <?php if(!empty($options_name_59) || !empty($options_name_60)): ?>
                      <!--energy version full -->
                      <div class="clearfix">
                      <?php

                        $values_chars = array(  'A'=>'40',
                                                'B'=>'80',
                                                'C'=>'140',
                                                'D'=>'220',
                                                'E'=>'320',
                                                'F'=>'440',
                                                'G'=>'460');

                        if(isset($estate_data_option_59) && !is_numeric($estate_data_option_59))
                        {
                            if(isset($values_chars[$estate_data_option_59]))
                                $estate_data_option_59 = $values_chars[$estate_data_option_59];
                        }

                        $values_chars = array(  'A'=>'4',
                                                'B'=>'9',
                                                'C'=>'19',
                                                'D'=>'34',
                                                'E'=>'54',
                                                'F'=>'79',
                                                'G'=>'81');

                        if(isset($estate_data_option_60) && !is_numeric($estate_data_option_60))
                        {
                            if(isset($values_chars[$estate_data_option_60]))
                                $estate_data_option_60 = $values_chars[$estate_data_option_60];
                        }
                      ?>
                        <div title="energie:<?php echo get_numeric_val($estate_data_option_59); ?>" style="float:left;width:280;margin-right:50px;" class='energy-eff-box'>
                          <div class="alert alert-warning"><?php _l('No Efficiency');?> </div>
                          <br/>
                          <br/>
                        </div>

                        <div title="ges:<?php echo get_numeric_val($estate_data_option_60); ?>" style="float:left;" class='energy-eff-box'>
                          <div class="alert alert-warning"> <?php _l('No Gas');?> </div>
                        </div>

                      </div>

                      <!--energy --> 
                    <?php endif; ?>
                        <script type="text/javascript">
                        /* start implпїЅment dpe-->   */
                            var IMG_FOLDER = "assets/js/dpejes";
                            dpe.show_numbers = true;
                            dpe.energy_title1 = "Energy efficient";
                                dpe.energy_title2 = "80 kWh EP ";
                                dpe.energy_title3 = "";
                            dpe.gg_title2 = "30 kg CO2 ";
                                dpe.gg_title1 = "Gas emission";

                            if(!dpe.show_numbers)
                            {
                                dpe.energy_title2 = "";
                                dpe.gg_title2 = "";
                            }

                                /* adjusts the height of the large thumbnails (the width is automatically adjusted proportionally)
                                 * possible values: de 180 a 312 
                                 */
                                dpe.canvas_height = 210;
                                /*not to display the unit gas emissions greenhouse in the right column: */
                                dpe.gg_unit = '';
                                /*  adjusts the height of the small thumbnails
                                 * possible values: 35
                                 */
                                dpe.sticker_height = 35;
                                /* can change the attribute of div tags that indicates it is a tag */
                                dpe.tag_attribute = 'attributdpe';
                                dpe.tag_attribute = 'title';
                                /* Launches replacing the contents of the div right by good vignettes */
                                dpe.all();
                        /* end implement dpe-->   */
                        </script>
                        <style type="text/css">
                            .energy-eff-box > div {
                                height: 212px !important;
                            }
                        </style>
                <?php endif; ?>

            </article>
        </div>
        <div>
            <input id="ac-10" name="accordion-2" type="radio" />
            <label for="ac-10"><?php echo lang_check('Walkscore');?></label>
            <article class="ac-small ac-2">
                <?php if(config_db_item('walkscore_enabled') == TRUE && !empty($estate_data_address) && !empty($estate_data_gps)): ?>
                <div class="widget">
                    <div class="widget-content2">
                    <script type='text/javascript'>
                    var ws_wsid = '';
                    <?php
                    if(!empty($estate_data_gps))
                    {
                        $GPS_DATA = explode(',', $estate_data_gps);

                        if(count($GPS_DATA) == 2)
                        {
                            echo "var ws_lat = '".trim($GPS_DATA[0])."';\n";
                            echo "var ws_lon = '".trim($GPS_DATA[1])."';\n";
                        }
                    }
                    else
                    {
                        echo "var ws_address = '$estate_data_address';";
                    }
                    ?>
                    var ws_width = '500';
                    var ws_height = '336';
                    var ws_layout = 'horizontal';
                    var ws_commute = 'true';
                    var ws_transit_score = 'true';
                    var ws_map_modules = 'all';
                    </script><style type='text/css'>#ws-walkscore-tile{position:relative;text-align:left}#ws-walkscore-tile *{float:none;}#ws-footer a,#ws-footer a:link{font:11px/14px Verdana,Arial,Helvetica,sans-serif;margin-right:6px;white-space:nowrap;padding:0;color:#000;font-weight:bold;text-decoration:none}#ws-footer a:hover{color:#777;text-decoration:none}#ws-footer a:active{color:#b14900}</style><div id='ws-walkscore-tile'><div id='ws-footer' style='position:absolute;top:318px;left:8px;width:488px'><form id='ws-form'><a id='ws-a' href='http://www.walkscore.com/' target='_blank'>What's Your Walk Score?</a><input type='text' id='ws-street' style='position:absolute;top:0px;left:170px;width:286px' /><input type='image' id='ws-go' src='http://cdn2.walk.sc/2/images/tile/go-button.gif' height='15' width='22' border='0' alt='get my Walk Score' style='position:absolute;top:0px;right:0px' /></form></div></div><script type='text/javascript' src='http://www.walkscore.com/tile/show-walkscore-tile.php'></script>
                    </div>
                </div>
                <?php endif; ?>
            </article>
        </div>
    </div>
</div>
</div>