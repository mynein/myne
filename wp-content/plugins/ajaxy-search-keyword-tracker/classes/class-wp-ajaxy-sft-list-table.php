<?php
/**
 * List Table class.
 *
 * @package WordPress
 * @subpackage List_Table
 * @since 3.1.0
 * @access private
 */
 
class WP_SFT_List_Table extends WP_List_Table {

	var $callback_args;
	var $results = null;
	var $scolumns = array();
	
	public $dateFrom = false;
	public $dateTo = false;

	function WP_SFT_List_Table($results, $columns) {
		$this->results = $results;
		$this->scolumns = $columns;
		parent::__construct( array(
			'plural' => 'Tracker',
			'singular' => 'Tracker',
		) );
	}

	function ajax_user_can() {
		return true;
	}

	function prepare_items() {
		$trackingManager = new AjaxyTracker();
		$fields = $trackingManager->get_all_fields();

		$search = !empty( $_REQUEST['s'] ) ? trim( stripslashes( $_REQUEST['s'] ) ) : '';

		$args = array(
			'search' => $search,
			'page' => $this->get_pagenum(),
			'number' => $tags_per_page,
		);

		if ( !empty( $_REQUEST['orderby'] ) )
			$args['orderby'] = trim( stripslashes( $_REQUEST['orderby'] ) );

		if ( !empty( $_REQUEST['order'] ) )
			$args['order'] = trim( stripslashes( $_REQUEST['order'] ) );

		$this->callback_args = $args;

		$this->set_pagination_args( array(
			'total_items' => sizeof($fields),
			'per_page' => 10,
		) );
	}

	function has_items() {
		// todo: populate $this->items in prepare_items()
		return true;
	}

	function get_bulk_actions() {
		$actions = array();
		//$actions['hide'] = __( 'Hide from results' );
		//$actions['show'] = __( 'Show in results' );

		return $actions;
	}

	function current_action() {
		if ( isset( $_REQUEST['action'] ) && ( 'hide' == $_REQUEST['action'] || 'hide' == $_REQUEST['action2'] ) )
			return 'bulk-hide';

		return parent::current_action();
	}

	function get_columns() {
		$columns = array(
			'cb'          => '<input type="checkbox" />',
			'keyword'    => __( 'Keyword' ),
			'details'    => __( 'Details' ),
			'total'        => __( 'Total' ),
			'average_total_results'        => __( 'Average Results<span class="hint">Average results for this keyword</span>' ),
			'date'        => __( 'Date' ),
			'total_results'        => __( 'Total Results<span class="hint">Total search results</span>' ),
			'time'=> __( 'Date/Time' ),
			'htime'=> __( 'Time<span class="hint"></span>' ),
			'url' => __( 'Url' ),
			'count_search' => __( 'Search <span class="hint">total keywords search</span>' ),
			'count_unique' => __( 'Unique Search <span class="hint">total unique keywords search</span>' ),
			'count_zero' => __( 'Keywords with zero results<span class="hint">Keywords with zero or no results</span>' ),
			'count_zero_time' => __( 'Keywords with zero results<span class="hint">Keywords with zero or no results</span>' ),
			'count_kzero' => __( 'Total search<span class="hint">Count searches for a specific keyword</span>' ),
		);
		$mcolumns = array();
		foreach($this->scolumns as $value){
			if(isset($columns[$value])) {
				$mcolumns[$value] = $columns[$value];
			}
		}
		return $mcolumns;
	}
	function get_column_info() {
		if ( isset( $this->_column_headers ) )
			return $this->_column_headers;

		$screen = get_current_screen();

		$columns = $this->get_columns();
		$hidden = array();

		$this->_column_headers = array( $columns, $hidden, $this->get_sortable_columns() );
		return $this->_column_headers;
	}
	
	/**
	 * Print column headers, accounting for hidden and sortable columns.
	 *
	 * @since 3.1.0
	 * @access protected
	 *
	 * @param bool $with_id Whether to set the id attribute or not
	 */
	function print_column_headers( $with_id = true ) {
		$screen = get_current_screen();

		list( $columns, $hidden, $sortable ) = $this->get_column_info();

		$current_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$current_url = remove_query_arg( 'paged', $current_url );

		if ( isset( $_GET['orderby'] ) )
			$current_orderby = $_GET['orderby'];
		else
			$current_orderby = '';

		if ( isset( $_GET['order'] ) && 'desc' == $_GET['order'] )
			$current_order = 'desc';
		else
			$current_order = 'asc';

		foreach ( $columns as $column_key => $column_display_name ) {
			$class = array( 'manage-column', "column-$column_key" );

			$style = '';
			if ( in_array( $column_key, $hidden ) )
				$style = 'display:none;';

			$style = ' style="' . $style . '"';

			if ( 'cb' == $column_key )
				$class[] = 'check-column';
			elseif ( in_array( $column_key, array( 'posts', 'comments', 'links' ) ) )
				$class[] = 'num';

			if ( isset( $sortable[$column_key] ) ) {
				list( $orderby, $desc_first ) = $sortable[$column_key];

				if ( $current_orderby == $orderby ) {
					$order = 'asc' == $current_order ? 'desc' : 'asc';
					$class[] = 'sorted';
					$class[] = $current_order;
				} else {
					$order = $desc_first ? 'desc' : 'asc';
					$class[] = 'sortable';
					$class[] = $desc_first ? 'asc' : 'desc';
				}
				$column_ssort = "int";
				if(in_array($column_key, array('date', 'keyword', 'time', 'htime'))){
					$column_ssort = "string";
				}
				$column_display_name = '<a href="#column-'.$column_key.'|'.$column_ssort.'|'.$order.'" class="head-sort"><span>' . $column_display_name . '</span><span class="sorting-indicator"></span></a>';
			}

			$id = $with_id ? "id='$column_key'" : '';

			if ( !empty( $class ) )
				$class = "class='" . join( ' ', $class ) . "'";

			echo "<th scope='col' $id $class $style>$column_display_name</th>";
		}
	}
	function get_sortable_columns() {
		$columns = array(
			'cb'          => '<input type="checkbox" />',
			'keyword'    => __( 'Keyword' ),
			'details'    => __( 'Details' ),
			'total'        => __( 'Total' ),
			'average_total_results'        => __( 'Average Results<span class="hint">Average results for this keyword</span>' ),
			'date'        => __( 'Date' ),
			'total_results'        => __( 'Total Results<span class="hint">Total search results</span>' ),
			'time'=> __( 'Date/Time' ),
			'htime'=> __( 'Time<span class="hint"></span>' ),
			'url' => __( 'Url' ),
			'count_search' => __( 'Search <span class="hint">total keywords search</span>' ),
			'count_unique' => __( 'Unique Search <span class="hint">total unique keywords search</span>' ),
			'count_zero' => __( 'Keywords with zero results<span class="hint">Keywords with zero or no results</span>' ),
			'count_zero_time' => __( 'Keywords with zero results<span class="hint">Keywords with zero or no results</span>' ),
			'count_kzero' => __( 'Total search<span class="hint">Count searches for a specific keyword</span>' ),
		);
		$mcolumns = array();
		foreach($this->scolumns as $value){
			if(isset($columns[$value])) {
				$mcolumns[$value] = $columns[$value];
			}
		}
		return $mcolumns;
	}

	function display_rows_or_placeholder() {
		$fields = $this->results;
		$args = wp_parse_args( $this->callback_args, array(
			'page' => 1,
			'number' => 20,
			'search' => '',
			'hide_empty' => 0
		) );

		extract( $args, EXTR_SKIP );

		$args['offset'] = $offset = ( $page - 1 ) * $number;

		// convert it to table rows
		$out = '';
		$count = 0;
		$orderby = 'order';
		$order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc','desc')) ? $_REQUEST['order']: 'asc');
		if(!empty($fields)){
			foreach($fields as $row){
				$this->single_row($row);
			}
		}
		if ( empty( $fields ) ) {
			list( $columns, $hidden ) = $this->get_column_info();
			echo '<tr class="no-items"><td class="colspanchange" colspan="' . $this->get_column_count() . '">';
			$this->no_items();
			echo '</td></tr>';
		} else {
			echo $out;
		}
	}

	function single_row( $field, $level = 0 ) {
		static $row_class = '';
		$add_class = '';
		$row_class = ( $row_class == '' ? ' class="alternate '.$add_class.'"' : ' class="'.$add_class.'"' );
		
		echo '<tr ' . $row_class . '>';
		echo $this->single_row_columns( $field );
		echo '</tr>';
	}

	function column_cb( $field ) {
		return '<input type="checkbox" name="template_id[]" value="'.$field->id.'" />';
	}
	function column_default( $field, $column_name ) {
		return '<span class="sort">'.($field->{$column_name} == '' ? 0 : $field->{$column_name}).'</span>';
	}
	function column_details( $field ) {
		$m = explode(',', $field->details);
		$counts = array_count_values ($m);
		$s = array();
		$l = 0;
		foreach($counts as $key => $value) {
			$l += $value;
			$s[] = '<b>'.$value.'</b> ('.$this->label_key($key).')';
		}
		return implode(', ', $s).'<span class="sort" style="display:none">'.$l.'</span>';
	}
	function label_key($key) {
		$labels = array('s' => _('Search'), 'ls'=> _('Live Search'));
		if(in_array($key,array_keys($labels))){
			return $labels[$key];
		}
		return $key;
	}
	function column_count_zero( $field) {
		$dateFrom = (isset($field->date) ? $field->date : $this->dateFrom);
		$dateTo = (isset($field->date) ? $field->date : $this->dateTo);
		return ($field->count_zero == '' ? '<span class="sort">0</span>' : '<span class="sort">'.$field->count_zero.'</span><a href="'.menu_page_url('ajaxy_sft_admin', false).'&tab=&dateFrom='.$dateFrom.'&dateTo='.$dateTo.'&keyword_count=0'.(isset($field->keyword) ? '&keyword='.urlencode($field->keyword) :'').'"> - <i>('._('View details').')</i></a>');
	}
	function column_count_zero_time( $field) {
	$time = explode(' - ', $field->htime);
	$from = explode( ':', $time[0]);
	$to = explode( ':', $time[1]);
		$timeFromHour = $from[0];
		$timeToHour = $to[0];
		$timeFromMinute = $from[1];
		$timeToMinute = $to[1];
		$timeSpan = $timeToMinute - $timeFromMinute >= 0 ? $timeToMinute - $timeFromMinute : ($timeToMinute + 60) - $timeFromMinute;
		$timeSpan += abs($timeFromHour - $timeToHour) > 0 ? abs($timeFromHour - $timeToHour)*60 : 0;
		return ($field->count_zero_time == '' ? '<span class="sort">0</span>' : '<span class="sort">'.$field->count_zero_time.'</span><a href="'.menu_page_url('ajaxy_sft_admin', false).'&tab=time&dateFrom='.$this->dateFrom.'&dateTo='.$this->dateTo.'&timeFromHour='.$timeFromHour.'&timeToHour='.$timeToHour.'&timeFromMinute='.$timeFromMinute.'&timeToMinute='.$timeToMinute.'&timeSpan='.$timeSpan.'&keyword_count=0&time=1"> - <i>('._('View details').')</i></a>');
	}

	/**
	 * Outputs the hidden row displayed when inline editing
	 *
	 * @since 3.1.0
	 */
	function inline_edit() {
	}
}

?>
