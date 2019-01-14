<?php
include('libs/MPDF56/mpdf.php');

class PDF {

    protected $mpdf;
    protected $header;
    protected $footer;
    protected $html;


    public function __construct(){
    
        $this->mpdf = new mPDF('c','A4','','' , 0 , 0 , 0 , 0 , 0 , 0);
        $this->mpdf->SetDisplayMode('fullpage');
    }
    public function output(){
        
        $this->mpdf->WriteHTML($this->html);
        $this->mpdf->Output();
        
    }
    public function getHeader() {
        return $this->header;
    }

    public function setHeader($header) {
        
        $this->header = $header;
        $this->mpdf->SetHeader($this->header);        
    }

    public function getFooter() {
        return $this->footer;
    }

    public function setFooter($footer) {
        $this->footer = $footer;
        $this->mpdf->SetFooter($this->footer);
    }

    public function getHtml() {
        return $this->html;
    }

    public function setHtml($html) {
        $this->html = $html;
    }

}
?>
