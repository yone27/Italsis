<?php
	session_start();
	
	chdir(dirname(__FILE__));
	include_once("../../../includes/utilities.php");
	
	class MyUtilities extends utilities {
		static function buildmyjs($level = 3) {
			switch($level) {
				case 0: $dir = "";
					break;
				case 1: $dir = "../";
					break;
				case 2: $dir = "../../";
					break;
				case 3: $dir = "../../../";
					break;
			}
			
			echo '<SCRIPT language="javascript" src="'.$dir.'js/app.js" type="text/javascript"></SCRIPT>';
		}
		
		
		static function buildmycss($level = 3) {
			switch($level) {
				case 0: $dir = "";
					break;
				case 1: $dir = "../";
					break;
				case 2: $dir = "../../";
					break;
				case 3: $dir = "../../../";
					break;
			}
			echo '<link rel="stylesheet" type="text/css" href="'.$dir.'css/custom.css">';
		}
		
		static function getIdPartyUserByIdUser($iduser) {
			$bl=new baseBL();
			$comdocid="select document from security.user where id=".$iduser;                   
			$docid=$bl->executeScalar($comdocid);
			$comidparty="select id from party.party where documentid='".$docid."'";                    
			$idparty=$bl->executeScalar($comidparty);
			return $idparty;
			
		}
		
		static function getIdPartyCompanyByIdUser($iduser) {
			$bl=new baseBL();
			$idparty= myUtilities::getIdPartyUserByIdUser($iduser);
			$comidpartyenterprise="select idpartysrc from party.partyrelationship "
					. "where idrelationshiptype=(select id from base.relationshiptype where code='ULWE') "
					. "and idpartydst=".$idparty;
			$idpartyenterprise=$bl->executeScalar($comidpartyenterprise);
			return $idpartyenterprise;
			
		}
                
                static function getIdPartyCompanyListByIdUser($iduser) {
                    $bl=new baseBL();
                    $idparty= myUtilities::getIdPartyUserByIdUser($iduser);
                    $comidpartyenterprise="select idpartysrc from party.partyrelationship "
                            . "where idrelationshiptype=(select id from base.relationshiptype where code='ULWE') "
                            . "and idpartydst=".$idparty;
                    $idpartyenterprise=$bl->executeReader($comidpartyenterprise);
                                        
                    $res=array();
                    foreach ($idpartyenterprise as $valor){
                        array_push($res, $valor['idpartysrc']);                        
                    }
                    return $res;                    
                }
		
		static function getIdPartyLocationByIdUser($iduser) {
			$bl=new baseBL();
			$idparty= myUtilities::getIdPartyUserByIdUser($iduser);
			$comidpartylocation="select idpartysrc from party.partyrelationship "
					. "where idrelationshiptype=(select id from base.relationshiptype where code='CLWS') "
					. "and idpartydst=".$idparty;
			$idpartylocation=$bl->executeScalar($comidpartylocation);
			return $idpartylocation;
		}
		
		static function getIdPartyLocationListByIdUser($iduser) {
			$bl=new baseBL();
			$idparty= myUtilities::getIdPartyUserByIdUser($iduser);
			$comidpartylocation="select idpartysrc from party.partyrelationship "
					. "where idrelationshiptype=(select id from base.relationshiptype where code='CLWS') "
					. "and idpartydst=".$idparty;
			$idpartylocation=$bl->executeReader($comidpartylocation);
		   
			$res=array();
			foreach ($idpartylocation as $valor){
				array_push($res, $valor['idpartysrc']);                        
			}
			return $res;                    
		}
                
                static function getIdPartyAndNameCompanyListByIdUser($iduser) {                     
                    $bl=new baseBL();                   
                    $idparty= myUtilities::getIdPartyUserByIdUser($iduser);
                   
                    $comidpartyandnamecompany="select ship.idpartysrc, pe.name 
                        from party.partyrelationship ship,party.party pe 
                        where ship.idrelationshiptype= (select id from base.relationshiptype 
                            where code='ULWE') 
                        and ship.idpartysrc=pe.id 
                        and ship.idpartydst=".$idparty;
                    $arrayerprise=$bl->executeReader($comidpartyandnamecompany);   
                    return $arrayerprise;                    
                }
                
                static function getIdPartyAndNameLocationListByIdUser($idparty) {
                    $bl=new baseBL();
                    $comidpartyandnamelocation="select ship.idpartydst, pe.name 
                        from party.partyrelationship ship,party.party pe 
                        where ship.idrelationshiptype= (select id from base.relationshiptype 
                            where code='SC') 
                        and ship.idpartydst=pe.id 
                        and ship.idpartysrc=".$idparty." order by pe.name";
                    $arraylocation=$bl->executeReader($comidpartyandnamelocation);   
                    return $arraylocation;                    
                }
	}
?>	