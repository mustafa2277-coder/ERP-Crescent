<?php
$obj=json_decode($_POST['obj'],true);
$sizeObject= sizeof($obj);
// var_dump($obj[0]);
// exit();
// var_dump($obj); exit();
date_default_timezone_set("Asia/Karachi");
 // echo 'date_default_timezone_set: ' . date_default_timezone_get() . '<br />';
function get_percentage($total, $number)
{
  if ( $total > 0 ) {
   return round($number / ($total / 100),2);
  } else {
    return 0;
  }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Print</title>

    <script type="text/javascript" src="js/dependencies/rsvp-3.1.0.min.js"></script>
    <script type="text/javascript" src="js/dependencies/sha-256.min.js"></script>
    <script type="text/javascript" src="js/qz-tray.js"></script>


    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- <link rel="stylesheet" type="text/css" href="invoice.css"> -->
    
</head>
<body>
<div id="thestyle">
        <style>
        body {
            max-width: 300px;
            margin: 0 auto;
            text-align: center;
            color: #000;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        #wrapper {
            min-width: 250px;
            margin: 0 auto;
        }

        #wrapper img {
            max-width: 300px;
            width: auto;
        }

        h2,
        h3,
        p {
            margin: 5px 0;
        }

        .left {
            width: 50%;
            float: left;
            text-align: left;
            margin-bottom: 3px;
            font-size: 14px;
        }
        .left1 {
            width: 90%;
            float: left;
            text-align: left;
            margin-bottom: 3px;
            font-size: 12px;
        }

        .right {
            width: 50%;
            float: right;
            text-align: right;
            margin-bottom: 3px;
             font-size: 14px;
        }
        .full_area {
            width: 95%;
            text-align: center;
            margin-bottom: 3px;
        }
        .bigfonts{

           font-family: Arial, Helvetica, sans-serif;
            font-size: 12px; 
        }

        .table,
        .totals {
            width: 100%;
            margin: 10px 0;

        }

        .table th {
            border-bottom: 1px solid #000;
            font-size: 12px;
        }

        .table td {
            padding: 0;
            border-bottom: 1px solid #000;
            font-size: 12px;
        }

        .totals td {
            width: 24%;
            padding: 0;
        }

        .table td:nth-child(2) {
            /*overflow: hidden;*/
        }
        tr.spaceUnder>td {
          padding-bottom: 2px;
          padding-top: 2px
        }

    </style>
</div>
    <div class="wrapper" id="slip1">

        <!-- <div><img height="100" width="100" src="http://admin.findurmeal.com/Temp/<?php echo $obj['logo']; ?>"></div> -->
        <h3><strong  id='invoiceName' >CRESCENT BOOKS & UNIFORM SHOP</strong></h3>
        25-F-1, Ehsan Plaza, Main Boulevard, Johar Town, Lahore
        <div style="clear:both;"></div>
        <span id='invoiceNum' class="center">contact# 042-35291887 & 0321-4426529</span><br><br>
        <div style="clear:both;"></div>
       

        
        <span class="left1">Return Invoice No. : <?php echo $obj[0]['id']; ?></span>
        <div style="clear:both;"></div>
       
        <span class="left1">Date :<?php echo $obj[0]['created_at']; ?></span>
        <div style="clear:both;"></div>
        <table class="table" cellspacing="0" border="0">
            <thead>
                <tr>
                   
                    <th class = 'bigfonts'>Product</th>
                    <th class = 'bigfonts'>Price</th>
                    <th class = 'bigfonts'>Qty</th>
                    <th class = 'bigfonts'>Total</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $count = 1;
                $quantity = 0;
               
                
                $total = $obj[0]['totalAmount'];
                
                
                foreach ($obj as $value) {
                    // echo  "\n"."after loop"."\n";
                    // var_dump($value);exit();
                    $quantity = $quantity + 1;
                    $amount = $value['qty']*$value['unitPrice'];
                    $unit=$value['unitPrice'];
                    echo "<tr class='spaceUnder'><td  style='text-align:left;width: 377px;font-size: 11px;'>$value[name] </td>
                    <td  style='font-size: 10px; width:180px;'>$unit</td>
                    <td  style='text-align:center; font-size: 10px; width:50px;'>$value[qty]</td>
                    <td  style='font-size: 10px; width:70px; '>-$amount</td></tr>";
                    $count++;
                } 
                ?>


            </tbody>
        </table>
        <table class="totals" cellspacing="0" border="0" style="margin-bottom:5px;">
            <tbody>
                <tr>
                    <td style="text-align:left; font-size: 12px;">Total Qty</td><td style="text-align:right; padding-right:1.5%;font-size: 12px; border-right: 1px solid #000"><?php echo $count-1; ?></td>
                    <td style="text-align:left; padding-left:1.5%;font-size: 12px;">Gross Total</td><td style="text-align:right;font-size: 12px;">-<?php echo $total; ?></td>
                </tr>
                <!-- <tr>
                    <td style="text-align:left; font-size: 12px;">Discount %</td><td style="text-align:right; padding-right:1.5%;font-size: 12px; border-right: 1px solid #000"><?php echo $obj['discountPercentage']; ?>%</td>
                    <td style="text-align:left; padding-left:1.5%;font-size: 12px;">Disc Amt.</td><td style="text-align:right;font-size: 12px;"><?php echo $obj['discountAmount']; ?></td>
                </tr> -->
                <!-- <tr>
                    <td style="text-align:left;"></td><td style="text-align:right; padding-right:1.5%; border-right: 1px solid #000"></td>
                    <td style="text-align:left; padding-left:1.5%;"></td><td style="text-align:right"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:left; border-top:1px solid #000; padding-top:5px;font-size: 12px;"><b>Net Total</b></td><td colspan="2" id="tax" style="border-top:1px solid #000; padding-top:5px; text-align:right;font-size: 12px;"><b>-<?php echo $total; ?></b></td>
                </tr>
               -->
                
            </tbody>
        </table>
        <div style="border-top:1px solid #000; padding-top:10px;">
            <!--  <h2>Token No : <?php echo $obj['token'];?></h2> -->
            <p style="text-align: left;FONT-SIZE: 11px;">
                THANK YOU FOR YOUR VISIT.<br>
                <p style="text-align: left;FONT-SIZE: 11px;">BOOKS (TEXT BOOKS,NOVEL,FICTIONS ETC.) ONCE SOLD CANNOT BE CHNAGED/REFUND NO CLAIMS FOR TOYS, ELECTRONIC ITEMS</p>
            </p> </div>
 
        </div>
           <div id="buttons" style="padding-top:10px; text-transform:uppercase;">
                <span class="left"><a href="#" style="width:90%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#fff; background-color:#6fafef; border:2px solid #6fafef; padding: 10px 1px;" id="email">Back</a></span>
                <span class="right"><button type="button" accesskey="4" title="Shortcut: (alt+4)" onclick="printHTML();" style="width:100%; cursor:pointer; font-size:12px; background-color:#007fff; color:#fff; text-align: center; border:1px solid #007fff; padding: 10px 1px;">Print</button></span>
                <div style="clear:both;"></div>
            </div>

           
       
<script>
    /// Authentication setup ///
qz.security.setCertificatePromise(function(resolve, reject) {
        //Preferred method - from server
//        $.ajax("assets/signing/digital-certificate.txt").then(resolve, reject);

        //Alternate method 1 - anonymous
//        resolve();

        //Alternate method 2 - direct
        resolve("-----BEGIN CERTIFICATE-----\n" +
            "MIIFAzCCAuugAwIBAgICEAIwDQYJKoZIhvcNAQEFBQAwgZgxCzAJBgNVBAYTAlVT\n" +
            "MQswCQYDVQQIDAJOWTEbMBkGA1UECgwSUVogSW5kdXN0cmllcywgTExDMRswGQYD\n" +
            "VQQLDBJRWiBJbmR1c3RyaWVzLCBMTEMxGTAXBgNVBAMMEHF6aW5kdXN0cmllcy5j\n" +
            "b20xJzAlBgkqhkiG9w0BCQEWGHN1cHBvcnRAcXppbmR1c3RyaWVzLmNvbTAeFw0x\n" +
            "NTAzMTkwMjM4NDVaFw0yNTAzMTkwMjM4NDVaMHMxCzAJBgNVBAYTAkFBMRMwEQYD\n" +
            "VQQIDApTb21lIFN0YXRlMQ0wCwYDVQQKDAREZW1vMQ0wCwYDVQQLDAREZW1vMRIw\n" +
            "EAYDVQQDDAlsb2NhbGhvc3QxHTAbBgkqhkiG9w0BCQEWDnJvb3RAbG9jYWxob3N0\n" +
            "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAtFzbBDRTDHHmlSVQLqjY\n" +
            "aoGax7ql3XgRGdhZlNEJPZDs5482ty34J4sI2ZK2yC8YkZ/x+WCSveUgDQIVJ8oK\n" +
            "D4jtAPxqHnfSr9RAbvB1GQoiYLxhfxEp/+zfB9dBKDTRZR2nJm/mMsavY2DnSzLp\n" +
            "t7PJOjt3BdtISRtGMRsWmRHRfy882msBxsYug22odnT1OdaJQ54bWJT5iJnceBV2\n" +
            "1oOqWSg5hU1MupZRxxHbzI61EpTLlxXJQ7YNSwwiDzjaxGrufxc4eZnzGQ1A8h1u\n" +
            "jTaG84S1MWvG7BfcPLW+sya+PkrQWMOCIgXrQnAsUgqQrgxQ8Ocq3G4X9UvBy5VR\n" +
            "CwIDAQABo3sweTAJBgNVHRMEAjAAMCwGCWCGSAGG+EIBDQQfFh1PcGVuU1NMIEdl\n" +
            "bmVyYXRlZCBDZXJ0aWZpY2F0ZTAdBgNVHQ4EFgQUpG420UhvfwAFMr+8vf3pJunQ\n" +
            "gH4wHwYDVR0jBBgwFoAUkKZQt4TUuepf8gWEE3hF6Kl1VFwwDQYJKoZIhvcNAQEF\n" +
            "BQADggIBAFXr6G1g7yYVHg6uGfh1nK2jhpKBAOA+OtZQLNHYlBgoAuRRNWdE9/v4\n" +
            "J/3Jeid2DAyihm2j92qsQJXkyxBgdTLG+ncILlRElXvG7IrOh3tq/TttdzLcMjaR\n" +
            "8w/AkVDLNL0z35shNXih2F9JlbNRGqbVhC7qZl+V1BITfx6mGc4ayke7C9Hm57X0\n" +
            "ak/NerAC/QXNs/bF17b+zsUt2ja5NVS8dDSC4JAkM1dD64Y26leYbPybB+FgOxFu\n" +
            "wou9gFxzwbdGLCGboi0lNLjEysHJBi90KjPUETbzMmoilHNJXw7egIo8yS5eq8RH\n" +
            "i2lS0GsQjYFMvplNVMATDXUPm9MKpCbZ7IlJ5eekhWqvErddcHbzCuUBkDZ7wX/j\n" +
            "unk/3DyXdTsSGuZk3/fLEsc4/YTujpAjVXiA1LCooQJ7SmNOpUa66TPz9O7Ufkng\n" +
            "+CoTSACmnlHdP7U9WLr5TYnmL9eoHwtb0hwENe1oFC5zClJoSX/7DRexSJfB7YBf\n" +
            "vn6JA2xy4C6PqximyCPisErNp85GUcZfo33Np1aywFv9H+a83rSUcV6kpE/jAZio\n" +
            "5qLpgIOisArj1HTM6goDWzKhLiR/AeG3IJvgbpr9Gr7uZmfFyQzUjvkJ9cybZRd+\n" +
            "G8azmpBBotmKsbtbAU/I/LVk8saeXznshOVVpDRYtVnjZeAneso7\n" +
            "-----END CERTIFICATE-----\n" +
            "--START INTERMEDIATE CERT--\n" +
            "-----BEGIN CERTIFICATE-----\n" +
            "MIIFEjCCA/qgAwIBAgICEAAwDQYJKoZIhvcNAQELBQAwgawxCzAJBgNVBAYTAlVT\n" +
            "MQswCQYDVQQIDAJOWTESMBAGA1UEBwwJQ2FuYXN0b3RhMRswGQYDVQQKDBJRWiBJ\n" +
            "bmR1c3RyaWVzLCBMTEMxGzAZBgNVBAsMElFaIEluZHVzdHJpZXMsIExMQzEZMBcG\n" +
            "A1UEAwwQcXppbmR1c3RyaWVzLmNvbTEnMCUGCSqGSIb3DQEJARYYc3VwcG9ydEBx\n" +
            "emluZHVzdHJpZXMuY29tMB4XDTE1MDMwMjAwNTAxOFoXDTM1MDMwMjAwNTAxOFow\n" +
            "gZgxCzAJBgNVBAYTAlVTMQswCQYDVQQIDAJOWTEbMBkGA1UECgwSUVogSW5kdXN0\n" +
            "cmllcywgTExDMRswGQYDVQQLDBJRWiBJbmR1c3RyaWVzLCBMTEMxGTAXBgNVBAMM\n" +
            "EHF6aW5kdXN0cmllcy5jb20xJzAlBgkqhkiG9w0BCQEWGHN1cHBvcnRAcXppbmR1\n" +
            "c3RyaWVzLmNvbTCCAiIwDQYJKoZIhvcNAQEBBQADggIPADCCAgoCggIBANTDgNLU\n" +
            "iohl/rQoZ2bTMHVEk1mA020LYhgfWjO0+GsLlbg5SvWVFWkv4ZgffuVRXLHrwz1H\n" +
            "YpMyo+Zh8ksJF9ssJWCwQGO5ciM6dmoryyB0VZHGY1blewdMuxieXP7Kr6XD3GRM\n" +
            "GAhEwTxjUzI3ksuRunX4IcnRXKYkg5pjs4nLEhXtIZWDLiXPUsyUAEq1U1qdL1AH\n" +
            "EtdK/L3zLATnhPB6ZiM+HzNG4aAPynSA38fpeeZ4R0tINMpFThwNgGUsxYKsP9kh\n" +
            "0gxGl8YHL6ZzC7BC8FXIB/0Wteng0+XLAVto56Pyxt7BdxtNVuVNNXgkCi9tMqVX\n" +
            "xOk3oIvODDt0UoQUZ/umUuoMuOLekYUpZVk4utCqXXlB4mVfS5/zWB6nVxFX8Io1\n" +
            "9FOiDLTwZVtBmzmeikzb6o1QLp9F2TAvlf8+DIGDOo0DpPQUtOUyLPCh5hBaDGFE\n" +
            "ZhE56qPCBiQIc4T2klWX/80C5NZnd/tJNxjyUyk7bjdDzhzT10CGRAsqxAnsjvMD\n" +
            "2KcMf3oXN4PNgyfpbfq2ipxJ1u777Gpbzyf0xoKwH9FYigmqfRH2N2pEdiYawKrX\n" +
            "6pyXzGM4cvQ5X1Yxf2x/+xdTLdVaLnZgwrdqwFYmDejGAldXlYDl3jbBHVM1v+uY\n" +
            "5ItGTjk+3vLrxmvGy5XFVG+8fF/xaVfo5TW5AgMBAAGjUDBOMB0GA1UdDgQWBBSQ\n" +
            "plC3hNS56l/yBYQTeEXoqXVUXDAfBgNVHSMEGDAWgBQDRcZNwPqOqQvagw9BpW0S\n" +
            "BkOpXjAMBgNVHRMEBTADAQH/MA0GCSqGSIb3DQEBCwUAA4IBAQAJIO8SiNr9jpLQ\n" +
            "eUsFUmbueoxyI5L+P5eV92ceVOJ2tAlBA13vzF1NWlpSlrMmQcVUE/K4D01qtr0k\n" +
            "gDs6LUHvj2XXLpyEogitbBgipkQpwCTJVfC9bWYBwEotC7Y8mVjjEV7uXAT71GKT\n" +
            "x8XlB9maf+BTZGgyoulA5pTYJ++7s/xX9gzSWCa+eXGcjguBtYYXaAjjAqFGRAvu\n" +
            "pz1yrDWcA6H94HeErJKUXBakS0Jm/V33JDuVXY+aZ8EQi2kV82aZbNdXll/R6iGw\n" +
            "2ur4rDErnHsiphBgZB71C5FD4cdfSONTsYxmPmyUb5T+KLUouxZ9B0Wh28ucc1Lp\n" +
            "rbO7BnjW\n" +
            "-----END CERTIFICATE-----\n");
});

    qz.security.setSignaturePromise(function(toSign) {
        return function(resolve, reject) {
            //Preferred method - from server
//            $.ajax("/secure/url/for/sign-message?request=" + toSign).then(resolve, reject);

            //Alternate method - unsigned
            resolve();
        };
    });


    /// Connection ///
    function launchQZ() {
        if (!qz.websocket.isActive()) {
            window.location.assign("qz:launch");
            //Retry 5 times, pausing 1 second between each attempt
            startConnection({ retries: 5, delay: 1 });
        }
    }

    function startConnection(config) {
        if (!qz.websocket.isActive()) {
            updateState('Waiting', 'default');

            qz.websocket.connect(config).then(function() {
                updateState('Active', 'success');
                findVersion();
                findDefaultPrinter(true);
            }).catch(handleConnectionError);
        } else {
            displayMessage('An active connection with QZ already exists.', 'alert-warning');
        }
    }

    function endConnection() {
        if (qz.websocket.isActive()) {
            qz.websocket.disconnect().then(function() {
                updateState('Inactive', 'default');
            }).catch(handleConnectionError);
        } else {
            displayMessage('No active connection with QZ exists.', 'alert-warning');
        }
    }




    /// Detection ///
    function findPrinter(query, set) {
        $("#printerSearch").val(query);
        qz.printers.find(query).then(function(data) {
            displayMessage("<strong>Found:</strong> " + data);
            if (set) { setPrinter(data); }
        }).catch(displayError);
    }

    function findDefaultPrinter(set) {
        qz.printers.getDefault().then(function(data) {
            displayMessage("<strong>Found:</strong> " + data);
            if (set) { setPrinter(data); }
        }).catch(displayError);
    }

    function findPrinters() {
        qz.printers.find().then(function(data) {
            var list = '';
            for(var i = 0; i < data.length; i++) {
                list += "&nbsp; " + data[i] + "<br/>";
            }

            displayMessage("<strong>Available printers:</strong><br/>" + list);
        }).catch(displayError);
    }


    /// Raw Printers ///
      /// Pixel Printers ///
    function printHTML() {

        var thestyle = $('#thestyle').html();
                var compHtml = thestyle + $("#slip1").html();
                var config = getUpdatedConfig();
                var printData = [{
                        type: 'html',
                        format: 'plain',
                        
                        data: compHtml
                    }
                ]

                qz.print(config, printData).catch(displayError);
    }



    function printImage() {
        var config = getUpdatedConfig();

        var printData = [
            { type: 'image', data: 'assets/img/image_sample.png' }
        ];

        qz.print(config, printData).catch(displayError);
    }





    /// Page load ///
    $(document).ready(function() {
        window.readingWeight = false;
        // resetPixelOptions();

        startConnection();

        $("#printerSearch").on('keyup', function(e) {
            if (e.which == 13 || e.keyCode == 13) {
                findPrinter($('#printerSearch').val(), true);
                return false;
            }
        });

    });

    qz.websocket.setClosedCallbacks(function(evt) {
        updateState('Inactive', 'default');
        console.log(evt);

        if (evt.reason) {
            displayMessage("<strong>Connection closed:</strong> " + evt.reason, 'alert-warning');
        }
    });

    qz.websocket.setErrorCallbacks(handleConnectionError);

    qz.serial.setSerialCallbacks(function(streamEvent) {
        if (streamEvent.type !== 'ERROR') {
            console.log('Serial', streamEvent.portName, 'received output', streamEvent.output);
            displayMessage("Received output from serial port [" + streamEvent.portName + "]: <em>" + streamEvent.output + "</em>");
        } else {
            console.log(streamEvent.exception);
            displayMessage("Received an error from serial port [" + streamEvent.portName + "]: <em>" + streamEvent.exception + "</em>", 'alert-error');

        }
    });

    qz.usb.setUsbCallbacks(function(streamEvent) {
        var vendor = streamEvent.vendorId;
        var product = streamEvent.productId;

        if (vendor.substring(0, 2) != '0x') { vendor = '0x' + vendor; }
        if (product.substring(0, 2) != '0x') { product = '0x' + product; }
        var $pin = $('#' + vendor + product);

        if (streamEvent.type !== 'ERROR') {
            if (window.readingWeight) {
                $pin.html("<strong>Weight:</strong> " + readScaleData(streamEvent.output));
            } else {
                $pin.html("<strong>Raw data:</strong> " + streamEvent.output);
            }
        } else {
            console.log(streamEvent.exception);
            $pin.html("<strong>Error:</strong> " + streamEvent.exception);
        }
    });

    qz.hid.setHidCallbacks(function(streamEvent) {
        var vendor = streamEvent.vendorId;
        var product = streamEvent.productId;

        if (vendor.substring(0, 2) != '0x') { vendor = '0x' + vendor; }
        if (product.substring(0, 2) != '0x') { product = '0x' + product; }
        var $pin = $('#' + vendor + product);

        if (streamEvent.type === 'RECEIVE') {
            if (window.readingWeight) {
                var weight = readScaleData(streamEvent.output);
                if (weight) {
                    $pin.html("<strong>Weight:</strong> " + weight);
                }
            } else {
                $pin.html("<strong>Raw data:</strong> " + streamEvent.output);
            }
        } else if (streamEvent.type === 'ACTION') {
            displayMessage("<strong>Device status changed:</strong> " + "[v:" + vendor + " p:" + product + "] - " + streamEvent.actionType);
        } else { //ERROR type
            console.log(streamEvent.exception);
            $pin.html("<strong>Error:</strong> " + streamEvent.exception);
        }
    });

    var qzVersion = 0;
    function findVersion() {
        qz.api.getVersion().then(function(data) {
            $("#qz-version").html(data);
            qzVersion = data;
        }).catch(displayError);
    }

    $("#askFileModal").on("shown.bs.modal", function() {
        $("#askFile").focus().select();
    });
    $("#askHostModal").on("shown.bs.modal", function() {
        $("#askHost").focus().select();
    });


    /// Helpers ///
    function handleConnectionError(err) {
        updateState('Error', 'danger');

        if (err.target != undefined) {
            if (err.target.readyState >= 2) { //if CLOSING or CLOSED
                displayError("Connection to QZ Tray was closed");
            } else {
                displayError("A connection error occurred, check log for details");
                console.error(err);
            }
        } else {
            displayError(err);
        }
    }

    function displayError(err) {
        console.error(err);
        displayMessage(err, 'alert-danger');
    }

    function displayMessage(msg, css) {
        if (css == undefined) { css = 'alert-info'; }

        var timeout = setTimeout(function() { $('#' + timeout).alert('close'); }, 5000);

        var alert = $("<div/>").addClass('alert alert-dismissible fade in ' + css)
                .css('max-height', '20em').css('overflow', 'auto')
                .attr('id', timeout).attr('role', 'alert');
        alert.html("<button type='button' class='close' data-dismiss='alert'>&times;</button>" + msg);

        $("#qz-alert").append(alert);
    }

    function pinMessage(msg, id, css) {
        if (css == undefined) { css = 'alert-info'; }

        var alert = $("<div/>").addClass('alert alert-dismissible fade in ' + css)
                .css('max-height', '20em').css('overflow', 'auto').attr('role', 'alert')
                .html("<button type='button' class='close' data-dismiss='alert'>&times;</button>");

        var text = $("<div/>").html(msg);
        if (id != undefined) { text.attr('id', id); }

        alert.append(text);

        $("#qz-pin").append(alert);
    }

    function updateState(text, css) {
        $("#qz-status").html(text);
        $("#qz-connection").removeClass().addClass('panel panel-' + css);

        if (text === "Inactive" || text === "Error") {
            $("#launch").show();
        } else {
            $("#launch").hide();
        }
    }

    function getPath() {
        var path = window.location.href;
        return path.substring(0, path.lastIndexOf("/"));
    }

    function usbButton(ids, data) {
        var click = "";
        for(var i = 0; i < ids.length; i++) {
            click += "$('#" + ids[i] + "').val('0x" + data[i] + "');$('#" + ids[i] + "').fadeOut(300).fadeIn(500);";
        }
        return '<button class="btn btn-default btn-xs" onclick="' + click + '" data-dismiss="alert">Use This</button>';
    }

    function serialButton(serialPort, data) {
        var click = "";
        for(var i = 0; i < serialPort.length; i++ ) {
            click += "$('#" + serialPort[i] + "').val('" + data[i] + "');$('#" + serialPort[i] + "').fadeOut(300).fadeIn(500);";
        }
        return '<button class="btn btn-default btn-xs" onclick="' + click + '" data-dismiss="alert">Use This</button>';
    }

    function formatHexInput(inputId) {
        var $input = $('#' + inputId);
        var val = $input.val();

        if (val.length > 0 && val.substring(0, 2) != '0x') {
            val = '0x' + val;
        }

        $input.val(val.toLowerCase());
    }



    /// QZ Config ///
    var cfg = null;
    function getUpdatedConfig() {
        if (cfg == null) {
            cfg = qz.configs.create(null);
        }

        updateConfig();
        return cfg
    }

    function updateConfig() {
        var pxlSize = null;
        var copies = "1";
        var jobName = "printing";

        cfg.reconfigure({
                            altPrinting: false,
                            encoding: "",
                            endOfDoc: "",
                            perSpool: "1",

                            colorType: "blackwhite",
                            copies: copies,
                            density: "",
                            duplex: false,
                            interpolation: "",
                            jobName: jobName,
                            margins: "0",
                            orientation: "",
                            paperThickness: "",
                            printerTray: "",
                            rasterize: true,
                            rotation: "0",
                            scaleContent: true,
                            size:   pxlSize = {
                                                width: "",
                                                height: "",
                                    },
                            units: "mm"
                        });
    }

    function setPrintFile() {
        setPrinter({ file: $("#askFile").val() });
        $("#askFileModal").modal('hide');
    }

    function setPrintHost() {
        setPrinter({ host: $("#askHost").val(), port: $("#askPort").val() });
        $("#askHostModal").modal('hide');
    }

    function setPrinter(printer) {
        var cf = getUpdatedConfig();
        cf.setPrinter(printer);

        if (typeof printer === 'object' && printer.name == undefined) {
            var shown;
            if (printer.file != undefined) {
                shown = "<em>FILE:</em> " + printer.file;
            }
            if (printer.host != undefined) {
                shown = "<em>HOST:</em> " + printer.host + ":" + printer.port;
            }

            $("#configPrinter").html(shown);
        } else {
            if (printer.name != undefined) {
                printer = printer.name;
            }

            if (printer == undefined) {
                printer = 'NONE';
            }
            $("#configPrinter").html(printer);
        }
    }
</script>

</body></html>