<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Carbon\Carbon;
 
 
//*********************************
// IMPORTANT NOTE 
// ==============
// If your website requires user authentication, then
// THIS FILE MUST be set to ALLOW ANONYMOUS access!!!
//
//*********************************
 
//Includes WebClientPrint classes
include_once(app_path() . '\WebClientPrint\WebClientPrint.php');
use Neodynamic\SDK\Web\WebClientPrint;
use Neodynamic\SDK\Web\Utils;
use Neodynamic\SDK\Web\DefaultPrinter;
use Neodynamic\SDK\Web\InstalledPrinter;
use Neodynamic\SDK\Web\PrintFile;
use Neodynamic\SDK\Web\ClientPrintJob;
 
use Session;
 
class PrintESCPOSController extends Controller
{
    public function index(){
 
        $wcpScript = WebClientPrint::createScript(action('WebClientPrintController@processRequest'), action('PrintESCPOSController@printCommands'), Session::getId());    
 
        return view('home.printESCPOS', ['wcpScript' => $wcpScript]);
    }
 
    public function printCommands(Request $request){
         
       if ($request->exists(WebClientPrint::CLIENT_PRINT_JOB)) {
 
            $useDefaultPrinter = ($request->input('useDefaultPrinter') === 'checked');
            $printerName = urldecode($request->input('printerName'));
             
            //Create ESC/POS commands for sample receipt
            $esc = '0x1B'; //ESC byte in hex notation
            $newLine = '0x0A'; //LF byte in hex notation
             
            $cmds = '';
            $cmds = $esc . "@"; //Initializes the printer (ESC @)
            $cmds .= 'PLEASE PRESENT THIS'; 
            $cmds .= $newLine;
            $cmds .= 'TO YOUR ATTENDING THERAPIST'; 
            $cmds .= $newLine;
            $cmds .= $newLine;
            $cmds .= $newLine;
            $cmds .= Carbon::now();
            $cmds .= $newLine;
            $cmds .= 'JOB ORDER';
            $cmds .= $newLine;
            $cmds .= 'TAX 5%                    0.44';
            $cmds .= $newLine;
            $cmds .= 'TOTAL                     9.22';
            $cmds .= $newLine;
            $cmds .= 'CASH TEND                10.00';
            $cmds .= $newLine;
            $cmds .= 'CASH DUE                  0.78';
            $cmds .= $newLine . $newLine;
            $cmds .= $esc . '!' . '0x18'; //Emphasized + Double-height mode selected (ESC ! (16 + 8)) 24 dec => 18 hex
            $cmds .= '# ITEMS SOLD 2';
            $cmds .= $esc . '!' . '0x00'; //Character font A selected (ESC ! 0)
            $cmds .= $newLine . $newLine;
            $cmds .= '11/03/13  19:53:17';
 
            //Create a ClientPrintJob obj that will be processed at the client side by the WCPP
            $cpj = new ClientPrintJob();
            //set ESCPOS commands to print...
            $cpj->printerCommands = $cmds;
            $cpj->formatHexValues = true;
             
            if ($useDefaultPrinter || $printerName === 'null') {
                $cpj->clientPrinter = new DefaultPrinter();
            } else {
                $cpj->clientPrinter = new InstalledPrinter($printerName);
            }
         
            //Send ClientPrintJob back to the client
            return response($cpj->sendToClient())
                        ->header('Content-Type', 'application/octet-stream');
                 
             
        }
    }    
     
}