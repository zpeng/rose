<?
$content = "<style>
.body {
    height: 100%;
    width: 100%;
    font-family: Arial, sans-serif;
    font-size: 12px;
    text-align: center;
}
#header{
    width: 100%;
}
#log_table{
    border: 1px solid #000000;
    width: 100%;
    margin-top: 10px;
}
</style>
<div class='body'>
    <div id='header'>
        <table>
        <tr>
        <td width=150><b>Client Name:</b></td>
        <td width=250>Ziyang Peng</td>
        <td width=150><b>Email:</b></td>
        <td width=250></td>
        </tr>
        <tr>
        <td><b>Start Date:</b></td>
        <td></td>
        <td><b>End Date:</b></td>
        <td></td>
        </tr>
        </table>
    </div>

    <div id='log_table'>
    <table>
    <tr>
    <td width=150><b>Log ID</b></td>
    <td width=200><b>Calling At</b></td>
    <td width=150><b>Start At</b></td>
    <td width=150><b>Duration</b></td>
    <td width=150><b>Charge</b></td>
    </tr>
    </table>
    </div>
</div>";


require_once('../includes/bootstrap.php');

$mpdf = new mPDF();
$mpdf->WriteHTML($content);
$mpdf->Output();



?>