<?php

	//header('Content-Type: text/html; charset="ISO-8859-1"'); 

	session_start();
	include("./conectar_BD.php");

		$tablas = array("datu_generalak","kokapena","sarreradeskripzioa","geomorfologia","biologia","klimatika","arkeo_paleo_etno","arkeo_paleo_etno","irteerak");
		$forms = array("eleccion_datu","eleccion_koka","eleccion_sarrera","eleccion_geo","eleccion_bio","eleccion_klima","eleccion_arkeo","eleccion_etno","eleccion_irteera");
		
		$special = array("ChkEtnografia", "ChkArkeoPaleo","chkklimatika","ChkBiologia");
		$checkbox = array("ChkTopografia", "chkArgazkiak", "Haizea","Txapa","RPCMargotuta","Sifoia","Koloratzekoa","Lurpekokorrontea");
		$numeric = array("Desnibela", "Luzera", "Zenbakia", "Mapa","Zabalera","Altuera","Zehaztazuna","X","Y","Z","Emaria","Temp_Ext","Temp_Interior","Ur_Tenperatura");
		$select = array("IdKoba","NonEratu","profilaren","Galeriarenebakidura","Aukerak", "Egoera", "Orientazioa2", "Orientazioa","IdKobaMota2","IdKobaMota","KokapenOrokorra","DolinaMota","OrientazioaS","OrriaMapa","MetodoaXY","Probintzia","Udala","Agrupacion","Mendigunea","Zona","Subzona","Litologia","Sektorehidro","Unitatehidro");
		$textbox = array("IbaiMetakinak","Higadurak","Egilea", "Laburpena", "Partaideak", "Txostena","Bibliografia", "Historia", "Jarraitzeko", "ArtxiboErreferentzia","Sinonimoak","Izena","RPC","Testua","Hurbiltzeko_bidea","Haitzuloarendesbribapena","txt_Arkeo_Paleo","txt_etno","Espezieak");
		$data = array("Data");
	
		$num = 0;
	
		for ($y = 0; $y < count($forms); $y++) {
		
		if(isset($_POST[$forms[$y]])) {

		$num++;		
		$eleccion=$_POST[$forms[$y]];
		
		$filtro = " 1 ";
		
		$t = $tablas[$y];

		for ($i = 0; $i < count($eleccion); $i++) {
			// caso checkbox
			if (in_array($eleccion[$i], $checkbox)) {
				// el check está seleccionado
				if(isset($_POST[$eleccion[$i]])) 
					$filtro = $filtro." AND ".$eleccion[$i].' = "'.$_POST[$eleccion[$i]].'" ';
				
				// el check NO está seleccionado
				else  
					$filtro = $filtro." AND (".$eleccion[$i].' = "0" OR '.$eleccion[$i].' = "EZ" OR '.$eleccion[$i].' IS NULL OR '.$eleccion[$i].' = "" ) ';
	
				}
			// caso select ////////addslashes Arrasate / M
			elseif (in_array($eleccion[$i], $select)) {
				if($_POST[$eleccion[$i]]!="")
					$filtro = $filtro." AND ".$eleccion[$i].' = "'.$_POST[$eleccion[$i]].'" ';
				elseif($_POST[$eleccion[$i]]=="")
					$filtro = $filtro." AND (".$eleccion[$i].' = "" OR '.$eleccion[$i].' IS NULL ) ';
				}
			// caso numeric
			elseif (in_array($eleccion[$i], $numeric)) {
				if($_POST[$eleccion[$i]]!="" && $_POST[$eleccion[$i]."2"]!="")
					$filtro = $filtro." AND ".$eleccion[$i].' >= '.$_POST[$eleccion[$i]].' AND '.$eleccion[$i].' <= '.$_POST[$eleccion[$i]."2"].' AND '.$eleccion[$i].' IS NOT NULL AND '.$eleccion[$i].' != "" ';
				elseif($_POST[$eleccion[$i]]!="" && $_POST[$eleccion[$i]."2"]=="")
					$filtro = $filtro." AND ".$eleccion[$i].' >= '.$_POST[$eleccion[$i]].' AND '.$eleccion[$i].' IS NOT NULL AND '.$eleccion[$i].' != "" ';				
				elseif($_POST[$eleccion[$i]]=="" && $_POST[$eleccion[$i]."2"]!="")
					$filtro = $filtro.' AND '.$eleccion[$i].' <= '.$_POST[$eleccion[$i]."2"].' AND '.$eleccion[$i].' IS NOT NULL AND '.$eleccion[$i].' != "" ';				
				elseif($_POST[$eleccion[$i]]=="" && $_POST[$eleccion[$i]."2"]=="")
					$filtro = $filtro.' AND ('.$eleccion[$i].' IS NULL OR '.$eleccion[$i].' = "" OR '.$eleccion[$i].' = "0" ) ';				
					}
			// caso textbox
			elseif (in_array($eleccion[$i], $textbox)) {
				if($_POST[$eleccion[$i]]!="")
					$filtro = $filtro." AND (".$eleccion[$i].' LIKE "%'.$_POST[$eleccion[$i]].'%" OR '.$eleccion[$i].' LIKE "%'.addslashes(utf8_decode($_POST[$eleccion[$i]])).'%" ) ';

				elseif($_POST[$eleccion[$i]]=="")
					$filtro = $filtro." AND (".$eleccion[$i].' = "" OR '.$eleccion[$i].' IS NULL ) ';
				}
			// caso data
			elseif (in_array($eleccion[$i], $data)) {
				if($_POST[$eleccion[$i]]!="" && $_POST[$eleccion[$i]."2"]!="")
					$filtro = $filtro." AND ".$eleccion[$i].' >= "'.$_POST[$eleccion[$i]].'" AND '.$eleccion[$i].' <= "'.$_POST[$eleccion[$i]."2"].'" AND '.$eleccion[$i].' IS NOT NULL AND '.$eleccion[$i].' != "" ';
				elseif($_POST[$eleccion[$i]]!="" && $_POST[$eleccion[$i]."2"]=="")
					$filtro = $filtro." AND ".$eleccion[$i].' >= "'.$_POST[$eleccion[$i]].'" AND '.$eleccion[$i].' IS NOT NULL AND '.$eleccion[$i].' != "" ';				
				elseif($_POST[$eleccion[$i]]=="" && $_POST[$eleccion[$i]."2"]!="")
					$filtro = $filtro.' AND '.$eleccion[$i].' <= "'.$_POST[$eleccion[$i]."2"].'" AND '.$eleccion[$i].' IS NOT NULL AND '.$eleccion[$i].' != "" ';				
				elseif($_POST[$eleccion[$i]]=="" && $_POST[$eleccion[$i]."2"]=="")
					$filtro = $filtro.' AND ('.$eleccion[$i].' IS NULL OR '.$eleccion[$i].' = "" OR '.$eleccion[$i].' = "0" ) ';				
					}
			// caso special 
			elseif ($eleccion[$i]=="ChkEtnografia") {
					// el check está seleccionado
					if(isset($_POST[$eleccion[$i]])) 
						$filtro = $filtro." AND txt_etno IS NOT NULL AND txt_etno !='' ";
					
					// el check NO está seleccionado
					else  {
						$t = "datu_generalak";
						$filtro = $filtro." AND IdKoba NOT IN (SELECT IdKoba FROM arkeo_paleo_etno WHERE txt_etno IS NOT NULL AND txt_etno !='') "; 
						}
					}
			elseif ($eleccion[$i]=="ChkArkeoPaleo")  {
					// el check está seleccionado
					if(isset($_POST[$eleccion[$i]])) 
						$filtro = $filtro." AND txt_Arkeo_Paleo IS NOT NULL AND txt_Arkeo_Paleo !='' ";
					
					// el check NO está seleccionado
					else  {
						$t = "datu_generalak";
						$filtro = $filtro." AND IdKoba NOT IN (SELECT IdKoba FROM arkeo_paleo_etno WHERE txt_Arkeo_Paleo IS NOT NULL AND txt_Arkeo_Paleo !='') "; 
						}
					}
			elseif ($eleccion[$i]=="chkklimatika")  {
					// el check está seleccionado
					if(isset($_POST[$eleccion[$i]])) 
						$filtro = $filtro." AND Data IS NOT NULL AND Data !='' ";
					
					// el check NO está seleccionado
					else {
						$t = "datu_generalak";
						$filtro = $filtro." AND IdKoba NOT IN (SELECT IdKoba FROM klimatika WHERE Data IS NOT NULL AND Data !='') "; 
						}
					}
			elseif ($eleccion[$i]=="ChkBiologia")  {
					// el check está seleccionado
					if(isset($_POST[$eleccion[$i]])) 
						$filtro = $filtro." AND Espezieak IS NOT NULL AND Espezieak !='' ";
					
					// el check NO está seleccionado
					else {
						$t = "datu_generalak";
						$filtro = $filtro." AND IdKoba NOT IN (SELECT IdKoba FROM biologia WHERE Espezieak IS NOT NULL AND Espezieak !='') "; 
						}
						
					}			
			}
		
		
		
		$sentencia = 'SELECT IdKoba FROM '.$t.' WHERE '.$filtro.' AND IdKoba IS NOT NULL AND IdKoba !="" ORDER BY IdKoba';
		
//	header("Location: ./index.php");
		echo $sentencia;
		// reinicializamos la variable tableau
		$Tableau = array();
		
		mysql_query('SET NAMES utf8');
		$result_interno = mysql_query($sentencia);
		while($row = mysql_fetch_array($result_interno)) {
			$Tableau[] = $row['IdKoba'];
			}	
		
		//foreach ($Tableau as $value) 
    		//echo $value.",";			
					
		if($num==1){
			$result = $Tableau;
		}
		elseif($num > 1)
			$result = array_intersect($result,$Tableau);
			
		}
		
		}
		
		
		
		$_SESSION = array();
		//unset($_SESSION["lista"]);
		$_SESSION["lista"] = $result;
		$_SESSION["seleccion_k"] = $result;
		
	//	foreach ($_SESSION["lista"] as $value) 
    //		echo $value.",";	
	//	print_r($array);
	
		if($num==0) {
			echo "nada seleccionado!";
			return false;}

mysql_close($con);

  exit;

	?>