<?php

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
<script type="text/javascript" src=".js/jq.js"></script>
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
  <div id=t_sum class=tab>EVENTOS</div>
  <div id=t_ovr class=tab>RESUMEN</div> 
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
  <div class=db_links>
    <div class=db_linkt>vistas</div>
    <div class=db_link data-val=ip data-state=1>IP</div>
    <div class=db_link data-val=sc>PAIS DE ORIGEN</div>
    <div class=db_link data-val=dc>pAIS DE DESTINO</div>
    <div class=db_linkt>type:</div>
    <div class=db_type data-type=sk data-state=1>SANKEY DIAGRAM</div>
  </div>
</div>

<div class=lr>
  <div class=content-left>
    <div class=event_cont>
      <div class=label_l><span class=ec_label>TOGGLE</span><div class=label_m><img data-sec=t title=collapse class="il st" src=.css/uarr.png></div></div>
      <div class=secl id=sec_t>
        <div class=label>solo filas</div><div id=rt class=tvalue_on>on</div>
        <div class=label>agrupaciones</div><div id=gr class=tvalue_on>on</div>
      </div>
    </div>

    <div class=event_cont>
      <div class=label_l><span class=ec_label>RESUMEN</span><div class=label_m><img data-sec=s title=collapse class="il st" src=.css/uarr.png></div></div>
      <div class=secl id=sec_s>  
        <div class=label>eventos en cola</div><div id=qtotal class=value>-</div>
        <div class=label>total de eventos</div><div id=etotal class=value>-</div>
        <div class=label>total de firmas</div><div id=esignature class=value>-</div>
        <!--div class=label>total sources</div><div id=esrc class=value>-</div-->
        <!--div class=label>total destinations</div><div id=edst class=value>-</div-->
      </div>
    </div>

    <div class=event_cont>
      <div class=label_l><span class=ec_label>PRIORIDAD</span><div class=label_m><img data-sec=p title=collapse class="il st" src=.css/uarr.png></div></div>
      <div class=secl id=sec_p>
        <div class=label>alta</div><div id=pr_1 class=value>-</div>
        <div class=label>mediana</div><div id=pr_2 class=value>-</div>
        <div class=label>baja</div><div id=pr_3 class=value>-</div>
        <div class=label>otra</div><div id=pr_4 class=value>-</div>
      </div>
    </div>

    <div class=event_cont>
      <div class=label_l><span class=ec_label>CLASIFICACION</span><div class=label_m><img data-sec=c title=collapse class="il st" src=.css/uarr.png></div></div>
      <div class=secl id=sec_c>  

        <div id=b_class-11 class=label_c data-c=11 data-cn=C1 title='compromised L1 (F1)'>
        <div class=b_C1></div>En peligro L1</div><div data-type=st id=c-11 class="ecv value_link">-</div>

        <div id=b_class-12 class=label_c data-c=12 data-cn=C2 title='compromised L2 (F2)'>
        <div class=b_C2></div>En peligro L2</div><div data-type=st id=c-12 class="ecv value_link">-</div>
      
        <div id=b_class-13 class=label_c data-c=13 data-cn=C3 title='attempted unauthorized access (F3)'>
        <div class=b_C3></div>intentos de acceso</div><div data-type=st id=c-13 class="ecv value_link">-</div>

        <div id=b_class-14 class=label_c data-c=14 data-cn=C4 title='denial of service attack (F4)'>
        <div class=b_C4></div>denegacion de servicios</div><div data-type=st id=c-14 class="ecv value_link">-</div>
      
        <div id=b_class-15 class=label_c data-c=15 data-cn=C5 title='policy violation (F5)'>
        <div class=b_C5></div>violaciones de politica</div><div data-type=st id=c-15 class="ecv value_link">-</div>

        <div id=b_class-16 class=label_c data-c=16 data-cn=C6 title='reconnaissance (F6)'>
        <div class=b_C6></div>reconocimiento</div><div data-type=st id=c-16 class="ecv value_link">-</div>
      
        <div id=b_class-17 class=label_c data-c=17 data-cn=C7 title='malicious (F7)'>
        <div class=b_C7></div>malicious</div><div data-type=st id=c-17 class="ecv value_link">-</div>

        <div id=b_class-1 class=label_c data-c=1 data-cn=NA title='no further action required (F8)'>
        <div class=b_NA></div>no action req&#x2019;d.</div><div data-type=st id=c-1 class="ecv value_link">-</div>
      
        <div id=b_class-2 class=label_c data-c=2 data-cn=ES title='escalate event (F9)'>
        <div class=b_ES></div>eventos de escalamiento</div><div data-type=st id=c-2 class="ecv value_link">-</div>

      </div>
    </div>

    <div class=event_cont>
      <div class=label_l><span class=ec_label>ETIQUETAS</span>
        <div class=label_m><img data-sec=tg title=collapse class="il st" src=.css/uarr.png></div>  
      </div>
      <div class=secl id=sec_tg>
        <div id=tg_box class=tg_box>
          <div class=tag_empty>sin etiquetas</div>
        </div>
      </div>
    </div>

    <div class=event_cont>
      <div class=label_l><span class=ec_label>HISTORIAL</span>
        <div class=label_m><img data-sec=h title=collapse class="il st" src=.css/uarr.png></div>  
      </div>
      <div class=secl id=sec_h>
        <div id=h_box class=h_box>
          <div class=history_empty>sin historial</div>
        </div>
      </div>
    </div>
  </div>
  
  <div class=content-right>
    <div id=t_sum_content class=content>
      <div id=aaa-00 class=aaa><div class=times></div></div>
    </div>
  </div>

  <div class=rl>
    <div id=t_inc_content class=content>&nbsp;Not broken, just not done.</div>
    <div id=t_ovr_content class=content>
      <br>     
      <div class=onepane>
        <div class=ovbl>TOP FIRMAS</div><div id=ovestat class=ovstat></div><div class=ovbi id=ov_signature_msg></div><div class=ovsl id=ov_signature_sl></div>
        <div id=ov_signature></div>
      </div>
      <div class=twopane>
        <div class=leftpane>
          <div class=ovbl>TOP IPS ORIGEN</div><div class=ovbi id=ov_srcip_msg></div><div class=ovsl id=ov_srcip_sl></div>
          <div id=ov_srcip></div>
        </div>
        <div class=rightpane> 
          <div class=ovbl>TOP IPS DESTINO</div><div class=ovbi id=ov_dstip_msg></div><div class=ovsl id=ov_dstip_sl></div>
          <div id=ov_dstip></div>
        </div>
      </div>
      <div class=twopane>
        <div class=leftpane>
          <div class=ovbl>TOP PAISES ORIGEN</div><div class=ovbi id=ov_srccc_msg></div><div class=ovsl id=ov_srccc_sl></div>
          <div id=ov_srccc></div>
        </div>
        <div class=rightpane> 
          <div class=ovbl>TOP PAISES DESTINO</div><div class=ovbi id=ov_dstcc_msg></div><div class=ovsl id=ov_dstcc_sl></div>
          <div id=ov_dstcc></div>
        </div>
      </div>
      <div class=twopane>
        <div class=leftpane>
          <div class=ovbl>TOP PUERTOS ORIGEN</div><div class=ovbi id=ov_srcpt_msg></div><div class=ovsl id=ov_srcpt_sl></div>
          <div id=ov_srcpt></div>
        </div>
        <div class=rightpane> 
          <div class=ovbl>TOP PUERTOS DESTINO</div><div class=ovbi id=ov_dstpt_msg></div><div class=ovsl id=ov_dstpt_sl></div>
          <div id=ov_dstpt></div>
        </div>
      </div>
      <div class=onepane>
        <div class=ovbl>UBICACION GEOGRAFICA</div><div id=ovmapstat class=ovstat></div><div class=ovbi id=ov_map_msg></div><div class=ovsl id=ov_map_sl></div>
        <div id=ov_map></div>
      </div>
    </div>
  </div>
</div>

<div class=box id=cat_box>
  <div class=cat_top>
    <div class=box_label id=cat_box_label>COMENTARIOS</div>
    <div title="close" class="box_close" data-box=cat><img class=il src=.css/close.png></div>
    <div title=refresh class=cat_refresh><img class=il src=.css/reload.png></div>
    <div id=ovcstat class="box_stat"></div>
  </div>
  <div class=cm_controls>
    <div class=cat_l1>COMENTARIOS:</div>
    <div class=cat_r1><input class=cat_msg_txt type=text maxlength=255 placeholder=Comment /></div>
    <div class=cat_l1>CLASIFICACION:</div>
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
    <div class=cat_note>&nbsp;&nbsp;<b>Note:</b> puede hacer clic e un comentario (a continuacion para reutilizarlo) <b>o</b> hcer clic en el icono "F" seguido de enter para usar como filtro<br></div>
 
  </div>
  <div class=cm_tbl></div>
</div>

<div class=box id=sen_box>
  <div class=sen_top>
    <div class=box_label>SENNSORES</div>
    <div title="close" class="box_close" data-box=sen><img class=il src=.css/close.png></div> 
  </div>
  <div class=sen_controls></div>
  <div class=sen_tbl></div>
</div>

<div class=box id=fltr_box>
  <div class=fltr_top>
    <div class=box_label>FILTROS Y URLs</div>
    <div title="close" class="box_close" data-box=fltr><img class=il src=.css/close.png></div>
    <div title=add class=filter_new><img class=il src=.css/add.png></div>
    <div title=refresh class=filter_refresh><img class=il src=.css/reload.png></div>
    <div title=help class=filter_help><img class=il src=.css/help.png></div>
  </div>
  <div class=hp_links>
    <div class=hp_typet>tipo:</div>
    <div class="hp_type hp_type_active" data-val=filter>FILTRO</div>
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
    <div class=box_label id=srch_box_label>BUSQUEDA EXTERNA</div>
    <div title="close" class="box_close" data-box=srch><img class=il src=.css/close.png></div>
    <div id=srch_stat_msg class="box_stat hide"></div> 
  </div>
  <div class=lu_links>
    <div class=lu_typet>tipo:</div>
    <div class="lu_type lu_type_active" data-val=esc>ELASTICSEARCH</div>
    <div class=lu_type data-val=url>URL</div>
  </div>
  <div class=srch_controls>
    <div class=cat_l1>QUERY:</div>
    <div class=cat_r1><input class=srch_txt type=text maxlength=1000 value="*"></div>
    <div class=clear_srch><img title=clear class=il src=.css/delete.png></div>
    <div class=cat_l1>TERMINOS:</div>
    <div class=cat_r1 id=srchterms></div>
    <div id=el_tdc>
      <div class=cat_l1>INTERVALO:</div>
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
          <b>no</b> origenes seleccionados
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
  <span class=tagok>AGREGAR</span>
  <span class=tagcancel>CANCELAR</span>
  <span class=spacer>|</span>
  <span class=tagrm>REMOVER</span>
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