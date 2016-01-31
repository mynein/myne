var chart = null;
var sdata = new Array();
var options = {
	legend:{position: 'in', alignment:'end', textStyle: {color: 'blue', fontSize: 13}},
	left:0,
	titlePosition:'out',
	hAxis: {textPosition: 'out'}, vAxis: {textPosition: 'out'},
	title: 'Keyword Search',
	lineWidth:2,
	pointSize:6,
	textStyle: {color: '#333', fontSize:'11'},
	hAxis: {textStyle: {color: '#333', fontSize:'11'}, title: 'Date',  titleTextStyle: {italic: false,color: '#333', fontSize:'12'}, gridlines : {color:'#eee'}},
	vAxis: {textStyle: {color: '#333', fontSize:'11'}, title: 'Hits',  titleTextStyle: {italic: false,color: '#333', fontSize:'12'}, gridlines : {color:'#eee'}},
	chartArea: {
		left: 50,
		right: 20,
		top: 10,
		height: '80%',
		width: '99%'
	}
};
jQuery(document).ready(function(){
	jQuery('.head-sort').click(function(){
		var sort = jQuery(this).attr('href').split('|');
		sortTableByColumn(sort[0].replace('#', ''), 'wp-list-table', sort[1], sort[2]);
		var new_sort = (sort[2] == "desc" ? "asc" : "desc");
		jQuery(this).attr('href', sort[0] + "|" + sort[1] + "|" + new_sort);
		jQuery(this).parent().attr('class', jQuery(this).parent().attr('class').replace(sort[2], new_sort));
	});
	jQuery('#chart_columns .chkbox').click(
		function() { toggleColumns(); }
	);
	jQuery('#chartType').change(
		function() { 
			chartType = jQuery(jQuery(this).find("option:selected")).val();
			drawChart(); 
			sfkSetCookie('sfk_cookie_charts_' + sfk_tab, chartType, 30);
		}
	);
});

var column_name = "";
var sort_type = "asc";
function sortTableByColumn(column, table, sort_int_string, sort_stype) {
	column_name = column;
	sort_type = sort_stype;
	var table_rows = jQuery("." + table + " tbody tr");
	if(table_rows.length == 0) {
		return false;
	}
	if(sort_int_string == "int") {
		table_rows.sort(sortTable);
	}
	else{
		table_rows.sort(sortTableString);
	}
	jQuery("." + table + " tbody tr").remove();
	for(var j =0; j < table_rows.length; j ++) {
		jQuery("." + table + " tbody").append(table_rows[j]);
	}
	return false;
}
function sortTable(a, b){
	var x = parseInt(jQuery(a).find("." + column_name + ' span.sort').html(), 10);
	var y = parseInt(jQuery(b).find("." + column_name + ' span.sort').html(), 10);
	if(sort_type == 'desc') {
		if(x > y) {
			return -1;
		}
		else if(x == y){
			return 0;
		}
		else{
			return 1;
		}
	}
	else{
		if(x > y) {
			return 1;
		}
		else if(x == y){
			return 0;
		}
		else{
			return -1;
		}
	}
}function sortTableString(a, b){
	var x = jQuery(a).find("." + column_name + ' span.sort').html();
	var y = jQuery(b).find("." + column_name + ' span.sort').html();
	if(sort_type == 'desc') {
		if(x > y) {
			return -1;
		}
		else if(x == y){
			return 0;
		}
		else{
			return 1;
		}
	}
	else{
		if(x > y) {
			return 1;
		}
		else if(x == y){
			return 0;
		}
		else{
			return -1;
		}
	}
}
function drawDefaultChart() {
	sdata = mdata;
	toggleColumns();
	drawChart();
}
function drawChart() {
	data = google.visualization.arrayToDataTable(sdata);
	if(chartType == '' || chartType == 'AreaChart') {
		chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
		
	}if(chartType == 'BubbleChart') {
		chart = new google.visualization.BubbleChart(document.getElementById('chart_div'));
		
	}if(chartType == 'BarChart') {
		chart = new google.visualization.BarChart(document.getElementById('chart_div'));
		
	}if(chartType == 'CandlestickChart') {
		chart = new google.visualization.CandlestickChart(document.getElementById('chart_div'));
		
	}if(chartType == 'ColumnChart') {
		chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
		
	}if(chartType == 'ComboChart') {
		chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
		
	}if(chartType == 'LineChart') {
		chart = new google.visualization.LineChart(document.getElementById('chart_div'));
		
	}if(chartType == 'PieChart') {
		chart = new google.visualization.PieChart(document.getElementById('chart_div'));
		
	}if(chartType == 'SteppedAreaChart') {
		chart = new google.visualization.SteppedAreaChart(document.getElementById('chart_div'));
		
	}
	chart.draw(data, options);
}
function toggleColumns() {
	var schecked = [];
	schecked[0] = "0";
	jQuery('#chart_columns .chkbox:checked').each(function() {
		schecked[schecked.length] = jQuery(this).val();
		
	});
	sfkSetCookie('sfk_cookie_columns_' + sfk_tab, schecked.join(','), 30);
	var cdata = [];
	for(var i = 0; i < mdata.length; i ++){
		cdata[i] = new Array();
		for(var j = 0; j < mdata[i].length; j ++){
			if(jQuery.inArray(j + "", schecked) >= 0){
				cdata[i][cdata[i].length] = mdata[i][j];
			}
		}
	}
	sdata = cdata;
	drawChart();
}
function sfkSetCookie(c_name ,value ,exdays)
{
	try {
		var exdate=new Date();
		exdate.setDate(exdate.getDate() + exdays);
		var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
		document.cookie = c_name + "=" + c_value;
	}catch(e){
	}
}
function sfkGetCookie(c_name)
{
	try{
		var c_value = document.cookie;
		var c_start = c_value.indexOf(" " + c_name + "=");
		if (c_start == -1)
		{
			c_start = c_value.indexOf(c_name + "=");
		}
		if (c_start == -1)
		{
			c_value = null;
		}
		else
		{
			c_start = c_value.indexOf("=", c_start) + 1;
			var c_end = c_value.indexOf(";", c_start);
			if (c_end == -1)
			{
				c_end = c_value.length;
			}
			c_value = unescape(c_value.substring(c_start,c_end));
		}
		return c_value;
	}catch(e){
		return null;
	}
}