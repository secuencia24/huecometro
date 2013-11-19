<?php
session_start();
require("controlador/ctr_huecometro.php");
$idusuario=$_SESSION['idusuario'];
if($idusuario==""){
	header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8" />
<meta name="description" content="Productos qimicos">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Huecometro</title>
<link href="css/estilos.css" rel="stylesheet" type="text/css">
<link href="css/navMenu.css" rel="stylesheet" type="text/css">
<link href="css/dcdrilldown.css" rel="stylesheet" type="text/css" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/tsc_datagrid.css" />
<link rel="stylesheet" href="css/cmsblast24.css" />
<link type="text/css" rel="stylesheet" href="css/menuflip.css"></link> 
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/tsc_datagrid.js"></script>
<script type="text/javascript" src="Scripts/AC_RunActiveContent.js" ></script>
<script type="text/javascript" src="Scripts/jquery.js"></script>
<script type="text/javascript" src="Scripts/jquery.lightbox.js"></script>
<script type="text/javascript" src="Scripts/jquery.pngFix.js"></script>
<!-- fin DataGrid -->
<!--Google Analytic-->
<!--FIN Google Analytic-->
</head>
<body>
<?php
include 'includes/prin-header.php';
?>
<div id="wrapper"> 
  <section id="cuerpoPrin">  
<div class="divcontenidoo">
<div>
          <h2 > ADMINISTRADOR DATOS HUECOMETRO</h2>
                          <div style="width:100%;"></div>
                        
                        <div style="width: 100%;">
                    
                     
                         <table width="496" border="0" cellpadding="2" cellspacing="1">
 
  <tr>
    <td style="color:#000; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="color:#000; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;"> </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="color:#000; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="162" style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;" >
    <form id="form1" name="form1" action="crear_huecometro.php" method="post">
      <input name="input" type="submit" value="Nuevo Dato">
    </form></td>
    <td width="323" >
   </td>
  </tr>
  <tr>
    <td style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;" >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;" >Buscar:</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
<div id="content-info-extend">

                
                  <div id="form_vinculate">
                          
<div id="tsort-tablewrapper" style="width:95%;">
  <div id="tsort-tableheader">
    <div class="tsort-search">
      <select id="tsort-columns" onChange="sorter.search('query')">
      </select>
      <input type="text" id="query" onKeyUp="sorter.search('query')" />
    </div>
    <span class="tsort-details">
    <div>Registros <span id="tsort-startrecord"></span>-<span id="tsort-endrecord"></span> de <span id="tsort-totalrecords"></span></div>
    <div><a href="javascript:sorter.reset()">reset</a></div>
    </span> </div>
  <table cellpadding="0" cellspacing="0" border="0" id="tsctablesort1" class="tinytable">
    <thead>
      <tr>
        <th><h3><apan style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:12px">Acciones</span></h3></th>
        <th><h3><apan style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:12px">Pavimentado</h3></th>
        <th><h3><apan style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:12px">Inversión</h3></th>
        <th><h3><apan style="font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-size:12px">Fecha</h3></th>
      </tr>
    </thead>
    <tbody>
               <?php  
	         	if(count($dtshueco) !=0){
					foreach($dtshueco as $i=>$dato){
					  $id 	  	   = $dato['hcmtr_id'];
					  $pavimentado  = $dato['hcmtr_pavimentado']; 
					  $inversion   	= $dato['hcmtr_inversion']; 
					  $fecha  		= $dato['hcmtr_fecha']; 
			     ?>
      <tr>
        <td><table width="115" border="0" cellspacing="2">
  <tr>
    <td width="25">
    	<form action="huecometro_home.php" method="post">
            <input name="boton" type="image" src="images/icon-delete.gif" id="boton" />
            <input name="action" type="hidden" id="action" value="del" />
            <input name="key" type="hidden" id="key" value="<?php echo $id; ?>" />
        </form>
     </td>
    <td width="28">
    	<form action="mod_huecometro.php" method="post">
    	  <input name="boton2" type="image" src="images/icon-db-restore.gif" id="boton2" />
    	  <input name="key" type="hidden" id="key" value="<?php echo $id; ?>" />
        </form>
    </td>
  </tr>
</table></td>
        <td><?php echo $pavimentado; ?></td>
        <td><?php echo $inversion; ?></td>
        <td><?php echo $fecha; ?></td>
      </tr>
      <?php 	}
			}
	   ?>
    </tbody>
  </table>
  <div id="tsort-tablefooter">
    <div id="tsort-tablenav">
      <div> <img src="images/first.gif" width="16" height="16" alt="First Page" onClick="sorter.move(-1,true)" /> <img src="images/previous.gif" width="16" height="16" alt="First Page" onClick="sorter.move(-1)" /> <img src="images/next.gif" width="16" height="16" alt="First Page" onClick="sorter.move(1)" /> <img src="images/last.gif" width="16" height="16" alt="Last Page" onClick="sorter.move(1,true)" /> </div>
      <div>
        <select id="tsort-pagedropdown">
        </select>
      </div>
      <div> <a href="javascript:sorter.showall()">Ver todas</a> </div>
    </div>
    <div id="tsort-tablelocation">
     <span>Vistas</span> 
      <div>
        <select onChange="sorter.size(this.value)">
          <option value="10" selected="selected">10</option>
          <option value="20">20</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>
        <p>&nbsp;</p></div>
      <div class="tsort-page"><br>Pagina No: <span id="tsort-currentpage"></span> <span id="tsort-totalpages"></span></br></div>
      
    </div>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
   
  </div>
</div>                
                            

                  </div>
                </div>
  </td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">
    </td>

  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right"></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    </tr>
                </table>
                  </div>
                  <div style="width: 100%;" ></div>
                  <div style="width: 100%;"></div>
                            <div></div>
                            <div style="width: 100%;" >
                              <div colspan="3" style="text-align: justify; padding: 15px;" class="Subtitulos" valign="top"></div>
                           
                        </div>
      </div>

</div>    
 </section>
</div>
<?php
include 'includes/prin-footer.php';
?>
    <!-- DC DataGrid Settings -->
<script type="text/javascript">
    var sorter = new TINY.table.sorter('sorter','tsctablesort1',{
        headclass:'head',
        ascclass:'asc',
        descclass:'desc',
        evenclass:'tsort-evenrow',
        oddclass:'tsort-oddrow',
        evenselclass:'tsort-evenselected',
        oddselclass:'tsort-oddselected',
        paginate:true, // pagination (true,false)
        size:10, // show 10 results per page
        colddid:'tsort-columns',
        currentid:'tsort-currentpage',
        //totalid:'tsort-totalpages',
        startingrecid:'tsort-startrecord',
        endingrecid:'tsort-endrecord',
        totalrecid:'tsort-totalrecords',
        hoverid:'tsort-selectedrow',
        pageddid:'tsort-pagedropdown',
        navid:'tsort-tablenav',
        sortcolumn:1, // sort column 1
        sortdir:1, // sort direction
     
        init:true // activate datagrid (true,false)
    });
  </script>
<!-- DC DataGrid End -->
</body>
</html>
