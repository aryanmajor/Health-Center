<?php
    
    require('../fpdf/fpdf.php');
    
    class myPDF extends FPDF{
        function header(){
            
            $this->Image('../pics/NIT_Silchar_logo.png',8,10,30,30);

            $this->SetFont('Courier','B',16);
            $this->Cell(190,7,'NATIONAL INSTITUTE OF TECHNOLOGY, SILCHAR',0,0,'C');
            $this->Ln();
            $this->SetFont('Courier','',12);
            $this->Cell(190,5,'(An Institute Of National Importance)',0,0,'C');
            $this->Ln();
            $this->SetFont('Courier','U',16);
            $this->Cell(190,7,'HEALTH CENTRE',0,0,'C');
            $this->Ln();
            $this->Ln();
            $this->SetFont('Arial','B',16);
            $this->Cell(63,10,'',0,0,'C');
            $this->Cell(63,10,'OUT PATIENT TICKET',1,0,'C');
            $this->Image('../pics/Roghaari.png',175,25,20,20);
            
            $this->Ln();
            $this->SetLineWidth(0.5);
            $this->Line(10,54,191,54);
        }
        function Footer(){
            $this->SetY(-15);
            $this->SetFont('Arial','B',10);
            $this->Cell(33,10,'Disclaimer: ',0,0,'L');
            $this->SetFont('Arial','',10);
            $this->Cell(157,10,'This is a computer generated ticket and is under proprietary of Health Centre, NIT Silchar.',0,0,'L');
            $this->Ln(5);
            $this->Cell(190,10,' Not to be used by any other entity for Commercial/ Non-Commercial Purpose.',0,0,'C');
        }
        public function PDFStudInfo($studInfo){ 

            $sIKey=array('studName'=>'Name','studBlood'=>'Blood Group','studHostel'=>'Hostel',
                'studRNum'=>'Room Number','sex'=>'Gender','studAge'=>'Age');
    
            $this->Ln();
            $this->SetFont('Courier','B',14);
            $this->Cell(190,15,'* Patient Information',0,0,'L');
            $this->Ln(12);
            
            $count=0;
            foreach($studInfo as $key=>$val){
                if($key==='studName'){
                    $this->SetFont('Arial','B',12);
                    $this->Cell(25,12,'',0,0,'L');
                    $this->SetFont('Arial','B',12);
                    $this->Cell(40,12,'Name   : ',0,0,'R');
                    $this->SetFont('Arial','',12);
                    $this->Cell(80,12,strtoupper($val),0,0,'L');
                    $this->Ln(8);
                }
                else{
                    $this->SetFont('Arial','B',12);
                    $this->Cell(15,12,'',0,0,'L');

                    $this->SetFont('Arial','B',12);
                    $this->Cell(25,12,$sIKey[$key],0,0,'R');
                    $this->Cell(5,12,':',0,0,'C');

                    $this->SetFont('Arial','',12);
                    $this->Cell(40,12,$val,0,0,'L');
                    
                    if($count%2==0){
                        $this->Ln(8);
                    }
                        $count++;
                }
            }           
        }
        public function PDFDocInfo($docInfo){
            
            $dIKey=array('docName'=>'Doctor Name','docDep'=>'Doctor Department',
                 'docEmail'=>'Doctor Email');
            
            $this->Ln();
            $this->SetFont('Courier','B',14);
            $this->Cell(190,15,'* Doctor Information',0,0,'L');
            $this->Ln(12);
            
            foreach($docInfo as $key=>$val){
                $this->SetFont('Arial','B',12);
                $this->Cell(15,12,'',0,0,'L');

                $this->SetFont('Arial','B',12);
                $this->Cell(46,12,$dIKey[$key],0,0,'L');
                $this->Cell(4,12,':',0,0,'C');
                
                $this->SetFont('Arial','',12);
                $this->Cell(125,12,$val,0,0,'L');
                $this->Ln(8);
            }
        }
        public function PDFVisitInfo($visitInfo){
            
            $vIKey=array('disease'=>'Chief Complain','symptoms'=>'Signs And Symptoms',
                'remark'=>'Advice And Remarks','docReg'=>'Doctor Registration No.',
                'vistID'=>'Visit ID','tov'=>'Date Of Visit');
            $this->Ln();
            $this->SetFont('Courier','B',14);
            $this->Cell(190,15,'* Visit Information',0,0,'L');
            $this->Ln(12);

            foreach($visitInfo as $key=>$val){
                if($key==='medicine'){
                    continue;
                }
                $this->SetFont('Arial','B',12);
                $this->Cell(15,12,'',0,0,'L');

                $this->SetFont('Arial','B',12);
                $this->Cell(56,12,$vIKey[$key],0,0,'L');
                $this->Cell(4,12,':',0,0,'C');
                
                $this->SetFont('Arial','',12);
                $this->Cell(115,12,$val,0,0,'L');
                $this->Ln(8);
            }
            $this->Ln(8);
        }
        public function PDFMedicine($medicine){
            $header=array('Medicine Name','Medicine Dose','No. Of Days');
            $width=array(70,63,56);
            $this->SetLineWidth(.3);
            $this->SetFont('','B');
            for($i=0;$i<count($header);$i++){
                $this->Cell($width[$i],7,$header[$i],1,0,'C');
            }
            $this->Ln();
            
            $this->SetFont('');
            foreach($medicine as $row){
                $this->Cell($width[0],8,$row[3],'LR',0,'C');
                $this->Cell($width[1],8,$row[1],'LR',0,'C');
                $this->Cell($width[2],8,$row[2],'LR',0,'C');
                $this->Ln();
            }
            $this->Cell(array_sum($width),
                        0,'','T');
        }
    }

?>