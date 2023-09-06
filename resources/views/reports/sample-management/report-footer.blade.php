<footer style="width: 100%; position: fixed; bottom: 0;">

    <table width="100%" style="margin-top:0.1px; margin-bottom:0.1px; padding:1px">
        <tr>
                <td colspan="2" style="width: 70%; font-size:10px; text-align:left">
                    <p style="color:green;  ">
                      This laboratory is accredited by the South African National Accreditation System (SANAS)
                    </p>
            </td>
            <td style="width: 30%;text-align:right">
                <img width="50%" style="margin-right:1px; " src="{{asset('autolab-assets/images/sanas.png')}}" alt="SANAS#M0857" >
            </td>
        </tr>
        <tr>
            <td>
                <p style="text-align:left; font-size:10px; color:#4CAF50">Printed By: <font>
                        {{ Auth::user()->name }} </font>
                </p>
            </td>
            <td>
                <p style="text-align:center; font-size:10px; color:#4CAF50"> Print Date:
                    {{ date('l d-M-Y H:i:s') }}
                </p>
            </td>
            <td>
                <p style="text-align:right; font-size:10px; color:#4CAF50"> Printed
                    {{ $testResult->download_count }} time(s) @if ($testResult->tracker != '')
                        [{{ $testResult->tracker }}]
                    @endif
                </p>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <p style="text-align:center; font-style: italic; font-size:10px; color:#070707">         
                    
                    Website: <a href="https://gmi.mak.ac.ug">www.gmi.mak.ac.ug</a> |               
                    Email: <a href="mailto:makbrc.chs@mak.ac.ug">makbrc.chs@mak.ac.ug</a> | 
                    Telephone: <a href="tel:+256 414674494">+256 414674494</a>
                </p>
            </td>
        </tr>
      
    </table> 
</footer>