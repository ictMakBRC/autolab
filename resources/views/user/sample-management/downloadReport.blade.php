
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Resullt Doc</title>
<style>
  body{margin:0;font-family:Nunito,sans-serif;font-size:.8rem;font-weight:400;line-height:1.5;color:#000000;background-color:#ffffff;-webkit-text-size-adjust:100%;-webkit-tap-highlight-color:transparent}
  hr{margin:1rem 0;color:inherit;background-color:currentColor;border:0;opacity:.25}
  hr:not([size]){height:1px}
      .text_centered {
        position: absolute;
        top: 56%;
        left: 6%;
        /* transform: translate(-50%, -50%); */
        color: red
        }
        table {
  border-collapse: collapse;
}
.btop{
 border:none;border-top:1px solid #DDDDDD 1.0pt;mso-border-top-alt:
  solid #DDDDDD .75pt;mso-border-top-alt:
  solid #DDDDDD .75pt;mso-border-bottom-alt:
  solid #DDDDDD .75pt;
  padding-top: 5px;
  padding-bottom: 5px;
  border-block-start-style: outset;
}
</style>
</head>

<body style="line-height:1.2; font-family:times;">
    <div class="row" style="line-height:0.9">
          <h2 style="text-align:center; font-family:times;">MAKERERE <img src="{{asset('images/results/mak.png')}}" alt="Makerere University Logo" width="150px" style="vertical-align:middle;" onerror="this.onerror=null;this.src='{{asset('images/photos/20220130105722.jpg')}}';"> UNIVERSITY</h2>
           <h4 style="text-align:center; font-family:times;">COLLEGE OF HEALTH SCIENCES<br>
            <h4 style="text-align:center; font-family:times;">SCHOOL OF BIOMEDICAL SCIENCES<br>
                                                            DEPARTMENT OF IMMUNOLOGY AND MOLECULAR BIOLOGY</h4>
          <h5 style="text-align:center; font-family:times;">MOLECULAR BIOLOGY LABORATORY</h5>
          <hr style="height:1px; width:100%; color:#6C757D;">
          <h6 style="text-align:center; font-family:times; color:red"><b>RESULT REPORT</b></h6>
    </div>
    <div  style="font-size:16px; margin-top:0px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td><b>Stusy : PHOENIX</b></td>
                <td></td>
                <td><b>Date:</b></td>
            </tr>
        <tr>        
            <td style="width:50%">
                    <b>LAB Number: </b><font> PNX82844</font><br>
                    <b>Patient ID: </b>1242224H <b>Sample ID:</b> RX002Q <br>
                    <b>Name:</b> Kia Sherry Nalongo Balya <br>
                    <b>Age:</b> 24 Years <b>Gender:</b> Male
                    <b>Study Name:</b> Photosynthesis <br>
            </td>
            <td style="width:5%"></td>
       
            <td style="width:45%">
                <div>
                    <b>Requester</b> <br>
                    <b>Name:</b> Kia Priscilla <br>
                    <b>Telephone:</b> 0775664433 <br>
                    <b>Email:</b> kia@gmail.com <br>
                    <b>Organisation:</b> Uganda Cancer Institute
                </div>
            </td>
        </tr>
        {{--  --}}
        </table>
    </div>
    <div class="col-12 table-responsive" style="font-size:15px; margin-top:20px;">
        <table  class="table dt-responsive nowrap">
          <tbody>
            <tr class="btop" style="width:50%">
                <td class="btop"><strong>Test requested:</strong> HAIN Genotype MTBDRplus</td>
                <td style="width:5%"></td>
                <td class="btop" style="width:45%"><strong>Sample Type:</strong> Decontaminated Sputum</td>
              </tr>
              <tr>
                <td class="btop"><strong>Collection Date:</strong> <br> 05/Oct/2022 19:30</td>
                <td class="btop"><strong>Date received:</strong> <br> 05/Oct/2022 19:30</td>
                <td class="btop"><strong>Result Date:</strong> <br> 05/Oct/2022 19:30</td>
              </tr>    
          <tr>
            <td class="btop" style="width:60%">
                <b>Results:</b>
                Mycobacterium tuberculosis complex (MTBC): MTBC Detected
                Rifampicin: <b>Resistance detected</b>
                Isoniazid: <b>Resistance Not detected</b>
             </td>
            <td class="btop" style="width:10%">
            </td>
            <td class="btop" style="width:40%">
                <div style="float: right;">
                    <br>
                   <img src="data:image/png;base64, {!! base64_encode(QrCode::format('svg')->size(60)->generate('Make me into an QrCode!')) !!} "> 
                </div>

            </td>
          </tr>
           <br>
          <tr style="border-bottom: 1px solid rgb(f, f, f); margin-top: 20px">
            <td colspan="3" class="btop">
                <div style="display:block; border: 1px solid rgb(221, 213, 213); border-radius: 4px; padding-right:10px; padding-left:10px; line-height:1">
                    <h3><u>Comments:</u></h3>
                    <p> <b>For the MTBDRplus Kit, MTBC was Detected, the sample showed resistance to Rifampicin</b> <br>
                        Kit used: Genotype MTBDRplus VER 2.0 Lot: 0V00236 Exp: 02-Oct-2021- <br>
                        The kit lot was verified with positive and negative controls and samples of known results and it passed QC thus these results are valid and suitable for the intended purpose.</p>
                    <br>
                </div>
            </td>
        </tr>
          <tr>
            <td class="btop">
              _____________________
                <br>
                  <strong>Performed By: </strong><br>
                   [Nabwire Joanitah Wandera]
                </td>
            <td class="btop">
              _____________________
                  <br>
                  <strong>Reviewed By: </strong><br>
                   [Kia Praiscillia]
                </td>
            <td class="btop"> 
              _____________________
              <br>
                  <strong>Approved by: </strong> <br>
                   [Katabazi Fred Ashaba]
            </td>
         </tr>


          </tbody>
        </table>
            <footer>
                <table width="100%">
                    <tr>
                        <td colspan="2" style="width: 80%; text-alighn:center">
                            <h6 style="color:green;  ">
                                The Laboratory is Certified by the Ministry of Health Uganda to test for COVID-19
                            </h6>
                    </td>
                        <td style="width: 20%">
                            Completed
                        </td>
                    </tr>
                    <tr>
                        <td> <p style="text-align:center; font-size:10px; color:#4CAF50">Printed By: <font>{{ Auth::user()->name }} </font></p></td>
                        <td> <p style="text-align:center; font-size:10px; color:#4CAF50"> Print Date: {{date('l d-M-Y H:i:s')}}</font></p></td>
                        <td> <p style="text-align:center; font-size:10px; color:#4CAF50"> Printed 1 time(s)</font></p></td>
                    </tr>
                </table>
                {{-- <table style="border-bottom: 0.2px solid #6C757D; width: 100%">
                  <tr>
                    <td  style="color:#6C757D">  Page <span class="page">1</span> of <span class="topage">1</span></td>
                  
                  </tr>
                </table> --}}
            </footer>




      </div>
 
    <script type='text/php'>
        if (isset($pdf)) 
        {               
            $pdf->page_text(60, $pdf->get_height() - 50, "{PAGE_NUM} of {PAGE_COUNT}", null, 12, array(0,0,0));
        }
    </script>
    </body>
</html>
