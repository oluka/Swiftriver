<?php
/**
 * Main view page.
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     Admin Dashboard Controller
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General
 * Public License (LGPL)
 */
 
require_once APPPATH.'libraries/Arc90/Service/Twitter.php';

 
?>

				<!-- main body -->
				<div id="main" class="clearingfix">
					<div id="mainmiddle" class="floatbox withright">
				
						<!-- right column -->
						<div id="right" class="clearingfix">
					
							<!-- category filters -->
							<div class="cat-filters clearingfix">
								<strong><?php echo Kohana::lang('ui_main.category_filter');?></strong>
							</div>
						
							<ul class="category-filters">
								
								<li><a  <?php	if ($selected_category == 0 )echo" class='active' " ; ?>  id="cat_0" href="/main/index/category/0/page/1"><div class="swatch" style="background-color:#<?php echo $default_map_all;?>"></div><div class="category-title">All Categories</div></a></li>
								<?php
									foreach ($categories as $category => $category_info)
									{
										$setactive = $selected_category == $category? " class='active' " :"" ;
										$category_title = $category_info[0];
										$category_color = $category_info[1];
										echo '<li><a '.$setactive.' href="/main/index/category/'.$category.'/page/1/" id="cat_'. $category .'"><div class="swatch" style="background-color:#'.$category_color.'"></div><div class="category-title">'.$category_title.'</div></a></li>';
										// Get Children
										echo '<div class="hide" id="child_'. $category .'">';
										foreach ($category_info[2] as $child => $child_info)
										{
											$child_title = $child_info[0];
											$child_color = $child_info[1];
											echo '<li style="padding-left:20px;"><a href="#" id="cat_'. $child .'"><div class="swatch" style="background-color:#'.$child_color.'"></div><div class="category-title">'.$child_title.'</div></a></li>';
										}
										echo '</div>';
									}
								?>
							</ul>
							<!-- / category filters -->
							
							<?php
							if ($layers)
							{
								?>
								<!-- Layers (KML/KMZ) -->
								<div class="cat-filters clearingfix" style="margin-top:20px;">
									<strong><?php echo Kohana::lang('ui_main.layers_filter');?></strong>
								</div>
								<ul class="category-filters">
									<?php
									foreach ($layers as $layer => $layer_info)
									{
										$layer_name = $layer_info[0];
										$layer_color = $layer_info[1];
										$layer_url = $layer_info[2];
										$layer_file = $layer_info[3];
										$layer_link = (!$layer_url) ?
											url::base().'media/uploads/'.$layer_file :
											$layer_url;
										echo '<li><a href="#" id="layer_'. $layer .'"
										onclick="switchLayer(\''.$layer.'\',\''.$layer_link.'\',\''.$layer_color.'\'); return false;"><div class="swatch" style="background-color:#'.$layer_color.'"></div>
										<div>'.$layer_name.'</div></a></li>';
									}
									?>
								</ul>
								<!-- /Layers -->
								<?php
							}
							?>
							
							
							<br />
						
							<!-- additional content -->
							<div class="additional-content">
								<h5><?php echo Kohana::lang('ui_main.how_to_report'); ?></h5>
								<ol>
									<?php if (!empty($phone_array)) 
									{ ?><li>By sending a message to <?php foreach ($phone_array as $phone) {
										echo "<strong>". $phone ."</strong>";
										if ($phone != end($phone_array)) {
											echo " or ";
										}
									} ?></li><?php } ?>
									<?php if (!empty($report_email)) 
									{ ?><li>By sending an email to <a href="mailto:<?php echo $report_email?>"><?php echo $report_email?></a></li><?php } ?>
									<?php if (!empty($twitter_hashtag_array)) 
												{ ?><li>By sending a tweet with the hashtag/s <?php foreach ($twitter_hashtag_array as $twitter_hashtag) {
									echo "<strong>". $twitter_hashtag ."</strong>";
									if ($twitter_hashtag != end($twitter_hashtag_array)) {
										echo " or ";
									}
									} ?></li><?php } ?>
									<li>By <a href="<?php echo url::base() . 'reports/submit/'; ?>">filling a form</a> at the website</li>
								</ol>					
		
							</div>
							<!-- / additional content -->
					
						</div>
						<!-- / right column -->
					
						<!-- content column -->
						<div id="content" class="clearingfix">
							<div class="floatbox">
							
								<!-- filters -->
								<div class="filters clearingfix">
								<div style="float:left; width: 65%">
									<strong><?php echo Kohana::lang('ui_main.filters'); ?></strong>
									<ul>
										<li><a id="media_0" class="active" href="#"><span><?php echo Kohana::lang('ui_main.reports'); ?></span></a></li>
										<li><a id="media_4" href="#"><span><?php echo Kohana::lang('ui_main.news'); ?></span></a></li>
										<li><a id="media_1" href="#"><span><?php echo Kohana::lang('ui_main.pictures'); ?></span></a></li>
										<li><a id="media_2" href="#"><span><?php echo Kohana::lang('ui_main.video'); ?></span></a></li>
										<li><a id="media_0" href="#"><span><?php echo Kohana::lang('ui_main.all'); ?></span></a></li>
									</ul>
</div>
								<div style="float:right; width: 31%">
									<strong><?php echo Kohana::lang('ui_main.views'); ?></strong>
									<ul>
										<li><a id="view_0" <?php if($map_enabled === 'streetmap') { echo 'class="active" '; } ?>href="#"><span><?php echo Kohana::lang('ui_main.clusters'); ?></span></a></li>
										<li><a id="view_1" <?php if($map_enabled === '3dmap') { echo 'class="active" '; } ?>href="#"><span><?php echo Kohana::lang('ui_main.time'); ?></span></a></li>
</div>
								</div>
								<!-- / filters -->
								<div>
									<table class="table-list">
										<!--<thead>
											<tr>
												<th scope="col"><?php echo Kohana::lang('ui_main.title'); ?></th>
												<th scope="col"><?php echo Kohana::lang('ui_main.source'); ?></th>
												<th scope="col"><?php echo Kohana::lang('ui_main.date'); ?></th>
											</tr>
										</thead> -->
										<tbody>
											<?php
										/*	

											$username = 'kavumaivan';
											$password = 'Evelyn1';
											
											$twitter  = new Arc90_Service_Twitter($username, $password);
											$params = array();
										try   
										{  
										echo "<tr><td colspan=2> Twiters go here <br/>	"; 	
											$response =  $twitter->getFriendsTimeline('xml');
											//$response  = $twitter->getMessages('json', $params);

											// If Twitter returned an error (401, 503, etc), print status code   
												echo	$response->getData();

												if($response->isError())   
												{   
													echo $response->http_code . "\n";   
												}   
										}   
										catch(Arc90_Service_Twitter_Exception $e)   
										{   
												// Print the exception message (invalid parameter, etc)   
												print $e->getMessage();   
										}  
											
											
											echo "</td></tr>";
											*/
															
											foreach ($feeds as $feed)
											{
												$feed_id = $feed->id;
												$feed_title = text::limit_chars($feed->item_title, 40, '...', True);
												$feed_link = $feed->item_link;
												$feed_date = date('M j Y h:m', strtotime($feed->item_date));
												//$feed_source = text::limit_chars($feed->feed->item_name, 15, "...");
											?>
											<tr>
												<td><div style="padding:5px;width:35px;height:45px;border:1px solid #660033;Text-align:center; -moz-border-radius: 5px; -webkit-border-radius: 5px;">
												  <a href="<?php echo $feed_link; ?>" target="_blank">
														<img src="<?php echo url::base(); ?>/media/img/rssdark.png" alt="<?php echo $feed_title ?>" align="absmiddle" style="border:0" />
													</a><br/> <span style="font-weight:bold;color:#660033">100%</span>
													 </div>
												</td>
												<td style="border-bottom:2px solid #AAAAAA;"> <?php echo $feed->item_description ;?>  ...
															<br/>
													Delivered on: <?php echo $feed->item_date ; /*$testDate;*/ ?>&nbsp;&nbsp;&nbsp;  Source:<?php echo $feed->item_source; ?>   <br>
																										
													 <form id="formtag<?php echo $feed_id ;?>" name="formtag<?php echo $feed_id ;?>"  method="POST" action="/main/tagging/feed/<?php echo $feed_id ; ?>" >
													 <a href="javascript:submitform('formtag<?php echo $feed_id ;?>')" >
													 <img src="<?php echo url::base(); ?>/media/img/Tagbtn.png" alt="<?php echo $feed_title ?>" align="absmiddle" style="border:0" />
													 </a>
													 <input type=text id="tag_<?php echo $feed_id; ?>"  name="tag_<?php echo $feed_id; ?>" value="" />&nbsp;&nbsp;<?php echo $feed->tags; ?>
													 <div style="float:right">
													 <img src="<?php echo url::base(); ?>/media/img/page_icon.jpg" alt="<?php echo $feed_title ?>" align="absmiddle" style="border:0" />
													 <img src="<?php echo url::base(); ?>/media/img/swift_page_icon.jpg" alt="<?php echo $feed_title ?>" align="absmiddle" style="border:0" />
													 <img src="<?php echo url::base(); ?>/media/img/no_entry_icon.jpg" alt="<?php echo $feed_title ?>" align="absmiddle" style="border:0" />
													 <img src="<?php echo url::base(); ?>/media/img/qtnmark.jpg" alt="<?php echo $feed_title ?>" align="absmiddle" style="border:0" />
													 </div>
													 
													 </form>
													</td>
											</tr>
											<?php
											}
											?>
										</tbody>
									</table>
									<div style="align:bottom;">
									<?php echo $pagination; ?>
									</div>
									<!--<a class="more" href="<?php echo url::base() . 'feeds' ?>">View More...</a> -->
							</div>
								<!-- map -->
								<!--
								<?php
									// My apologies for the inline CSS. Seems a little wonky when styles added to stylesheet, not sure why.
									?>
								<div class="<?php echo $map_container; ?>" id="<?php echo $map_container; ?>" <?php if($map_container === 'map3d') { echo 'style="width:573px; height:573px;"'; } ?>></div> 
								<?php if($map_container === 'map') { ?>
								<div class="slider-holder">
									<form action="">
										<fieldset>
											<div class="play"><a href="#" id="playTimeline">PLAY</a></div>
											<label for="startDate">From:</label>
											<select name="startDate" id="startDate"><?php echo $startDate; ?></select>
											<label for="endDate">To:</label>
											<select name="endDate" id="endDate"><?php echo $endDate; ?></select>
										</fieldset>
									</form>
								</div>
								<?php } ?> -->
								<!-- / map -->
								<div id="graph" class="graph-holder"></div>
							</div>
						</div>
						<!-- / content column -->
				
					</div>
				</div>
				<!-- / main body -->
			
				<!-- content -->
				<div class="content-container">
			
					<!-- content blocks -->
					<div class="content-blocks clearingfix">
				
						<!-- left content block -->
						<div class="content-block-left">
							<h5><?php echo Kohana::lang('ui_main.incidents_listed'); ?></h5>
							<table class="table-list">
								<thead>
								<!--	<tr>
										<th scope="col" class="title"><?php echo Kohana::lang('ui_main.title'); ?></th>
										<th scope="col" class="location"><?php echo Kohana::lang('ui_main.location'); ?></th>
										<th scope="col" class="date"><?php echo Kohana::lang('ui_main.date'); ?></th>
									</tr> -->
								</thead>
								<tbody>
									<?php
	 								if ($feedcounts == 0)
									{
									?>
									<tr><td colspan="3">No Reports In The System</td></tr>

									<?php
									}
									foreach ($feedsummary as $feedsum)
									{
											?>
									<tr>
										<td><a href="<?php echo $feedsum->feed_url; ?>"> <?php echo $feedsum->feed_name; ?></a></td>
										<td><?php echo $feedsum->total;  ?></td>
									</tr>
									<?php
									}
									?>
								</tbody>
							</table>
							</div>
						<!-- / left content block -->
				
						<!-- right content block -->
						<div class="content-block-right">
						
						</div>
						<!-- / right content block -->
				
					</div>
					<!-- /content blocks -->
<?php
/*
 *					<!-- site footer -->
 *					<div class="site-footer">
 *
 *						<h5>Site Footer</h5>
 *						Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Mauris porta. Sed eget nisi. Fusce rhoncus lorem ac erat. Maecenas turpis tellus, volutpat quis, sodales et, consectetuer ac, est. Nullam sed est sed augue vestibulum condimentum. In tellus. Integer luctus odio eu arcu. Pellentesque imperdiet felis eu tortor. Morbi ante dui, iaculis id, vulputate sit amet, venenatis in, turpis. Fusce in risus.
 *
 *					</div>
 *					<!-- / site footer -->
*/
?>
			
				</div>
				<!-- content -->
		
			</div>
		</div>
		<!-- / main body -->

	</div>
	<!-- / wrapper -->