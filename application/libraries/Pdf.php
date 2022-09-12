<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }

 // Page footer
    public function Footer()
    {
        $this->SetY(-20);

        // $this->Line(17, $this->GetY(), 193, $this->GetY());

        // $this->Image(dirname(__FILE__).'/images/mym.png', 30, $this->GetY(), 10);

        // Set font
        $this->SetFont('thsarabun', 'I', 12);

        if ($this->PageNo() != 1 ) {
            // Page number
            $this->Cell(0, 5, 'พิธีรับพระราชทานปริญญาบัตร ประจำปี 2560-2562', 0, false, 'R');
            $this->Cell(0, 13, 'กองพัฒนานักศึกษา  มหาวิทยาลัยสวนดุสิต', 0, false, 'R');
        }
    }



}
