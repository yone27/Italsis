<?php
    chdir(dirname(__FILE__));
    include_once("../../../../includes/sqldbITALSIS.php");
	include_once("../../../includes/dataLayer.php");

    class MyDataLayer extends dataLayer {
        
        function executeScalar($com) {
            //echo "Instruccion = ".$com."<br>";
            $this->open();
            $con = $this->con;        	
            $resc = $con -> sqlQuery($com);

            $resc= $con->sqlAllRows($resc);
            $nr = count($resc);
            $res = "";
            
            if ($nr == 1) {
                $nc = count($resc[0]);

                if ($nc == 1) {
                    foreach($resc[0] as $res);
                }
            }

            $this->close();
            
            return $res;

        } //executeScalar

        function executeReader($com,$columnNames=true) {
            $this->open();
            $con = $this->con;        	
            $res = $con -> sqlQuery($com);
            if ($columnNames) 
                $res = $con->sqlAllRowsWithColumnsNames($res);
            else
                $res = $con->sqlAllRows($res);
            
            $this->close();
            
            return $res;


        } //executeReader

        function executeCommand($com) {
            $this->open();
            $con = $this->con;        	
            $res = $con -> sqlQuery($com);
            //11/16/2014 when fails return error message, otherwise $resource

            if (is_string($res)) {
                //echo "ERROR: dataLayer::executeCommand ".$com."<br>";
                $nr = 0;
            } else {
                $nr = 1;
            }
            
            $this->close();
            
            return $nr;

        } //executeReader

        function executeReaderPaged($com,$ne,$np,$columnNames=true) {
            $this->open();
            $con = $this->con; 
            $comOrig = $com;
            $com .= " LIMIT ".$ne." OFFSET ".($ne*$np); 
            $res = $con -> sqlQuery($com);

            if ($columnNames) 
                $res = $con->sqlAllRowsWithColumnsNames($res);
            else
                $res = $con->sqlAllRows($res);

            $this->close();
            
            return $res;
            
        } //executeReaderPaged

        // $name contains scheme
        /*function executeSP($name,$parAr) {
            $this->open();
            $con = $this->con;  

            $com = "SELECT ".$name."(";
                foreach ($parAr as $par) {	
                        if (($par==NULL) && !(is_numeric($par))) {
                                $com.="NULL,";
                        }
                        else {

                                $com.=$par.",";
                        }
                }

            $com = substr($com,0,strlen($com)-1).")";

            echo "SP = ".$com."<br>";

            //11/16/2014 when fails return error message, otherwise $resource
            $res = $con -> sqlQuery($com);

    //        echo "Res =".$res."<br>";

            if (is_string($res)) {
                //echo "ERROR: dataLayer::executeSP ".$name."<br>";
                //print_r($parAr)."<br>";
                //echo "Res =".$res."<br>";
                //echo $com."<br>";

                $res = false;
            } else {
                $res = true;
            }

            $this->close();
            //echo "Res =".$res."<br>";
            return $res;

        } //executeSP	
*/
        // 2018/05/05 MVO, insert and return id inserted
        function executeSPid($name,$parAr) {
            $this->open();
            $con = $this->con;  

            $com = "SELECT ".$name."(";
                foreach ($parAr as $par) {	
                        if (($par==NULL) && !(is_numeric($par))) {
                                $com.="NULL,";
                        }
                        else {

                                $com.=$par.",";
                        }
                }

            $com = substr($com,0,strlen($com)-1).")";

    //        echo "SP = ".$com."<br>";

            $res = $con -> sqlQuery($com);
            $qfr = $con -> sqlFetchRow($res);
            foreach ($qfr as $row);

            $this->close();

            return $row;

        } //executeSPid	


        function executeSPget($name,$id,&$parAr) {
            $this->open();
            $con = $this->con;  

            $com = "SELECT * FROM ".$name."(".$id.")";

            //echo "<br>".$com."<br>";

            //11/16/2014 when fails return error message, otherwise $resource
            $res = $con -> sqlQuery($com);

            if (is_string($res)) {
                $res = false;
            } else {
                $res = $con->sqlAllRows($res);
                // 11/16/2014
                // When not found, fills a record with one row in blank
                if (count($res) > 0) {
                    $res = $res[0];
                    if (count($res) > 0) {
                        $i = 0;
                        foreach ($res as $par) {
                            $parAr[$i] = $par;
                            $i++;
                        }	
                    } else {
                        $i = 0;
                        foreach ($parAr as $par) {
                            $parAr[$i] = "";
                            $i++;
                        }	

                    }
                }

                $res = true;
            }

            $this->close();
            //print_r($parAr);			
            return $res;

        } //executeSP

    }
?>