<footer style="width: 100%; position: fixed; bottom: 0;  line-height: 0.2;">

    <table width="100%" style="margin-top:0.1px; margin-bottom:-8px; padding:1px">
         <tr>
                <td colspan="3" style="width: 70%; font-size:10px; text-align:center">
                    
                <img width="160px" style="margin-right:1px; " src="{{asset('autolab-assets/images/sanas.png')}}" alt="SANAS#M0857" >
                    <p style="color:green;  ">
                      This laboratory is accredited by the South African National Accreditation System (SANAS)
                    </p>
           
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
            <td colspan="3"style="text-align:center; font-style: italic; font-size:10px; color:#070707">
                <p>         
                    
                    Website: <a style="color:#070707" href="https://gmi.mak.ac.ug">www.gmi.mak.ac.ug</a> |               
                    Email: <a style="color:#070707" href="mailto:makbrc.chs@mak.ac.ug">makbrc.chs@mak.ac.ug</a> | 
                    Telephone: <a style="color:#070707" href="tel:+256 414674494">+256 414674494</a>
                </p>
            </td>
        </tr>
      
    </table> 
</footer>