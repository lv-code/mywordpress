<script>
    jQuery(document).ready(function(){
    jQuery('.rm_options').slideUp();    
    jQuery('.rm_section h3').click(function(){      
        if(jQuery(this).parent().next('.rm_options').css('display')=='none')
            {   jQuery(this).removeClass('inactive');
                jQuery(this).addClass('active');
                jQuery(this).children('.img').removeClass('inactive');
                jQuery(this).children('.img').addClass('active');               
            }
        else
            {   jQuery(this).removeClass('active');
                jQuery(this).addClass('inactive');      
                jQuery(this).children('.img').removeClass('active');            
                jQuery(this).children('.img').addClass('inactive');
            }           
        jQuery(this).parent().next('.rm_options').slideToggle('slow');  
    });
});
</script>
<!--这里是后台主题设置选项页面开始-->
<style>
.clear {
	clear:both;
	overflow:hidden;
	height:0px;
}
.opt_box {
	position: relative;
}
.opt_left {
	width:660px;
}
.opt_right {
	border: 1px solid #CCCCCC;
	border-radius: 5px 5px 5px 5px;
	display: block;
	line-height: 23px;
	list-style: square inside none;
	margin-right: -500px;
	padding: 10px;
	position: fixed;
	right: 50%;
	top: 15%;
	width: 250px;
}
.rm_wrap {
	width:660px;
}
.rm_section {
	border:1px solid #ddd;
	height:100%;
	background:#fff;
	-webkit-border-radius:5px;
	-moz-border-radius:5px;
	border-radius:5px;
	margin-top:10px;
}
.opt_box label {
	font-size:12px;
	width:130px;
	display:block;
	float:left;
}
.rm_input {
	padding:20px 10px
}
.rm_opts small {
	display:block;
	padding:4px;
	width:630px;
	font-size:12px;
	color:#666;
	line-height:20px;
}
.rm_opts input [ type = "text" ], .rm_opts select {
	width:280px;
	font-size:12px;
	padding:4px;
	color:#333;
	line-height:20px;
	background:#fff;
}
.rm_input input:focus, .rm_input textarea:focus {
	background:#f2f2f2;
}
#swt_rsssub, #swt_search_link, #swt_search_ID, #swt_link_s {
	border:1px solid #dadada;
	width:280px;
	padding:2px;
}
.rm_input textarea {
	width:400px;
	height:135px;
	font-size:12px;
	padding:4px;
	color:#333;
	line-height:20px;
	background:#fff;
}
.rm_title h3 {
	cursor:pointer;
	font-size:14px;
	text-transform:uppercase;
	margin:0;
	font-weight:bold;
	color:#232323;
	float:left;
	width:80%;
	padding:14px 4px;
}
.rm_title {
	cursor:pointer;
	border-bottom:1px solid #dadada;
	padding:0;
	height:50px;
}
.rm_title h3 .img {
	margin:0 5px;
	width:19px;
	height:19px;
	float:left;
}
.rm_title h3.inactive .inactive {
	background:url('<?php bloginfo('template_url');?>/collapse.png') no-repeat 0 2px;
}
.rm_title h3.active .active {
	background:url('<?php bloginfo('template_url');?>/collapse.png') no-repeat 0 -19px;
}
.rm_title span.submit {
	display:block;
	float:right;
	margin:0;
	padding:0;
	width:15%;
	padding:14px 0;
}
.clearfix {
	clear:both;
}
.rm_table th, .rm_table td {
	border:1px solid #bbb;
	padding:10px;
	text-align:center;
}
.rm_table th, .rm_table td.feature {
	border-color:#888;
}
.show_id {
	display:block;
	width:150px;
	margin-right:-500px;
	position:fixed;
	right:50%;
	top:15%;
	line-height:23px;
	padding:10px;
	list-style:square inside;
	border:1px solid #ccc;
	-webkit-border-radius:5px;
	-moz-border-radius:5px;
	border-radius:5px;
}
.show_id h4 {
	line-height:23px;
	margin:10px 0 0 0;
}
.si{
	width:300px;
}
.rmbox{
    padding:10px;
    border-bottom:2px dashed #ddd;
}
</style>
<div class="icon32" id="icon-themes"><br>
</div>
<h2><?php echo THEMENAME; ?> Options 主题设置</h2>
<p>当前使用主题: <?php echo THEMENAME.' '.VERSION; ?> | 设计者: <a href="http://www.waaqi.com/" target="_blank">WaaQi.com</a> | <a href="http://www.waaqi.com/" target="_blank">查看主题更新</a></p>

<div class="opt_box">
		<div class="opt_left">
		    <?php if($_REQUEST['saved']){ echo '<div class="updated fade" id="message" style="margin:10px 0px;"><p><strong>Problg主题设置已保存</strong></p></div>';}?>
				<form method="post">
						<div class="rm_section">
								<div class="rm_title">
										<h3 class="inactive">
												<div class="img inactive"></div>
                                            <?php _e('seo','pbotheme');?>
												网站SEO设置及流量统计												
										</h3>
										<span class="submit">
										       <input type="submit" value="保存设置" name="pbo_save">
										</span>
										<div class="clear"></div>
								</div>
								<div class="rm_options" style="display: block;">
										<div class="rm_input rm_textarea">
												<label for="swt_description">描述（Description）</label>
												<textarea rows="" cols="" type="textarea" name="pbo_description"><?php echo $options['pbo_description'];?></textarea>
												<div class="clear"></div>
										</div>
										<div class="rm_input rm_textarea">
												<label for="swt_keywords">关键词（KeyWords）</label>
												<textarea rows="" cols="" type="textarea" name="pbo_keywords"><?php echo $options['pbo_keywords'];?></textarea>
												<div class="clear"></div>
										</div>
										<div class="rm_input rm_textarea">
												<label for="swt_track_code">统计代码</label>
												<textarea rows="" cols="" type="textarea" name="pbo_trackcode"><?php echo $options['pbo_trackcode'];?></textarea>
												<div class="clear"></div>
										</div>
								</div>
						</div>
						<div class="rm_section">
                                <div class="rm_title">
                                        <h3 class="inactive">
                                                <div class="img inactive"></div>
                                               顶部栏目设置（RSS地址及滚动文章ID）                                           
                                        </h3>
                                        <span class="submit">
                                               <input type="submit" value="保存设置" name="pbo_save">
                                        </span>
                                        <div class="clear"></div>
                                </div>
                                <div class="rm_options" style="display: block;">
                                        <div class="rm_input rm_textarea">
                                                <label for="swt_isshowtop">是否显示顶部栏目</label>
                                                <select name='pbo_isshowtop' class="si">
                                                    <option value="1" <?php if($options['pbo_isshowtop']==1){echo 'selected="selected"';}?>>1 - Display</option>
                                                    <option value="0" <?php if($options['pbo_isshowtop']==0){echo 'selected="selected"';}?>>0 - None</option>
                                                </select>                                                
                                                <div class="clear"></div>
                                        </div>
                                        <div class="rm_input rm_textarea">
                                                <label for="swt_showtopid">要滚动显示的栏目</label>
                                                <select name='pbo_showtopid' class="si">
                                                    <?php show_id($options['pbo_showtopid']);?>
                                                </select>
                                                <div class="clear"></div>
                                        </div>
                                        <div class="rm_input rm_textarea">
                                                <label for="swt_maxshow">滚动显示的数量</label>
                                                <select name='pbo_maxshow' class="si">
                                                    <option value="1" <?php if($options['pbo_maxshow']==1){echo 'selected="selected"';}?>> 1 - 条</option>
                                                    <option value="5" <?php if($options['pbo_maxshow']==5){echo 'selected="selected"';}?>> 5 - 条</option>
                                                    <option value="10" <?php if($options['pbo_maxshow']==10){echo 'selected="selected"';}?>> 10 - 条</option>
                                                    <option value="20" <?php if($options['pbo_maxshow']==20){echo 'selected="selected"';}?>> 20 - 条</option>
                                                    <option value="50" <?php if($options['pbo_maxshow']==50){echo 'selected="selected"';}?>> 50 - 条</option>
                                                </select>                                                                                              
                                                <div class="clear"></div>
                                        </div>
                                        <div class="rm_input rm_textarea">
                                                <label for="swt_rssaddress">RSS地址</label>
                                               	<input type="text" name="pbo_rssaddress" class="si" value="<?php echo $options['pbo_rssaddress'];?>" />
                                                <div class="clear"></div>
                                        </div>
                                </div>
                        </div>
                        <div class="rm_section">
                                <div class="rm_title">
                                        <h3 class="inactive">
                                                <div class="img inactive"></div>
                                               分页显示设置                                           
                                        </h3>
                                        <span class="submit">
                                               <input type="submit" value="保存设置" name="pbo_save">
                                        </span>
                                        <div class="clear"></div>
                                </div>
                                <div class="rm_options" style="display: block;">
                                        <div class="rm_input rm_textarea">
                                                <label for="swt_topnavi">是否显示顶部分页</label>
                                                <select name='pbo_topnavi' class="si">
                                                    <option value="1" <?php if($options['pbo_topnavi']==1){echo 'selected="selected"';}?>>1 - Display</option>
                                                    <option value="0" <?php if($options['pbo_topnavi']==0){echo 'selected="selected"';}?>>0 - None</option>
                                                </select>                                                
                                                <div class="clear"></div>
                                        </div>
                                        <div class="rm_input rm_textarea">
                                                <label for="swt_footnavi">是否显示底部分页</label>
                                                <select name='pbo_footnavi' class="si">
                                                   <option value="1" <?php if($options['pbo_footnavi']==1){echo 'selected="selected"';}?>>1 - Display</option>
                                                   <option value="0" <?php if($options['pbo_footnavi']==0){echo 'selected="selected"';}?>>0 - None</option>
                                                </select>
                                                <div class="clear"></div>
                                        </div>
                                        <div class="rm_input rm_textarea">
                                                <label for="swt_toinner">是否将设置应用于内页</label>
                                                <select name='pbo_toinner' class="si">
                                                   <option value="1" <?php if($options['pbo_toinner']==1){echo 'selected="selected"';}?>>1 - YES</option>
                                                   <option value="0" <?php if($options['pbo_toinner']==0){echo 'selected="selected"';}?>>0 - NO</option>
                                                </select>
                                                <div class="clear"></div>
                                        </div>                                        
                                </div>
                        </div>
                        <div class="rm_section">
                                <div class="rm_title">
                                        <h3 class="inactive">
                                                <div class="img inactive"></div>
                                               广告设置                                           
                                        </h3>
                                        <span class="submit">
                                               <input type="submit" value="保存设置" name="pbo_save">
                                        </span>
                                        <div class="clear"></div>
                                </div>
                                <div class="rm_options" style="display: block;">
                                        <div class="rmbox">
                                                <h3>A1首页左侧广告</h3>
                                                <div class="rm_input rm_textarea">
                                                        <label for="swt_a1show">是否显示首页左侧广告</label>
                                                        <select name='pbo_a1show' class="si">
                                                            <option value="1" <?php if($options['pbo_a1show']==1){echo 'selected="selected"';}?>>1 - Display</option>
                                                            <option value="0" <?php if($options['pbo_a1show']==0){echo 'selected="selected"';}?>>0 - None</option>
                                                        </select>                                                
                                                        <div class="clear"></div>
                                                </div>
                                                <div class="rm_input rm_textarea">
                                                        <label for="swt_a1num">在第几条新闻之后显示</label>
                                                        <input type="text" name="pbo_a1num" value="<?php echo $options['pbo_a1num'];?>" />                                                        
                                                        <div class="clear"></div>
                                                </div>
                                                <div class="rm_input rm_textarea">
                                                        <label for="swt_a1code">广告代码</label>
                                                        <textarea rows="" cols="" type="textarea" name="pbo_a1code"><?php echo $options['pbo_a1code'];?></textarea>
                                                        <div class="clear"></div>
                                                </div>   
                                        </div>
                                        <div class="rmbox">
                                                <h3>A2列表页左侧广告</h3>
                                                <div class="rm_input rm_textarea">
                                                        <label for="swt_a2show">是否显示列表页左侧广告</label>
                                                        <select name='pbo_a2show' class="si">
                                                            <option value="1" <?php if($options['pbo_a2show']==1){echo 'selected="selected"';}?>>1 - Display</option>
                                                            <option value="0" <?php if($options['pbo_a2show']==0){echo 'selected="selected"';}?>>0 - None</option>
                                                        </select>                                                
                                                        <div class="clear"></div>
                                                </div>
                                                <div class="rm_input rm_textarea">
                                                        <label for="swt_a2num">在第几条新闻之后显示</label>
                                                        <input type="text" name="pbo_a2num" value="<?php echo $options['pbo_a2num'];?>" />                                                        
                                                        <div class="clear"></div>
                                                </div>
                                                <div class="rm_input rm_textarea">
                                                        <label for="swt_a2code">广告代码</label>
                                                        <textarea rows="" cols="" type="textarea" name="pbo_a2code"><?php echo $options['pbo_a2code'];?></textarea>
                                                        <div class="clear"></div>
                                                </div>   
                                        </div>
                                        <div class="rmbox">
                                                <h3>A3右侧sidebar广告</h3>
                                                <div class="rm_input rm_textarea">
                                                        <label for="swt_a3show">是否显示右侧广告</label>
                                                        <select name='pbo_a3show' class="si">
                                                            <option value="1" <?php if($options['pbo_a3show']==1){echo 'selected="selected"';}?>>1 - Display</option>
                                                            <option value="0" <?php if($options['pbo_a3show']==0){echo 'selected="selected"';}?>>0 - None</option>
                                                        </select>                                                
                                                        <div class="clear"></div>
                                                </div>                                                
                                                <div class="rm_input rm_textarea">
                                                        <label for="swt_a3code">广告代码</label>
                                                        <textarea rows="" cols="" type="textarea" name="pbo_a3code"><?php echo $options['pbo_a3code'];?></textarea>
                                                        <div class="clear"></div>
                                                </div>   
                                        </div>
                                        <div class="rmbox" style="border: 0;">
                                                <h3>A4文章内容下广告</h3>
                                                <div class="rm_input rm_textarea">
                                                        <label for="swt_a4show">是否显示文章下广告</label>
                                                        <select name='pbo_a4show' class="si">
                                                            <option value="1" <?php if($options['pbo_a4show']==1){echo 'selected="selected"';}?>>1 - Display</option>
                                                            <option value="0" <?php if($options['pbo_a4show']==0){echo 'selected="selected"';}?>>0 - None</option>
                                                        </select>                                                
                                                        <div class="clear"></div>
                                                </div>                                                
                                                <div class="rm_input rm_textarea">
                                                        <label for="swt_a4code">广告代码</label>
                                                        <textarea rows="" cols="" type="textarea" name="pbo_a4code"><?php echo $options['pbo_a4code'];?></textarea>
                                                        <div class="clear"></div>
                                                </div>   
                                        </div>
                                         <div class="rmbox" style="border: 0;">
                                                <h3>A5弹窗或其他展示广告</h3>
                                                <div class="rm_input rm_textarea">
                                                        <label for="swt_a5show">是否显示弹窗或其他展示广告</label>
                                                        <select name='pbo_a5show' class="si">
                                                            <option value="1" <?php if($options['pbo_a5show']==1){echo 'selected="selected"';}?>>1 - Display</option>
                                                            <option value="0" <?php if($options['pbo_a5show']==0){echo 'selected="selected"';}?>>0 - None</option>
                                                        </select>                                                
                                                        <div class="clear"></div>
                                                </div>                                                
                                                <div class="rm_input rm_textarea">
                                                        <label for="swt_a5code">广告代码</label>
                                                        <textarea rows="" cols="" type="textarea" name="pbo_a5code"><?php echo $options['pbo_a5code'];?></textarea>
                                                        <div class="clear"></div>
                                                </div>   
                                        </div>                                             
                                </div>
                        </div>
				</form>
		</div>
		<div class="opt_right">
				<p>主题：<?php echo THEMENAME.' '.VERSION; ?></p>
				<p>官方发布更新地址：<a href="http://www.waaqi.com" target="_blank">http//www.waaqi.com</a></p>
				<p>作者：WaaQi.com</p>				
		</div>
		<div class="clear"></div>
</div>
<?php 
function show_id($id=1) {
    global $wpdb;
    $request = "SELECT $wpdb->terms.term_id, name FROM $wpdb->terms ";
    $request .= " LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id ";
    $request .= " WHERE $wpdb->term_taxonomy.taxonomy = 'category' ";
    $request .= " ORDER BY term_id asc";
    $categorys = $wpdb->get_results($request);
    $output='';
    foreach ($categorys as $category) {
        if($id==$category->term_id){
            $output='<option value="'.$category->term_id.'" selected="selected">'.$category->term_id.' - '.$category->name.'</option>';
        }else{
            $output='<option value="'.$category->term_id.'">'.$category->term_id.' - '.$category->name.'</option>';
        }        
        echo $output;
    }
}
?>