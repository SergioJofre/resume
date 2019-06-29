<?php

//
//
//      Copyright (C) 2012 Paul Halliday <paul.halliday@gmail.com>
//
//      This program is free software: you can redistribute it and/or modify
//      it under the terms of the GNU General Public License as published by
//      the Free Software Foundation, either version 3 of the License, or
//      (at your option) any later version.
//
//      This program is distributed in the hope that it will be useful,
//      but WITHOUT ANY WARRANTY; without even the implied warranty of
//      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//      GNU General Public License for more details.
//
//      You should have received a copy of the GNU General Public License
//      along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
//

include_once '.inc/session.php';
include_once '.inc/config.php';
include_once '.inc/functions.php';
include_once '.inc/countries.php';

dbC();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<link rel="stylesheet" type="text/css" href=".css/resumen.css" />
<link rel="stylesheet" type="text/css" href=".css/cal.css" />
<link rel="stylesheet" type="text/css" href=".css/jquery-jvectormap-1.2.2.css" />
<link rel="stylesheet" type="text/css" href=".css/charts.css" />
<link rel="stylesheet" type="text/css" href=".css/spectrum.css" />
<!--<script type="text/javascript" src=".js/jq.js"></script>--> 
<script type="text/javascript" src=".js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src=".js/squertFunctions.js"></script>
<script type="text/javascript" src=".js/squertCal.js"></script>
<script type="text/javascript" src=".js/resumenMain.js"></script>
<script type="text/javascript" src=".js/squertBoxes.js"></script>
<script type="text/javascript" src=".js/squertCharts.js"></script>
<script type="text/javascript" src=".js/jquery-jvectormap-1.2.2.min.js"></script>
<script type="text/javascript" src=".js/jquery-jvectormap-world-mill-en.js"></script>
<script type="text/javascript" src=".js/d3/d3.min.js"></script>
<script type="text/javascript" src=".js/d3/sankey.js"></script>
<script type="text/javascript" src=".js/d3/packages.js"></script>
<script type="text/javascript" src=".js/spectrum.js"></script>

<title id=title>Resumen</title>
</head>
<body>
<div id=tab_group class=tab_group>
  
  <!--div id=t_inc class=tab>INCIDENTS</div-->
  <div id=t_ovr class=tab>SUMMARY</div>
 
  <div id=t_search class=search data-state=0>
    <div data-box=ret class="b_update icon"><img title=refresh class="il ilb" src=.css/update.png></div>
    <div class="icon_notifier"><img src=.css/exc.png></div>
    <div data-box=ret class=icon><img data-val=1 class=botog src=.css/layout1.png title="Show/Hide panes"></div>
    <div data-box=cat class=icon id=ico01><img title=comments class="il ilb" src=.css/comment.png></div>
    <div data-box=ac class=icon id=ico02><img title=autocat class="il ilb" src=.css/autocat.png></div>
    <div data-box=sen class=icon id=ico03><img title=sensors class="il ilb" src=.css/sensor.png></div>
    <div data-box=srch class=icon id=ico05><img title=lookup class="il ilb" src=.css/ext.png></div>
    <div data-box=fltr class=icon id=ico04><img title=filters class="il ilb" src=.css/filter.png></div>
    <input class=search id=search type=text size=40 maxlength=1000 placeholder=Filter /><div id=clear_search class=iconr><img title=clear class=il src=.css/delete.png></div>
  </div>
  <div id=cal></div>
  <div class=timeline>
    <div id=loader class=loader><img class=ldimg src=".css/load.gif"></div>
    <div class=t_pbar></div>
    <div class=t_stats></div>
  </div>
  <!--div class=db_links>
    <div class=db_linkt>view:</div>
    <div class=db_link data-val=ip data-state=1>IP</div>
    <div class=db_link data-val=sc>SOURCE COUNTRY</div>
    <div class=db_link data-val=dc>DESTINATION COUNTRY</div>
    <div class=db_linkt>type:</div>
    <div class=db_type data-type=cl>CLUSTER LAYOUT</div>
    <div class=db_type data-type=eb>EDGE BUNDLING</div>
    <div class=db_type data-type=hp>HIVE PLOT</div>
    <div class=db_type data-type=sk data-state=1>SANKEY DIAGRAM</div>
    <div class=db_save><span class=links>save as svg</span></div>
  </div-->
</div>
<div class=lr>

</div>

  
  <div class=rl>
    <div id=t_view_content class=content>
      <div id=db_help class="hide label100">This view shows source and destination connections. The width of each ribbon indicates the volume of events. If a source and destination are linked with a red line then an event has occured in both directions (A -> B, B -> A). When no filters are present and only a single event exists, lone hosts that are associated with other lone hosts are not shown. Nodes can be repositioned by clicking on the desired node and then dragging it to a new position. IPs can be added as filters by double clicking their label. When you are on this page and a filter is in place the 'enter' key will take you to the events. To recreate the view (with the filter) click the update link.</div>
      <div class=db_view></div> 
    </div>
    <div id=t_inc_content class=content>&nbsp;Not broken, just not done.</div>
    <div id=t_ovr_content class=content>
      <br>     
      <div class=twopane>
        <div class=ovbl>TOP SIGNATURES</div><div id=ovestat class=ovstat></div><div class=ovbi id=ov_signature_msg></div><div class=ovsl id=ov_signature_sl></div>
        <div id=ov_signature></div>
      </div>
   <div class=twopane>
        <div class=ovbl>TOP SOURCE IPS</div><div class=ovbi id=ov_srcip_msg></div><div class=ovsl id=ov_srcip_sl></div>
          <div id=ov_srcip></div>
      </div>
      <div class=twopane>
          <div class=ovbl>TOP DESTINATION IPS</div><div class=ovbi id=ov_dstip_msg></div><div class=ovsl id=ov_dstip_sl></div>
          <div id=ov_dstip></div>
        
      </div>
      <div class=twopane>
        
          <div class=ovbl>TOP SOURCE COUNTRIES</div><div class=ovbi id=ov_srccc_msg></div><div class=ovsl id=ov_srccc_sl></div>
          <div id=ov_srccc></div>
        
      </div>
<div class=twopane>
       
         
          <div class=ovbl>TOP DESTINATION COUNTRIES</div><div class=ovbi id=ov_dstcc_msg></div><div class=ovsl id=ov_dstcc_sl></div>
          <div id=ov_dstcc></div>
        
      </div>
      <div class=twopane>
        
          <div class=ovbl>TOP SOURCE PORTS</div><div class=ovbi id=ov_srcpt_msg></div><div class=ovsl id=ov_srcpt_sl></div>
          <div id=ov_srcpt></div>
        
         
          <div class=ovbl>TOP DESTINATION PORTS</div><div class=ovbi id=ov_dstpt_msg></div><div class=ovsl id=ov_dstpt_sl></div>
          <div id=ov_dstpt></div>
        
      </div>
      <div class=onepane>
        <div class=ovbl>GEOGRAPHIC DISTRIBUTION</div><div id=ovmapstat class=ovstat></div><div class=ovbi id=ov_map_msg></div><div class=ovsl id=ov_map_sl></div>
        <div id=ov_map></div>
      </div>
    </div>
  </div>
</div>

<div class=box id=cat_box>
  <div class=cat_top>
    <div class=box_label id=cat_box_label>COMMENTS</div>
    <div title="close" class="box_close" data-box=cat><img class=il src=.css/close.png></div>
    <div title=refresh class=cat_refresh><img class=il src=.css/reload.png></div>
    <div id=ovcstat class="box_stat"></div>
  </div>
  <div class=cm_controls>
    <div class=cat_l1>COMMENT:</div>
    <div class=cat_r1><input class=cat_msg_txt type=text maxlength=255 placeholder=Comment /></div>
    <div class=cat_l1>CLASSIFICATION:</div>
    <div class=cat_r1 id=cw_buttons>
      <div class=b_C1 data-n=11>C1</div>
      <div class=b_C2 data-n=12>C2</div>
      <div class=b_C3 data-n=13>C3</div>
      <div class=b_C4 data-n=14>C4</div>
      <div class=b_C5 data-n=15>C5</div>
      <div class=b_C6 data-n=16>C6</div>
      <div class=b_C7 data-n=17>C7</div>
      <div class=b_NA data-n=1>NA</div>
      <div class=b_ES data-n=2>ES</div>
      <!-- Will require a mod to sguil (DeleteEventIDList) -->
      <!--&nbsp;&nbsp;<span class=links data-n=0>apply comment only</span>-->
    </div>
    <div class=cat_note>&nbsp;&nbsp;<b>Note:</b> you can click a comment below to reuse it (followed by a classification action) <b>or</b> click on the "F" icon followed by "enter" to use as a filter<br></div>
 
  </div>
  <div class=cm_tbl></div>
</div>

<div class=box id=sen_box>
  <div class=sen_top>
    <div class=box_label>SENSORS</div>
    <div title="close" class="box_close" data-box=sen><img class=il src=.css/close.png></div> 
  </div>
  <div class=sen_controls></div>
  <div class=sen_tbl></div>
</div>

<div class=box id=fltr_box>
  <div class=fltr_top>
    <div class=box_label>FILTERS and URLs</div>
    <div title="close" class="box_close" data-box=fltr><img class=il src=.css/close.png></div>
    <div title=add class=filter_new><img class=il src=.css/add.png></div>
    <div title=refresh class=filter_refresh><img class=il src=.css/reload.png></div>
    <div title=help class=filter_help><img class=il src=.css/help.png></div>
  </div>
  <div class=hp_links>
    <div class=hp_typet>type:</div>
    <div class="hp_type hp_type_active" data-val=filter>FILTER</div>
    <div class=hp_type data-val=url>URL</div>
  </div>
  <div class=fltr_tbl></div>
</div>

<div class=box id=ac_box>
  <div class=ac_top>
    <div class=box_label>AUTOCAT</div>
    <div title="close" class="box_close" data-box=ac><img class=il src=.css/close.png></div>
    <div title=add class=ac_new><img class=il src=.css/add.png></div>
    <div title=refresh class=ac_refresh><img class=il src=.css/reload.png></div>
    <div title=help class=ac_help><img class=il src=.css/help.png></div>
    <div id=ovacstat class="box_stat hide"></div>
  </div>
  <div class=ac_tbl></div>
</div>

<div class=box id=srch_box>
  <div class=srch_top>
    <div class=box_label id=srch_box_label>EXTERNAL LOOKUP</div>
    <div title="close" class="box_close" data-box=srch><img class=il src=.css/close.png></div>
    <div id=srch_stat_msg class="box_stat hide"></div> 
  </div>
  <div class=lu_links>
    <div class=lu_typet>type:</div>
    <div class="lu_type lu_type_active" data-val=esc>ELASTICSEARCH</div>
    <div class=lu_type data-val=url>URL</div>
  </div>
  <div class=srch_controls>
    <div class=cat_l1>QUERY:</div>
    <div class=cat_r1><input class=srch_txt type=text maxlength=1000 value="*"></div>
    <div class=clear_srch><img title=clear class=il src=.css/delete.png></div>
    <div class=cat_l1>TERMS:</div>
    <div class=cat_r1 id=srchterms></div>
    <div id=el_tdc>
      <div class=cat_l1>INTERVAL:</div>
      <div class=cat_r1 id=srchint>
        <input id=el_start class=el_ts type=text maxlength=19>
        &nbsp;&nbsp;-&gt; &nbsp;&nbsp;
        <input id=el_end class=el_ts type=text maxlength=19>
      </div>
      <div id=el_reset class=dt_b>reset</div>
      <div class=cat_row>
        <div class=cat_l1>
          <div class=srch_do><img title=search class=il src=.css/search.png></div>
        </div>
        <div class=cat_r1 id=srchsrc>
          <b>no</b> sources are selected
        </div>
      </div>
    </div>
  </div>
  <div class=srch_tbl></div>
</div>

<div class=pickbox>
  <div class=srch_top>
    <div class=box_label_pb id=pickbox_label></div>
    <div title="close" class="pickbox_close"><img class=il src=.css/close.png></div>
  </div>
  <div class=pickbox_tbl></div>
</div>

<div class=tagbox>
  <input type=text class=taginput maxlength=50 width=200>
  <span class=tagok>ADD</span>
  <span class=tagcancel>CANCEL</span>
  <span class=spacer>|</span>
  <span class=tagrm>REMOVE</span>
</div>

<div class=bottom>
  <div id=t_usr class=user data-c_usr=<?php echo $sUser;?>>WELCOME&nbsp;&nbsp;<b><?php echo $sUser;?></b>&nbsp;&nbsp;|<span id=logout class=logout>LOGOUT</span></div>
  <div class=b_tray></div>
  <div class=b_class><span class=class_msg></span>&nbsp;</div>
  <div class=b_clock id=b_utc><span class=clock_lbl>UTC</span> <span id=clock_utc>00:00:00</span></div>
  <div class=b_clock id=b_local><span class=clock_lbl>LOCAL</span> <span id=clock_local>00:00:00</span></div>
  </div>  
</div>

<input id=event_sort type=hidden value="DESC">
<input id=event_sum type=hidden value="0">
<input id=cat_sum type=hidden value="0">
<input id=user_tz type=hidden value="<?php echo $_SESSION['tzoffset'];?>">
<input id=sel_tab type=hidden value="<?php echo $_SESSION['sTab'];?>">

</body>
</html>
