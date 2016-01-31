<?php
/**
 * @package Ajaxy
 */
/*
	Plugin Name: Ajaxy Search Keyword Analyzer & Tracker
	Plugin URI: http://ajaxy.org
	Description: Track the search keywords that are used at the live search to view your blog content.
	Version: 1.0.0
	Author: Ajaxy Team
	Author URI: http://www.ajaxy.org
	License: 
*/



define('AJAXY_SFK_VERSION', '1.0.0');
define('AJAXY_SFK_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

if(!class_exists ( 'AjaxyTracker' )) {
	class AjaxyTracker {
		private $noimage = '';
		
		private $table = 'ajaxy_tracker';
		
		function __construct(){
			register_activation_hook( __FILE__, array( $this, 'install' ) );
			$this->actions();
			$this->filters();
		}
		function install() {
			global $wpdb;

			$table_name = $wpdb->prefix . $this->table; 
			$sql = "CREATE TABLE $table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				total mediumint(9) NOT NULL DEFAULT 0,
				keyword varchar(250) NOT NULL,
				details text NULL,
				UNIQUE KEY id (id)
			);";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
		function actions(){
			//ACTIONS
			
			add_action( 'admin_enqueue_scripts', array(&$this, "enqueue_scripts"));
			add_action( "admin_menu",array(&$this, "menu_pages"));
			add_action( 'wp_head', array(&$this, 'head'));
			add_action( 'admin_head', array(&$this, 'head'));
			add_action( 'wp_footer', array(&$this, 'footer'));
			add_action( 'admin_footer', array(&$this, 'footer'));
			add_action( 'admin_notices', array(&$this, 'admin_notice') );
			$settings = $this->get_settings();
			if(intval($settings->track_live_search) == 1){
				add_action( 'sf_value_results', array(&$this, 'track_live_search'), 10, 2);
			}
		}
		function filters(){
			//FILTERS
			$settings = $this->get_settings();
			if(intval($settings->track_search) == 1){
				add_filter('posts_results', array(&$this, 'track_search'), 10, 2);
			}
		}
		function overview(){
			echo apply_filters('ajaxy-overview', 'main');
		}
		function menu_pages(){
			if(!$this->menu_page_exists('ajaxy-page')){
				add_menu_page( _n( 'Ajaxy', 'Ajaxy', 1, 'ajaxy' ), _n( 'Ajaxy', 'Ajaxy', 1 ), 'Ajaxy', 'ajaxy-page', array(&$this, 'overview'));
			}
			add_submenu_page( 'ajaxy-page', __('Search Tracker'), __('Search Tracker'), 'manage_options', 'ajaxy_sft_admin', array(&$this, 'admin_page')); 
		}
		function menu_page_exists( $menu_slug ) {
			global $menu;
			foreach ( $menu as $i => $item ) {
					if ( $menu_slug == $item[2] ) {
							return true;
					}
			}
			return false;
		}
		function get_data_by_date($dateFrom, $dateTo) {
			global $wpdb;
			$timeSpan_concat =  "DATE(time)";
			//this query is important, so that you can view all results
			$general_query = $wpdb->prepare("
										SELECT $timeSpan_concat  AS htime, GROUP_CONCAT( details) AS details
										FROM ".$wpdb->prefix.$this->table."
										WHERE DATE( TIME ) >=%s
										AND DATE( TIME ) <=%s
										GROUP BY htime", $dateFrom, $dateTo);
			//first query, count all unique keywords per specified time and timepsan
			$count_unique_query = $wpdb->prepare("SELECT * , COUNT( * ) AS count_unique
									FROM (
										SELECT $timeSpan_concat  AS dtime
										FROM ".$wpdb->prefix.$this->table."
										WHERE DATE( TIME ) >=%s
										AND DATE( TIME ) <=%s
										GROUP BY dtime, keyword
									) AS d
									GROUP BY dtime", $dateFrom, $dateTo);
			$count_search_query = $wpdb->prepare("
										SELECT $timeSpan_concat  AS stime, COUNT( * ) AS count_search
										FROM ".$wpdb->prefix.$this->table."
										WHERE DATE( TIME ) >=%s
										AND DATE( TIME ) <=%s
										GROUP BY stime", $dateFrom, $dateTo);
			$count_zero_query = $wpdb->prepare("
										SELECT count(*) as count_zero ,$timeSpan_concat  AS atime
										FROM ".$wpdb->prefix.$this->table."
										WHERE DATE( TIME ) >=%s
										AND DATE( TIME ) <=%s
										AND total =0
										GROUP BY atime
									", $dateFrom, $dateTo);
			$sum_total_query = $wpdb->prepare("
										SELECT SUM(total) as total_results ,$timeSpan_concat  AS ttime
										FROM ".$wpdb->prefix.$this->table."
										WHERE DATE( TIME ) >=%s
										AND DATE( TIME ) <=%s
										GROUP BY ttime
									", $dateFrom, $dateTo);
			$results = array();
			if(isset($_GET['keyword_count'])) {
				if(isset($_GET['keyword'])) {
					$general_query = $wpdb->prepare("
										SELECT $timeSpan_concat  AS htime, GROUP_CONCAT( details) AS details, keyword
										FROM ".$wpdb->prefix.$this->table."
										WHERE DATE( TIME ) >=%s
										AND DATE( TIME ) <=%s
										AND total =%s
										AND keyword =%s
										GROUP BY htime", $dateFrom, $dateTo, intval($_GET['keyword_count']), urldecode($_GET['keyword']));
					$count_search_query = $wpdb->prepare("
										SELECT $timeSpan_concat  AS stime, COUNT( * ) AS count_search
										FROM ".$wpdb->prefix.$this->table."
										WHERE DATE( TIME ) >=%s
										AND DATE( TIME ) <=%s
										AND total =%s
										AND keyword =%s
										GROUP BY stime", $dateFrom, $dateTo, intval($_GET['keyword_count']), urldecode($_GET['keyword']));
					$sql = "SELECT DATE(htime) as date, keyword, GROUP_CONCAT( details) AS details, count_search FROM ($general_query) as gq LEFT JOIN ($count_search_query) AS shq ON gq.htime = shq.stime GROUP BY date";
					$results = $wpdb->get_results($sql);
				}
			}
			else{
				$sql = "SELECT DATE(htime) as date, GROUP_CONCAT( details) AS details, count_unique, count_search, count_zero, total_results FROM ($general_query) as gq LEFT JOIN ($count_unique_query) AS uq ON gq.htime = uq.dtime LEFT JOIN ($count_search_query) AS shq ON gq.htime = shq.stime LEFT JOIN ($count_zero_query) AS zq ON zq.atime = gq.htime LEFT JOIN ($sum_total_query) AS sq ON sq.ttime = gq.htime GROUP BY date";
				$wpdb->query('SET SESSION group_concat_max_len = 1000000;');
				$results = $wpdb->get_results($sql);
			}
			return $results;
			
		}	
		function get_data_by_time($dateFrom, $dateTo, $hourFrom, $minuteFrom, $hourTo, $minuteTo, $timeSpan) {
			global $wpdb;
			$timeFrom = ($hourFrom < 10 ? '0'.$hourFrom:$hourFrom).":".($minuteFrom < 10 ? '0'.$minuteFrom:$minuteFrom);
			$timeTo = ($hourTo < 10 ? '0'.$hourTo:$hourTo).":".($minuteTo < 10 ? '0'.$minuteTo:$minuteTo);
			$timeSpan_concat =  "CONCAT_WS(  ' - ', CONCAT( DATE_FORMAT( TIME,  '%%H' ) ,  ':', LPAD( DATE_FORMAT( TIME,  '%%i' ) - MOD( DATE_FORMAT( TIME,  '%%i' ) , $timeSpan ) , 2,  '0' ) ) , CONCAT( DATE_FORMAT( TIME,  '%%H' ) ,  ':', LPAD( DATE_FORMAT( TIME,  '%%i' ) - MOD( DATE_FORMAT( TIME,  '%%i' ) , $timeSpan ) + $timeSpan, 2,  '0' ) ) )";
			if($timeSpan > 59) {
				$timeSpan = $timeSpan/60;
				$timeSpan_concat =  "CONCAT_WS(  ' - ', CONCAT( LPAD(DATE_FORMAT( TIME,  '%%H' ) - MOD( DATE_FORMAT( TIME,  '%%H' ) , $timeSpan ), 2,  '0' ) ,  ':00' ) , CONCAT( LPAD(DATE_FORMAT( TIME,  '%%H' ) - MOD( DATE_FORMAT( TIME,  '%%H' ) , $timeSpan ) + $timeSpan, 2,  '0' ),  ':00' ) )";
			}
			//this query is important, so that you can view all results
			$general_query = $wpdb->prepare("
										SELECT $timeSpan_concat  AS htime, total as results, GROUP_CONCAT( details) AS details
										FROM ".$wpdb->prefix.$this->table."
										WHERE TIME( TIME ) >=%s
										AND TIME( TIME ) <=%s
										AND DATE( TIME ) >=%s
										AND DATE( TIME ) <=%s
										GROUP BY htime", $timeFrom, $timeTo, $dateFrom, $dateTo);
			//first query, count all unique keywords per specified time and timepsan
			$count_unique_query = $wpdb->prepare("SELECT * , COUNT( * ) AS count_unique
									FROM (
										SELECT $timeSpan_concat  AS dtime
										FROM ".$wpdb->prefix.$this->table."
										WHERE TIME( TIME ) >=%s
										AND TIME( TIME ) <=%s
										AND DATE( TIME ) >=%s
										AND DATE( TIME ) <=%s
										GROUP BY dtime, keyword
									) AS d
									GROUP BY dtime", $timeFrom, $timeTo, $dateFrom, $dateTo);
			$count_search_query = $wpdb->prepare("
										SELECT $timeSpan_concat  AS stime, COUNT( * ) AS count_search
										FROM ".$wpdb->prefix.$this->table."
										WHERE TIME( TIME ) >=%s
										AND TIME( TIME ) <=%s
										AND DATE( TIME ) >=%s
										AND DATE( TIME ) <=%s
										GROUP BY stime", $timeFrom, $timeTo, $dateFrom, $dateTo);
			$count_zero_query = $wpdb->prepare("
										SELECT count(*) as count_zero_time ,$timeSpan_concat  AS atime
										FROM ".$wpdb->prefix.$this->table."
										WHERE TIME( TIME ) >=%s
										AND TIME( TIME ) <=%s
										AND DATE( TIME ) >=%s
										AND DATE( TIME ) <=%s
										AND total =0
										GROUP BY atime
									", $timeFrom, $timeTo, $dateFrom, $dateTo);
			$sum_total_query = $wpdb->prepare("
										SELECT SUM(total) as total_results ,$timeSpan_concat  AS ttime
										FROM ".$wpdb->prefix.$this->table."
										WHERE TIME( TIME ) >=%s
										AND TIME( TIME ) <=%s
										AND DATE( TIME ) >=%s
										AND DATE( TIME ) <=%s
										GROUP BY ttime
									", $timeFrom, $timeTo, $dateFrom, $dateTo);

			$sql = "SELECT htime, GROUP_CONCAT( details) AS details, count_unique, count_search, count_zero_time, total_results FROM ($general_query) as gq LEFT JOIN ($count_unique_query) AS uq ON gq.htime = uq.dtime LEFT JOIN ($count_search_query) AS shq ON gq.htime = shq.stime LEFT JOIN ($count_zero_query) AS zq ON zq.atime = gq.htime LEFT JOIN ($sum_total_query) AS sq ON sq.ttime = gq.htime GROUP BY htime ORDER BY htime";
			$wpdb->query('SET SESSION group_concat_max_len = 1000000;');
			$results = $wpdb->get_results($sql);
			return $results;
			
		}	
		function count_data() {
			global $wpdb;
			$count = $wpdb->get_var("
										SELECT count(*)
										FROM ".$wpdb->prefix.$this->table."
										");
			return $count;
		}
		function get_data_by_keyword($dateFrom, $dateTo) {
			global $wpdb;
					//this query is important, so that you can view all results
			$general_query = $wpdb->prepare("
										SELECT keyword, details
										FROM ".$wpdb->prefix.$this->table."
										WHERE DATE( TIME ) >=%s
										AND DATE( TIME ) <=%s
										GROUP BY id", $dateFrom, $dateTo);
			//first query, count all unique keywords per specified time and timepsan
			$count_search_query = $wpdb->prepare("SELECT SUM(cnt_search) AS count_search, keyword as ckeyword FROM (
										SELECT COUNT( * ) AS cnt_search, keyword
										FROM ".$wpdb->prefix.$this->table."
										WHERE DATE( TIME ) >=%s
										AND DATE( TIME ) <=%s
										GROUP BY id) AS d GROUP BY ckeyword", $dateFrom, $dateTo);
			$count_zero_query = $wpdb->prepare("
										SELECT count(*) as count_zero , keyword AS zkeyword
										FROM ".$wpdb->prefix.$this->table."
										WHERE DATE( TIME ) >=%s
										AND DATE( TIME ) <=%s
										AND total =0
										GROUP BY zkeyword
									", $dateFrom, $dateTo);
			$sum_total_query = $wpdb->prepare("
										SELECT SUM(total) as total_results, ROUND(AVG(total)) as average_total_results, keyword AS skeyword
										FROM ".$wpdb->prefix.$this->table."
										WHERE DATE( TIME ) >=%s
										AND DATE( TIME ) <=%s
										GROUP BY skeyword
									", $dateFrom, $dateTo);
			if(isset($_GET['keyword_count'])) {
				if(isset($_GET['keyword'])) {
					$results = $wpdb->get_results($wpdb->prepare('SELECT * FROM (SELECT keyword, count(*) as count_kzero, DATE(time) as date,SUM( total ) as total_results FROM '.$wpdb->prefix.$this->table.' WHERE DATE(time) >=%s AND DATE(time) <=%s GROUP BY keyword) as t WHERE total_results=%d AND keyword=%s',$dateFrom, $dateTo, intval($_GET['keyword_count']), urldecode($_GET['keyword'])));
				}
				else{
					$results = $wpdb->get_results($wpdb->prepare('SELECT * FROM (SELECT keyword, count(*) as count_kzero, DATE(time) as date,SUM( total ) as total_results FROM '.$wpdb->prefix.$this->table.' WHERE DATE(time) >=%s AND DATE(time) <=%s GROUP BY keyword) as t WHERE total_results=%d',$dateFrom, $dateTo, intval($_GET['keyword_count'])));
				}
			}
			else{
				$wpdb->query('SET SESSION group_concat_max_len = 1000000;');
				$sql = "SELECT  keyword, GROUP_CONCAT( details) AS details, count_search, count_zero, average_total_results, total_results FROM ($general_query) as gq LEFT JOIN ($count_search_query) AS shq ON gq.keyword = shq.ckeyword LEFT JOIN ($count_zero_query) AS zq ON zq.zkeyword = gq.keyword LEFT JOIN ($sum_total_query) AS sq ON sq.skeyword = gq.keyword GROUP BY keyword";
				
				$results = $wpdb->get_results($sql);
			}
			return $results;
			
		}	
		function get_data_by_keyword_time($dateFrom, $dateTo, $hourFrom, $minuteFrom, $hourTo, $minuteTo, $timeSpan) {
			global $wpdb;
			$timeFrom = ($hourFrom < 10 ? '0'.$hourFrom:$hourFrom).":".($minuteFrom < 10 ? '0'.$minuteFrom:$minuteFrom);
			$timeTo = ($hourTo < 10 ? '0'.$hourTo:$hourTo).":".($minuteTo < 10 ? '0'.$minuteTo:$minuteTo);
			//this query is important, so that you can view all results
			$results = $wpdb->get_results($wpdb->prepare('SELECT * FROM (SELECT keyword, count(*) as count_kzero, MIN(TIME(time)) as time, MAX(TIME(time)) as ttime,SUM( total ) as total_results FROM '.$wpdb->prefix.$this->table.' WHERE DATE(time) >=%s AND DATE(time) <=%s AND TIME( TIME ) >=%s AND TIME( TIME ) <=%s GROUP BY keyword) as t WHERE total_results=%d',$dateFrom, $dateTo, $timeFrom, $timeTo, intval($_GET['keyword_count'])));
			return $results;
			
		}
		function clear_data_by_date($dateFrom, $dateTo) {
			global $wpdb;
			$sql = $wpdb->prepare("
										DELETE
										FROM ".$wpdb->prefix.$this->table."
										WHERE DATE( TIME ) >=%s
										AND DATE( TIME ) <=%s
										", $dateFrom, $dateTo);
			$wpdb->query($sql);
		}
		function admin_page(){
			$tab = (!empty($_REQUEST['tab']) ? trim($_REQUEST['tab']) : false);
			$message = (!empty($_REQUEST['message']) ? trim($_REQUEST['message']) : false);			
				?>
			<style type="text/css">
			.column-order, .column-limit_results, .column-show_on_search
			{
				text-align: center !important;
				width: 75px;
			}
			tr.row-no{
				color:#444 !important;
				background: #F3F3F3;
			}
			tr.row-no a.row-title{
				color:#444 !important;
			}
			</style>
			<div class="wrap" id="ajaxy-tracker">
				<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
				<h2><?php _e('Ajaxy Search Keyword Analyzer & Tracker'); ?></h2>
				
				<ul class="subsubsub">
					<li class="active"><a href="<?php echo menu_page_url('ajaxy_sft_admin', false); ?>" class="<?php echo (!$tab ? 'current' : ''); ?>">By Keyword<span class="count"></span></a> |</li>
					<li class="active"><a href="<?php echo menu_page_url('ajaxy_sft_admin', false).'&tab=date'; ?>" class="<?php echo ($tab == 'date' ? 'current' : ''); ?>">By Date<span class="count"></span></a> |</li>
					<li class="active"><a href="<?php echo menu_page_url('ajaxy_sft_admin', false).'&tab=time'; ?>" class="<?php echo ($tab == 'time' ? 'current' : ''); ?>">By Time<span class="count"></span></a> |</li>
					<li class="active"><a href="<?php echo menu_page_url('ajaxy_sft_admin', false).'&tab=settings'; ?>" class="<?php echo ($tab == 'settings' ? 'current' : ''); ?>">Settings<span class="count"></span></a></li>
				</ul>
				<hr style="clear:both; display:block"/>
				<?php if($tab != 'settings') { 
					$count_data = $this->count_data(); ?>
				<?php if($count_data == 0): ?>
				<div class="updated">There are no records yet to analyze.</div>	
				<?php elseif($count_data > 10000): ?>
				<div class="updated">Data reached <b><?php echo $count_data; ?></b>, consider deleting some old data from <a href="<?php echo menu_page_url('ajaxy_sft_admin', false).'&tab=settings'; ?>">here</a>.</div>	
				<?php endif; 
				}
				?>
				<script type="text/javascript" src="https://www.google.com/jsapi"></script>
				<script type="text/javascript"> 
				var sfk_tab = "<?php echo $tab; ?>";
				var chartType = 'AreaChart';
				var cookie = sfkGetCookie('sfk_cookie_charts_' + sfk_tab);
				if(cookie != null) {
					chartType = cookie;
				}
				</script>
				<?php if($tab != 'settings') { 
					$charts = array('AreaChart' => 'Area Chart', 
									'BubbleChart' => 'Bubble Chart', 
									//'BarChart' => 'Bar Chart', 
									//'CandlestickChart' => 'Candlestick Chart', 
									'ColumnChart' => 'Column Chart',
									'ComboChart' => 'Combo Chart',
									//'LineChart' => 'Line Chart', 
									'PieChart'	=> 'Pie Chart',
									'SteppedAreaChart' => 'Stepped Area Chart'
					);
					
				?>
				<form action="<?php echo menu_page_url('ajaxy_sft_admin', false); ?>" method="get">
					<input type="hidden" name="tab" value="<?php echo $tab; ?>"/>
					<input type="hidden" name="page" value="ajaxy_sft_admin"/>
				<div class="sfk_daterange">
					<?php $dateFrom = isset($_GET['dateFrom']) ? $_GET['dateFrom']: date('Y-m-d', strtotime('-30 days')); ?>
					<?php $dateTo = isset($_GET['dateTo']) ? $_GET['dateTo']: date('Y-m-d', strtotime('now')); 
						$hourFrom = isset($_GET['timeFromHour']) && $_GET['timeFromHour'] >= 0 ? $_GET['timeFromHour'] :0;
						$hourTo = isset($_GET['timeToHour']) && $_GET['timeToHour'] >= 0? $_GET['timeToHour'] :23;
						$minuteFrom = isset($_GET['timeFromMinute']) && $_GET['timeFromMinute'] > 0? $_GET['timeFromMinute'] :1;
						$minuteTo = isset($_GET['timeToMinute']) && $_GET['timeToMinute'] > 0 ? $_GET['timeToMinute'] :59;
						$timeSpan = isset($_GET['timeSpan']) && $_GET['timeSpan'] > 0 ? $_GET['timeSpan'] :10;
					
					?>
					<b><?php _e('Date'); ?></b> - 
					<label><?php _e('From'); ?></label>
					<input type="text" id="kdatepickerfrom" name="dateFrom"/>
					<label><?php _e('To'); ?></label>
					<input type="text" id="kdatepickerto" name="dateTo"/>
					<?php if($tab == 'time'): ?>
						<label><b><?php _e('Time Interval'); ?></b></label>
						<select name="timeFromHour">
						<option value="-1"><?php _e('Hour'); ?></option>
						<?php for($i =0; $i < 24; $i ++) { ?>
							<option value="<?php echo $i; ?>"<?php echo $i == $hourFrom ? ' selected="selected"':''; ?>><?php echo ($i < 10 ? '0'.$i : $i); ?></option>
						<?php } ?>
						</select>
						<label>:</label>
						<select name="timeFromMinute">
							<option value="-1"><?php _e('Minute'); ?></option>
						<?php for($i = 1; $i < 60; $i ++) { ?>
							<option value="<?php echo $i; ?>"<?php echo $i == $minuteFrom ? ' selected="selected"':''; ?>><?php echo ($i < 10 ? '0'.$i : $i); ?></option>
						<?php } ?>
						</select>
						<label><?php _e('To'); ?></label>
						<select name="timeToHour">
						<option value="-1"><?php _e('Hour'); ?></option>
						<?php for($i =0; $i < 24; $i ++) { ?>
							<option value="<?php echo $i; ?>"<?php echo $i == $hourTo ? ' selected="selected"':''; ?>><?php echo ($i < 10 ? '0'.$i : $i); ?></option>
						<?php } ?>
						</select>
						<label>:</label>
						<select name="timeToMinute">
							<option value="-1"><?php _e('Minute'); ?></option>
						<?php for($i = 1; $i < 60; $i ++) { ?>
							<option value="<?php echo $i; ?>"<?php echo $i == $minuteTo ? ' selected="selected"':''; ?>><?php echo ($i < 10 ? '0'.$i : $i); ?></option>
						<?php } ?>
						</select>
						<label>:</label>
						<select name="timeSpan">
							<option value="-1"><?php _e('Timespan'); ?></option>
						<?php for($i = 5; $i <= 60; $i =$i + 5) { ?>
							<option value="<?php echo $i; ?>"<?php echo $i == $timeSpan ? ' selected="selected"':''; ?>><?php echo $i; ?> <?php _e('Minutes'); ?></option>
						<?php } ?>
						<?php for($i = 2; $i <= 23; $i++) { ?>
							<option value="<?php echo $i*60; ?>"<?php echo $i*60 == $timeSpan ? ' selected="selected"':''; ?>><?php echo $i; ?> <?php _e('Hours'); ?></option>
						<?php } ?>
						</select>
					<?php endif; ?>
					<input type="submit" class="button-primary" style="margin-left:20px"/>
					<script type="text/javascript">
					jQuery(function() {
						jQuery( "#kdatepickerfrom" ).datepicker({
						  changeMonth: true,
						  dateFormat: 'yy-mm-dd',
						  changeYear: true,
						  buttonImage: "<?php echo plugins_url( '/', __FILE__ ); ?>css/images/calendar.gif",
						  buttonImageOnly: false,
											  
						});
						jQuery( "#kdatepickerfrom" ).datepicker( "setDate", "<?php echo $dateFrom; ?>" );
						jQuery( "#kdatepickerto" ).datepicker({
						  changeMonth: true,
						  dateFormat: 'yy-mm-dd',
						  changeYear: true,
						  buttonImage: "<?php echo plugins_url( '/', __FILE__ ); ?>css/images/calendar.gif",
						  buttonImageOnly: false
						});
						jQuery( "#kdatepickerto" ).datepicker( "setDate", "<?php echo $dateTo; ?>" );
					  });
					  options.chartArea.width = jQuery('#ajaxy-tracker').width() - 100;
					 </script>
				</div>
				</form>
				<?php } ?>
				 
				<?php if($tab == 'date'): 
					$results = $this->get_data_by_date($dateFrom, $dateTo);
					$columns = array('date' => _('Date'), 'details' => _('Details'), 'count_search' => _('Search'), 'count_unique' => _('Unique Results'), 'count_zero' => _('No Results'), 'total_results' => _('Total results'));
					?>
					<script type="text/javascript">
					  google.load("visualization", "1", {packages:["corechart"]});
					  google.setOnLoadCallback(drawDefaultChart);
					  options.vAxis.title = 'Results';
					  var mdata = [
							<?php
							$done = false;
						  foreach($results as $result) :
							$dml = array();
							if($done == false) {
							foreach($columns as $key => $value):
								if($key !='details') {
									$dml[] = $value;
								}
							endforeach;
							$done = true;
								?>
							  ['<?php echo implode("','", $dml); ?>'],
							  <?php
							  }
							$dm = array();
							foreach($columns as $key => $value):
								if($key !='details') {
									if($key == 'date') {
										$dm[] = "'".date('Y-m-d', strtotime($result->date))."'"	;
									}
									else{
										$dm[] = intval($result->{$key});
									}
								}
						  ?> <?php endforeach; ?>
						  [<?php echo implode(',', $dm); ?>],
						  <?php endforeach; ?>];
					 
					</script>
					<div id="chart_columns">
					<select id="chartType">
					<?php foreach($charts as $key => $value) { ?>
						<option value="<?php echo $key; ?>"<?php echo (isset($_COOKIE['sfk_cookie_charts_'.$tab]) ? ($_COOKIE['sfk_cookie_charts_'.$tab] == $key ? ' selected="selected"' : '') : ''); ?>><?php echo $value; ?></option>
					<?php } ?>
					</select>&nbsp;
					 <?php  
					 $i = 0;
					 foreach($columns as $key => $value) : 
					 if($key == 'details'){
						continue;
					 }
					 if($i > 0 ) {
					 ?>
					 <label><input type="checkbox" value="<?php echo $i; ?>"<?php echo (isset($_COOKIE['sfk_cookie_columns_'.$tab]) ? (in_array($i, explode(',', $_COOKIE['sfk_cookie_columns_'.$tab])) ? ' checked="checked"' : '') : ' checked="checked"'); ?> class="chkbox" /><?php echo $value; ?></label>&nbsp;
					<?php 
						
					}
					$i ++;
					endforeach; ?>
					<div class="chart_warning">
						<?php _e('Pie Charts cannot display more than one column'); ?>
					</div>
					</div>
					<div id="chart_div" style="width: 100%; height: 300px;"></div>
					<?php require_once('classes/class-wp-ajaxy-sft-list-table.php'); ?>
					<?php $list_table = new WP_SFT_List_Table($results, array_keys($columns)); 
						$list_table->dateFrom = $dateFrom;
						$list_table->dateTo = $dateTo;
					?>
					<div>
						<?php if ( $message ) : ?>
						<div id="message" class="updated"><p><?php echo $message; ?></p></div>
						<?php endif; ?>
						<?php $list_table->display(); ?>
					</div>
				<?php elseif($tab == 'time'): 
					if(isset($_GET['time'])):
						unset($charts['BubbleChart']);
						$results = $this->get_data_by_keyword_time($dateFrom, $dateTo, $hourFrom, $minuteFrom, $hourTo, $minuteTo, $timeSpan);
						$columns = array('keyword' => _('keyword'), 'count_kzero' => _('No Results')); ?>
										<script type="text/javascript">
					  google.load("visualization", "1", {packages:["corechart"]});
					  google.setOnLoadCallback(drawDefaultChart);
					  options.hAxis.title = '<?php _e('Keyword'); ?>';
					  options.vAxis.title = '<?php _e('Results'); ?>';
					  var mdata = [
						
						  <?php 
						  $done = false;
						  foreach($results as $result) :
							$dml = array();
							if($done == false) {
							foreach($columns as $key => $value):
								$dml[] = $value;
							endforeach;
							$done = true;
								?>
							  ['<?php echo implode("','", $dml); ?>'],
							  <?php
							  }
							$dm = array();
							foreach($columns as $key => $value):
								if($key == 'keyword') {
									$dm[] = "'".str_replace("'", "\'", $result->keyword)."'";
								}
								else{
									$dm[] = intval($result->{$key});
								}
						  ?> <?php endforeach; ?>
						  [<?php echo implode(',', $dm); ?>],
						  <?php endforeach; ?>];
					</script>
					<div id="chart_columns">
					<select id="chartType">
					<?php foreach($charts as $key => $value) { ?>
						<option value="<?php echo $key; ?>"<?php echo (isset($_COOKIE['sfk_cookie_charts_'.$tab]) ? ($_COOKIE['sfk_cookie_charts_'.$tab] == $key ? ' selected="selected"' : '') : ''); ?>><?php echo $value; ?></option>
					<?php } ?>
					</select>&nbsp;
					<div class="chart_warning">
						<?php _e('Pie Charts cannot display more than one column'); ?>
					</div>
					</div>
						<div id="chart_div" style="width: 100%; height: 300px;"></div>
						<?php require_once('classes/class-wp-ajaxy-sft-list-table.php'); ?>
						<?php $list_table = new WP_SFT_List_Table($results, array_keys($columns)); 
						
						$list_table->dateFrom = $dateFrom;
						$list_table->dateTo = $dateTo;
						?>
						<div>
							<?php if ( $message ) : ?>
							<div id="message" class="updated"><p><?php echo $message; ?></p></div>
							<?php endif; ?>
							<?php $list_table->display(); ?>
						</div>
						<?php
					else:
					$columns = array('htime' => _('Time Interval'), 'details' => _('Details'), 'count_search' => _('Search'), 'count_unique' => _('Unique Results'), 'count_zero_time' => _('No Results'), 'total_results' => _('Total results'));
					$results = $this->get_data_by_time($dateFrom, $dateTo, $hourFrom, $minuteFrom, $hourTo, $minuteTo, $timeSpan);
					?>
					<script type="text/javascript">
					  google.load("visualization", "1", {packages:["corechart"]});
					  google.setOnLoadCallback(drawDefaultChart);
					  options.hAxis.title = '<?php _e('Time'); ?>';
					  options.vAxis.title = '<?php _e('Search'); ?>';
					  var mdata = [
						
						  <?php 
						  $done = false;
						  foreach($results as $result) :
							$dml = array();
							if($done == false) {
							foreach($columns as $key => $value):
								if($key !='details') {
									$dml[] = $value;
								}
							endforeach;
							$done = true;
								?>
							  ['<?php echo implode("','", $dml); ?>'],
							  <?php
							  }
							$dm = array();
							foreach($columns as $key => $value):
								if($key !='details') {
									if($key == 'htime') {
										$dm[] = "'".$result->htime."'"	;
									}
									else{
										$dm[] = intval($result->{$key});
									}
								}
						  ?> <?php endforeach; ?>
						  [<?php echo implode(',', $dm); ?>],
						  <?php endforeach; ?>];
					</script>
					<div id="chart_columns">
					<select id="chartType">
					<?php foreach($charts as $key => $value) { ?>
						<option value="<?php echo $key; ?>"<?php echo (isset($_COOKIE['sfk_cookie_charts_'.$tab]) ? ($_COOKIE['sfk_cookie_charts_'.$tab] == $key ? ' selected="selected"' : '') : ''); ?>><?php echo $value; ?></option>
					<?php } ?>
					</select>&nbsp;
					 <?php  
					 $i = 0;
					 foreach($columns as $key => $value) : 
					 if($key == 'details'){
						continue;
					 }
					 if($i > 0) {
					 ?>
					 <label><input type="checkbox" value="<?php echo $i; ?>"<?php echo (isset($_COOKIE['sfk_cookie_columns_'.$tab]) ? (in_array($i, explode(',', $_COOKIE['sfk_cookie_columns_'.$tab])) ? ' checked="checked"' : '') : ' checked="checked"'); ?> class="chkbox" /><?php echo $value; ?></label>&nbsp;
					<?php 
					}
					$i ++;
					endforeach; ?>
					<div class="chart_warning">
						<?php _e('Pie Charts cannot display more than one column'); ?>
					</div>
					</div>
					<div id="chart_div" style="width: 100%; height: 300px;"></div>
					<?php require_once('classes/class-wp-ajaxy-sft-list-table.php'); ?>
					<?php $list_table = new WP_SFT_List_Table($results, array_keys($columns)); ?>
					<div>
						<?php if ( $message ) : ?>
						<div id="message" class="updated"><p><?php echo $message; ?></p></div>
						<?php endif; ?>
						<?php 
						$list_table->dateFrom = $dateFrom;
						$list_table->dateTo = $dateTo;
						
						$list_table->display(); 
						
						
						?>
					</div>
					<?php endif; ?>
				<?php elseif($tab == 'settings'): 
					if(isset($_POST['action'])){
						$settings = array();
						if($_POST['action'] == "general"){
							$post_data = $_POST['sfk'];
							$settings['track_search'] = ( isset($post_data['track_search']) ? 1:0);
							$settings['track_live_search'] = ( isset($post_data['track_live_search']) ? 1:0);
							$settings['dashboard_data'] = $post_data['dashboard_data'];
							$this->set_settings($settings);
						}
						elseif($_POST['action'] == "clear-data"){
							$post_data = $_POST['sfk'];
							if(!empty($post_data['dateFrom']) && !empty($post_data['dateTo'])) {
								$this->clear_data_by_date($post_data['dateFrom'], $post_data['dateTo']);
							}
						}
					}
					$settings = $this->get_settings();
				?>
				<h3>Tracking</h3>
				<form action="<?php echo menu_page_url('ajaxy_sft_admin', false); ?>&tab=settings" method="post">
					<input type="hidden" name="action" value="general"/>
					<input type="hidden" name="sfk[submit]" value="1"/>
					<table class="form-table">
						<tbody>
							<tr valign="top">
								<td>
									<input type="checkbox" name="sfk[track_search]" <?php echo  $settings->track_search == 1 ? 'checked="checked"' : ''; ?>/>
									<span class="description">Track blog search and data.</span>
								</td>
							</tr>
							<tr valign="top">
								<td>
									<input type="checkbox" name="sfk[track_live_search]" <?php echo  $settings->track_live_search == 1 ? 'checked="checked"' : ''; ?>/>
									<span class="description">Track blog live search (<a href="http://localhost:100/wordpress/new-blog/wp-admin/plugin-install.php?tab=plugin-information&plugin=ajaxy-search-form&TB_iframe=true&width=600&height=550"><b>Ajaxy live search - 2.3 or greater</b></a> plugin required).</span>
								</td>
							</tr>
							<tr valign="top">
								<td>
									<h4>Dashboard Widget</h4>
									<label>Show Data: </label>
									<select name="sfk[dashboard_data]">
										<option value="0"<?php echo ($settings->dashboard_data == 0 ? ' selected="selected"': ''); ?>><?php _e('Daily'); ?></option>
										<option value="1"<?php echo ($settings->dashboard_data == 1 ? ' selected="selected"': ''); ?>><?php _e('Weekly'); ?></option>
										<option value="2"<?php echo ($settings->dashboard_data == 2 ? ' selected="selected"': ''); ?>><?php _e('Monthly'); ?></option>
									</select>
								</td>
							</tr>
							<tr valign="top">
								<td>
									<input type="submit" value="<?php _e('Save'); ?>" class="button-primary"/>
								</td>
							</tr>
						</tbody>
					</table>
				</form>
				<hr/>
				<h3>Data (<?php echo $this->count_data(); ?> records)</h3>
				<p>Data should be cleared from time to time for more performance, data might become huge if your blog is receiving a lot of searches daily.</p>
				<form action="<?php echo menu_page_url('ajaxy_sft_admin', false); ?>&tab=settings" method="post">
					<input type="hidden" name="page" value="ajaxy_sft_admin"/>
					<input type="hidden" name="action" value="clear-data"/>
					<table class="form-table">
						<tbody>
							<tr valign="top">
								<td>
									<b><?php _e('Date'); ?>: </b> 
									<label><?php _e('From'); ?></label>
									<input type="text" id="sdatepickerfrom" name="sfk[dateFrom]"/>
									<label><?php _e('To'); ?></label>
									<input type="text" id="sdatepickerto" name="sfk[dateTo]"/>
								</td>
							</tr>
							<tr valign="top">
								<td>
									<input type="submit" value="<?php _e('Clear Data'); ?>" class="button-primary"/>
								</td>
							</tr>
						</tbody>
					</table>
					<script type="text/javascript">
						jQuery(function() {
							jQuery( "#sdatepickerfrom" ).datepicker({
							  changeMonth: true,
							  dateFormat: 'yy-mm-dd',
							  changeYear: true,
							  buttonImage: "<?php echo plugins_url( '/', __FILE__ ); ?>css/images/calendar.gif",
							  buttonImageOnly: false,
												  
							});
							jQuery( "#sdatepickerto" ).datepicker({
							  changeMonth: true,
							  dateFormat: 'yy-mm-dd',
							  changeYear: true,
							  buttonImage: "<?php echo plugins_url( '/', __FILE__ ); ?>css/images/calendar.gif",
							  buttonImageOnly: false
							});
						  });
					 </script>
				</form>
				<?php else: 
					$columns = array('keyword' => _('keyword'), 'details' => _('Details'), 'count_search' => _('Search'), 'count_zero' => _('No Results'), 'average_total_results' => _('Average Results per keyword'), 'total_results' => _('Total results'));
					if(isset($_GET['keyword_count'])) : 
						if(isset($_GET['keyword'])) : 
							unset($charts['BubbleChart']);
							$results = $this->get_data_by_date($dateFrom, $dateTo);
							$columns = array('date' => _('Date'), 'keyword' => _('keyword'), 'details' => _('Details'), 'count_search' => _('Search'));
							?>
						<script type="text/javascript">
						  google.load("visualization", "1", {packages:["corechart"]});
						  google.setOnLoadCallback(drawDefaultChart);
						  options.hAxis.title = '<?php _e('Date'); ?>';
						  options.vAxis.title = '<?php _e('Search'); ?>';
						  var mdata = [
							
							  <?php 
							  $done = false;
							  foreach($results as $result) :
								$dml = array();
								if($done == false) {
								foreach($columns as $key => $value):
									if($key != 'keyword') {
										$dml[] = $value;
									}
								endforeach;
								$done = true;
									?>
								  ['<?php echo implode("','", $dml); ?>'],
								  <?php
								  }
								$dm = array();
								foreach($columns as $key => $value):
									if($key == 'keyword') {
										$dm[] = "'".str_replace("'", "\'", $result->keyword)."'";
									}
									elseif($key == 'date') {
										//$dm[] = "'".str_replace("'", "\'", $result->date)."'";
									}
									else{
										$dm[] = intval($result->{$key});
									}
							  ?> <?php endforeach; ?>
							  [<?php echo implode(',', $dm); ?>],
							  <?php endforeach; ?>];
						</script>
						<div id="chart_columns">
						<select id="chartType">
						<?php foreach($charts as $key => $value) { ?>
							<option value="<?php echo $key; ?>"<?php echo (isset($_COOKIE['sfk_cookie_charts_'.$tab]) ? ($_COOKIE['sfk_cookie_charts_'.$tab] == $key ? ' selected="selected"' : '') : ''); ?>><?php echo $value; ?></option>
						<?php } ?>
						</select>&nbsp;
						<div class="chart_warning">
							<?php _e('Pie Charts cannot display more than one column'); ?>
						</div>
						</div>
							<div id="chart_div" style="width: 100%; height: 300px;"></div>
							<?php require_once('classes/class-wp-ajaxy-sft-list-table.php'); ?>
							<?php $list_table = new WP_SFT_List_Table($results, array_keys($columns)); 
							$list_table->dateFrom = $dateFrom;
							$list_table->dateTo = $dateTo;
							?>
							<div>
								<?php if ( $message ) : ?>
								<div id="message" class="updated"><p><?php echo $message; ?></p></div>
								<?php endif; ?>
								<?php $list_table->display(); ?>
							</div>
							<?php
						else:
							unset($charts['BubbleChart']);
							$results = $this->get_data_by_keyword($dateFrom, $dateTo);
							$columns = array('keyword' => _('keyword'),  'count_kzero' => _('No Results'));
							?>
						<script type="text/javascript">
						  google.load("visualization", "1", {packages:["corechart"]});
						  google.setOnLoadCallback(drawDefaultChart);
						  options.hAxis.title = '<?php _e('Keyword'); ?>';
						  options.vAxis.title = '<?php _e('Results'); ?>';
						  var mdata = [
							
							  <?php 
							  $done = false;
							  foreach($results as $result) :
								$dml = array();
								if($done == false) {
								foreach($columns as $key => $value):
									$dml[] = $value;
								endforeach;
								$done = true;
									?>
								  ['<?php echo implode("','", $dml); ?>'],
								  <?php
								  }
								$dm = array();
								foreach($columns as $key => $value):
									if($key == 'keyword') {
										$dm[] = "'".str_replace("'", "\'", $result->keyword)."'";
									}
									else{
										$dm[] = intval($result->{$key});
									}
							  ?> <?php endforeach; ?>
							  [<?php echo implode(',', $dm); ?>],
							  <?php endforeach; ?>];
						</script>
						<div id="chart_columns">
						<select id="chartType">
						<?php foreach($charts as $key => $value) { ?>
							<option value="<?php echo $key; ?>"<?php echo (isset($_COOKIE['sfk_cookie_charts_'.$tab]) ? ($_COOKIE['sfk_cookie_charts_'.$tab] == $key ? ' selected="selected"' : '') : ''); ?>><?php echo $value; ?></option>
						<?php } ?>
						</select>&nbsp;
						<div class="chart_warning">
							<?php _e('Pie Charts cannot display more than one column'); ?>
						</div>
						</div>
							<div id="chart_div" style="width: 100%; height: 300px;"></div>
							<?php require_once('classes/class-wp-ajaxy-sft-list-table.php'); ?>
							<?php $list_table = new WP_SFT_List_Table($results, array_keys($columns)); 
							
							$list_table->dateFrom = $dateFrom;
							$list_table->dateTo = $dateTo;
							?>
							<div>
								<?php if ( $message ) : ?>
								<div id="message" class="updated"><p><?php echo $message; ?></p></div>
								<?php endif; ?>
								<?php $list_table->display(); ?>
							</div>
						<?php endif; ?>
					<?php else: 
						$results = $this->get_data_by_keyword($dateFrom, $dateTo);
					?>
					<script type="text/javascript">
					  google.load("visualization", "1", {packages:["corechart"]});
					  google.setOnLoadCallback(drawDefaultChart);
					  options.hAxis.title = '<?php _e('Keyword'); ?>';
					  options.vAxis.title = '<?php _e('Results'); ?>';
					  var mdata = [
						
						  <?php 
						  $done = false;
						  foreach($results as $result) :
							$dml = array();
							if($done == false) {
							foreach($columns as $key => $value):
								if($key !='details') {
									$dml[] = $value;
								}
							endforeach;
							$done = true;
								?>
							  ['<?php echo implode("','", $dml); ?>'],
							  <?php
							  }
							$dm = array();
							foreach($columns as $key => $value):
								if($key !='details') {
									if($key == 'keyword') {
										$dm[] = "'".str_replace("'", "\'", $result->keyword)."'";
									}
									else{
										$dm[] = intval($result->{$key});
									}
								}
						  ?> <?php endforeach; ?>
						  [<?php echo implode(',', $dm); ?>],
						  <?php endforeach; ?>];
					</script>
						<div id="chart_columns">
						<select id="chartType">
						<?php foreach($charts as $key => $value) { ?>
							<option value="<?php echo $key; ?>"<?php echo (isset($_COOKIE['sfk_cookie_charts_'.$tab]) ? ($_COOKIE['sfk_cookie_charts_'.$tab] == $key ? ' selected="selected"' : '') : ''); ?>><?php echo $value; ?></option>
						<?php } ?>
						</select>&nbsp;
						 <?php  
						 $i = 0;
						 foreach($columns as $key => $value) : 
						 if($key =='details') {
							continue;
						 }
						 if($i > 0) {
						 ?>
						 <label><input type="checkbox" value="<?php echo $i; ?>"<?php echo (isset($_COOKIE['sfk_cookie_columns_'.$tab]) ? (in_array($i, explode(',', $_COOKIE['sfk_cookie_columns_'.$tab])) ? ' checked="checked"' : '') : ' checked="checked"'); ?> class="chkbox" /><?php echo $value; ?></label>&nbsp;
						<?php 
						}
						$i ++;
						endforeach; ?>
						<div class="chart_warning">
							<?php _e('Pie Charts cannot display more than one column'); ?>
						</div>
						</div>
						<div id="chart_div" style="width: 100%; height: 300px;"></div>
						<?php require_once('classes/class-wp-ajaxy-sft-list-table.php'); ?>
						<?php $list_table = new WP_SFT_List_Table($results, array_keys($columns)); 
						$list_table->dateFrom = $dateFrom;
						$list_table->dateTo = $dateTo;
						
						?>
						<div>
							<?php if ( $message ) : ?>
							<div id="message" class="updated"><p><?php echo $message; ?></p></div>
							<?php endif; ?>
							<?php $list_table->display(); ?>
						</div>
						<script type="text/javascript">
							sortTableByColumn('column-count_search', 'wp-list-table');
						</script>
					<?php endif; ?>
				<?php endif; ?>
			</div>
			<?php
		}
		function set_settings($value)
		{
			if(get_option('sfk_settings') !== false)
			{
				update_option('sfk_settings', json_encode($value));
			}
			else
			{
				add_option('sfk_settings', json_encode($value));
			}
		}
		function get_settings()
		{
			if(get_option('sfk_settings') !== false)
			{
				return json_decode(get_option('sfk_settings'));
			}
			else
			{
				$values = array(
						'track_search' => 1,
						'track_live_search' => 1,
						'dashboard_data' => 1,
						);
				return (object)$values;
			}
		}
		function enqueue_scripts() {
			wp_enqueue_script('sf_keyword',plugins_url( '/', __FILE__ ) . 'js/sf_keyword.js',array('jquery','jquery-ui-core','jquery-ui-datepicker'));
			wp_enqueue_style('sf_keyword', plugins_url( '/', __FILE__ ) . 'css/style.css');
		}
		function head()
		{
			//wp_register_script('jquery');
		}
		function get_ajax_url(){
			if(defined('ICL_LANGUAGE_CODE')){
				return admin_url('admin-ajax.php').'?lang='.ICL_LANGUAGE_CODE;
			}
			if(function_exists('qtrans_getLanguage')){

				return admin_url('admin-ajax.php').'?lang='.qtrans_getLanguage();
			}
			return admin_url('admin-ajax.php');
		}
		function footer()
		{
		}
		function admin_notice()
		{
		}
		function track_live_search($value, $results)
		{	
			global $wpdb;
			$count = 0;
			if(is_array($results)) {
				foreach($results as $key => $result) {
					if($key != 'order' && isset($result['all'])) {
						$count += sizeof($result['all']);
					}
				}
			}
			$data = array(
				'time' => date( 'Y-m-d H:i:s' ),
				'total' => $count,
				'keyword' => $value,
				'details' => 'ls',
			);
			$wpdb->insert( $wpdb->prefix.$this->table, $data, array('%s','%d','%s','%s') );
		}
		function track_search($posts, $query)
		{
			if($query->is_search()) {
				global $wpdb;
				$data = array(
					'time' => date( 'Y-m-d H:i:s' ),
					'total' => sizeof($posts),
					'keyword' => $query->get('s'),
					'details' => 's',
				);
				$wpdb->insert( $wpdb->prefix.$this->table, $data, array('%s','%d','%s','%s') );
			}
			return $posts;
		}
	}
}

global $AjaxyTracker;
$AjaxyTracker = new AjaxyTracker();


add_action('wp_dashboard_setup', 'sfk_add_dashboard_widgets' );
function sfk_add_dashboard_widgets() {
	wp_add_dashboard_widget('AJAXY_SFK_WIDGET', 'Ajaxy Search keywords tracker', 'sfk_widget_summary');	
} 
function sfk_widget_summary()
{
	global $AjaxyTracker;
	$settings = $AjaxyTracker->get_settings();
	$charts = array('AreaChart' => 'Area Chart', 
					'BubbleChart' => 'Bubble Chart', 
					//'BarChart' => 'Bar Chart', 
					//'CandlestickChart' => 'Candlestick Chart', 
					'ColumnChart' => 'Column Chart',
					'ComboChart' => 'Combo Chart',
					//'LineChart' => 'Line Chart', 
					'PieChart'	=> 'Pie Chart',
					'SteppedAreaChart' => 'Stepped Area Chart'
	);
	$dateFrom = date('Y-m-d', strtotime('-7 days'));
	if($settings->dashboard_data == 0){
		$dateFrom = date('Y-m-d', strtotime('-1 day'));
	}
	elseif($settings->dashboard_data == 2){
		$dateFrom = date('Y-m-d', strtotime('-30 days'));
	}
	$dateTo = date('Y-m-d', time());
	$results = $AjaxyTracker->get_data_by_date($dateFrom, $dateTo);
	$columns = array('date' => _('Date'),  'count_search' => _('Search'), 'count_unique' => _('Unique Results'), 'count_zero' => _('No Results'));
	?>
	<div id="ajaxy-tracker">
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript"> 
	var sfk_tab = "dashboard";
	var chartType = 'AreaChart';
	var cookie = sfkGetCookie('sfk_cookie_charts_' + sfk_tab);
	if(cookie != null) {
		chartType = cookie;
	}
	</script>
	<script type="text/javascript">
	  options.vAxis.title = 'Results';
	  options.chartArea.width = jQuery('#AJAXY_SFK_WIDGET .inside').width() - 100;
	  options.backgroundColor = '#f8f8f8';
	  google.load("visualization", "1", {packages:["corechart"]});
	  google.setOnLoadCallback(drawDefaultChart);
	  var mdata = [
			<?php
			$done = false;
		  foreach($results as $result) :
			$dml = array();
			if($done == false) {
			foreach($columns as $key => $value):
				if($key !='details') {
					$dml[] = $value;
				}
			endforeach;
			$done = true;
				?>
			  ['<?php echo implode("','", $dml); ?>'],
			  <?php
			  }
			$dm = array();
			foreach($columns as $key => $value):
				if($key !='details') {
					if($key == 'date') {
						$dm[] = "'".date('Y-m-d', strtotime($result->date))."'"	;
					}
					else{
						$dm[] = intval($result->{$key});
					}
				}
		  ?> <?php endforeach; ?>
		  [<?php echo implode(',', $dm); ?>],
		  <?php endforeach; ?>];
	 
	</script>
	<div id="chart_columns">
	<a class="link_more" href="<?php echo menu_page_url('ajaxy_sft_admin', false); ?>&tab=date&dateFrom=<?php echo $dateFrom; ?>&dateTo=<?php echo $dateTo; ?>"><?php _e('View more'); ?></a>
	<select id="chartType">
	<?php foreach($charts as $key => $value) { ?>
		<option value="<?php echo $key; ?>"<?php echo (isset($_COOKIE['sfk_cookie_charts_dashboard']) ? ($_COOKIE['sfk_cookie_charts_dashboard'] == $key ? ' selected="selected"' : '') : ''); ?>><?php echo $value; ?></option>
	<?php } ?>
	</select>&nbsp;
	 <?php  
	 $i = 0;
	 foreach($columns as $key => $value) : 
	 if($key == 'details'){
		continue;
	 }
	 if($i > 0 ) {
	 ?>
	 <label><input type="checkbox" value="<?php echo $i; ?>"<?php echo (isset($_COOKIE['sfk_cookie_columns_dashboard']) ? (in_array($i, explode(',', $_COOKIE['sfk_cookie_columns_dashboard'])) ? ' checked="checked"' : '') : ' checked="checked"'); ?> class="chkbox" /><?php echo $value; ?></label>&nbsp;
	<?php 
		
	}
	$i ++;
	endforeach; ?>
		<div class="chart_warning">
			<?php _e('Pie Charts cannot display more than one column'); ?>
		</div>
	</div>
	<div id="chart_div" style="width: 100%; height: 300px;"></div>
	<?php require_once('classes/class-wp-ajaxy-sft-list-table.php'); ?>
	<?php $list_table = new WP_SFT_List_Table($results, array_keys($columns)); 
		$list_table->dateFrom = $dateFrom;
		$list_table->dateTo = $dateTo;
	?>
	<div>
		<?php $list_table->display(); ?>
	</div>
	</div>
<?php
}
?>