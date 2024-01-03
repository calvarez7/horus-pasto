<?php
namespace App\Formats;
use App\Modelos\Autorizacion;
use App\Modelos\Bodega;
use App\Modelos\Cie10paciente;
use App\Modelos\citapaciente;
use App\Modelos\Detaarticulorden;
use App\Modelos\Examenfisico;
use App\Modelos\Municipio;
use App\Modelos\Orden;
use App\Modelos\Paciente;
use App\Modelos\Sedeproveedore;
use App\User;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use \Milon\Barcode\DNS1D;
class MedicamentoFirmado extends FPDF
{
    public static $data;
    public static $user;
    public static $orden;
    public static $medico;
    public static $citaPaciente;
    public static $TEMPIMGLOC;
    public static $tipoMensaje;
    var $angle=0;
    public function generar($data,$sendEmail,$tipoMensaje)
    {

        $pdf             = new MedicamentoFirmado('p', 'mm', 'A4');
        self::$data      = $data;
        self::$user      = Paciente::where('Num_Doc', $data["identificacion"])->first();
        self::$orden     = Orden::find(self::$data["order_id"]);
        self::$tipoMensaje      = $tipoMensaje;
        $TEMPIMGLOC = 'tempimg.png';
        $dataURI    = "data:image/png;base64," . DNS1D::getBarcodePNG(self::$data["order_id"], 'C39');
        $dataPieces = explode(',', $dataURI);
        $encodedImg = $dataPieces[1];
        $decodedImg = base64_decode($encodedImg);
        file_put_contents($TEMPIMGLOC, $decodedImg);
        self::$TEMPIMGLOC = $TEMPIMGLOC;
        $pdf->AliasNbPages();
        $pdf->AddPage();
        if(self::$user->entidad_id == 1){
            $this->Body($pdf);
        }elseif(self::$user->entidad_id == 2 && isset($data["medicamentos"][0]["Estado_id"]) && $tipoMensaje == "F O R M U L A  M E D I C A"){
            $this->BodyEntidad($pdf);
        }elseif(self::$user->entidad_id == 2 && isset($data["medicamentos"][0]["Estado_id"]) && $tipoMensaje == "N O  C O N V E N I O"){
            $this->BodyEntidadNoConvenio($pdf);
        }elseif(self::$user->entidad_id == 2 && isset($data["medicamentos"][0]["Estado_id"]) && $tipoMensaje == "M I P R E S"){
            $this->BodyEntidadMypress($pdf);
        }

        if($sendEmail){
            $email = Mail::send('send_mail', $data, function ($message) use ($data, $pdf) {
                $message->to($data['correo']);
                $message->subject($data["identificacion"] . " " . $data["nombre"]);
                $message->attachData($pdf->Output("S"), 'Orden Sumimedical' . ' ' .$data["identificacion"]. ' ' . $data["nombre"] . '.pdf', [
                    'mime' => 'application/pdf',
                ]);
            });
        }
        $pdf->Output();
    }
    public function Header()
    {
        $this->SetFont('Arial','B',50);
        $this->SetTextColor(255,192,203);
        $this->RotatedText(12,134,self::$tipoMensaje,33);
        $this->SetTextColor(0,0,0);
        $citaPaciente = citapaciente::find(self::$orden->Cita_id);
        self::$medico = User::find(self::$orden->Usuario_id);
        self::$citaPaciente = $citaPaciente;
        $tipo = "(Consulta Medica)";
        if($citaPaciente->Tipocita_id == 1){
            $tipo = "Transcripción";
        }else{
            $tipo = "Consulta Medica";
        }
        $this->SetFont('Arial','I',10);
        $this->SetTextColor(251,44,0);
        $this->TextWithDirection(207, 40, utf8_decode($tipo), 'U');
        $this->SetTextColor(0,0,0);
        $cie10 = Cie10paciente::select([
            "c.Codigo_CIE10 as Codigo"
        ])
            ->join('cie10s as c','c.id','cie10pacientes.Cie10_id')
            ->where("cie10pacientes.Citapaciente_id",$citaPaciente->id)->get()->toArray();
        if(self::$user->entidad_id == 1){
            if(self::$orden->ubicacion_id){
                $proveedor[0] = Sedeproveedore::select("Nombre as punto")->where('id',self::$orden->ubicacion_id)->first();
            }else{
                $proveedor = DB::select("exec dbo.MedicamentoDireccionamiento ".intval(self::$data["order_id"]));
            }
            $bodega = Bodega::where('Nombre',$proveedor[0]->punto)->first();
            if($bodega){
                $ubicacion = Municipio::select([
                    "municipios.Nombre as Municipio",
                    "d.Nombre as Departamento"
                ])
                    ->join('departamentos as d','d.id','municipios.Departamento_id')
                    ->where('municipios.id',$bodega->Municipio_id)
                    ->first();
            }else{
                $bodega = Sedeproveedore::select([
                    'Sedeproveedores.Nombre',
                    'Sedeproveedores.Direccion',
                    'Sedeproveedores.Telefono1 as Telefono',
                    'Sedeproveedores.Municipio_id'
                ])
                    ->where('Sedeproveedores.Nombre',$proveedor[0]->punto)
                    ->first();
                $ubicacion = Municipio::select([
                    "municipios.Nombre as Municipio",
                    "d.Nombre as Departamento"
                ])
                    ->join('departamentos as d','d.id','municipios.Departamento_id')
                    ->where('municipios.id',$bodega->Municipio_id)
                    ->first();
            }
        }
        $Y = 12;
        $this->SetFont('Arial', 'B', 9);
        $logo = public_path() . "/images/logo.png";
        $this->Image($logo, 8, 7, -400);
        $this->Rect(5, 5, 30, 22);
        $this->Rect(35, 5, 80, 22);
        $this->SetXY(35, 8);
        $this->Cell(80, 4, utf8_decode('SUMIMEDICAL S.A.S'), 0, 0, 'C');
        $this->SetXY(35, $Y);
        $this->Cell(80, 4, utf8_decode('NIT: 900033371 Res: 004 '), 0, 0, 'C');
        $this->SetXY(35, $Y + 4);
        $this->SetFont('Arial','B',5);
        $Y = 5;
        $this->SetFont('Arial', 'B', 7);
        $this->Rect(115, 5, 88, 22);
        $this->SetXY(115, $Y);
        $this->Cell(88, 4, utf8_decode('Fecha de Autorizaciòn: ') . Carbon::parse(self::$orden->Fechaorden)->format("Y-m-d"), 0, 0, 'C');
        if(self::$tipoMensaje == "F O R M U L A  M E D I C A" || "M E D.  P E N D I E N T E S"){
            $this->SetXY(115, $Y + 3);
            if (self::$user->entidad_id == 1) {
                $this->Cell(88, 4, utf8_decode("Régimen: Especial / Número de Prescripción: " . self::$orden->id), 0, 0, 'C');
            }else {
                $this->Cell(88, 4, utf8_decode("Régimen: ".self::$user->tipo_categoria." / Número de Prescripción: " . self::$orden->id), 0, 0, 'C');
            }
            $this->SetXY(115, $Y + 6);
            $this->Cell(88, 4, utf8_decode('Orden: ' .self::$orden->paginacion), 0, 0, 'C');
            $this->Image(self::$TEMPIMGLOC, 125, 15, 70, 10);
        }else{
            $this->SetXY(115, $Y + 3);
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(88, 4, utf8_decode("Solicitud"), 0, 0, 'C');
        }
        $this->SetFillColor(216, 216, 216);
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(5, 28);
        if(self::$user->entidad_id == 1){
            $this->Cell(124, 4, utf8_decode('Nombre Paciente'), 1, 0, 'C', 1);
        }else{
            $this->Cell(114, 4, utf8_decode('Nombre Paciente'), 1, 0, 'C', 1);
            $this->Cell(10, 4, utf8_decode('Nivel'), 1, 0, 'C', 1);
        }
        $this->Cell(10, 4, utf8_decode('Sexo'), 1, 0, 'C', 1);
        $this->Cell(34, 4, utf8_decode('Identificación'), 1, 0, 'C', 1);
        $this->Cell(10, 4, 'Edad', 1, 0, 'C', 1);
        $this->Cell(20, 4, 'Nacimiento', 1, 0, 'C', 1);
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', '', 8);
        if(self::$user->entidad_id == 1) {
            $this->Cell(124, 4, utf8_decode(self::$user->Primer_Ape." ".self::$user->Segundo_Ape." ".self::$user->Primer_Nom." ".self::$user->SegundoNom), 1, 0, 'C');
        }else{
            $this->Cell(114, 4, utf8_decode(self::$user->Primer_Ape." ".self::$user->Segundo_Ape." ".self::$user->Primer_Nom." ".self::$user->SegundoNom), 1, 0, 'C');
            $this->Cell(10, 4, utf8_decode(self::$user->nivel), 1, 0, 'C');
        }
        $this->SetFont('Arial', '', 7.5);
        $this->Cell(10, 4, utf8_decode(self::$user->Sexo), 1, 0, 'C');
        $this->Cell(34, 4, utf8_decode(self::$user->Tipo_Doc." ".self::$user->Num_Doc), 1, 0, 'C');
        $this->Cell(10, 4, self::$user->Edad_Cumplida, 1, 0, 'C');
        $this->Cell(20, 4, substr(self::$user->Fecha_Naci,0,10), 1, 0, 'C');
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(59, 4, 'Direccion', 1, 0, 'C', 1);
        $this->Cell(59, 4, 'Telefono', 1, 0, 'C', 1);
        $this->Cell(40, 4, 'Correo', 1, 0, 'C', 1);
        $this->Cell(40, 4, 'Municipio', 1, 0, 'C', 1);
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', '', 7.5);
        $this->Cell(59, 4, utf8_decode(substr(self::$user->Direccion_Residencia, 0, 38)), 1, 0, 'C');
        $this->Cell(59, 4, utf8_decode(self::$user->Telefono) . " - " . utf8_decode(self::$user->Celular1), 1, 0, 'C');
        $this->Cell(40, 4, utf8_decode(self::$user->Correo1), 1, 0, 'C');
        $this->Cell(40, 4, 'Antioquia-Medellin', 1, 0, 'C');
        $this->Ln();
        $this->SetXY(5,44);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(58, 4, 'Punto de Entrega', 1, 0, 'C', 1);
        $this->Cell(55, 4, utf8_decode('Dirección'), 1, 0, 'C', 1);
        $this->Cell(40, 4, 'Telefono', 1, 0, 'C', 1);
        $this->Cell(45, 4, 'Municipio', 1, 0, 'C', 1);
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 7);
        if(self::$user->entidad_id == 1){
            $this->Cell(58, 4, utf8_decode($bodega->Nombre), 1, 0, 'L');
            $this->Cell(55, 4, utf8_decode($bodega->Direccion), 1, 0, 'C');
            $this->Cell(40, 4, utf8_decode($bodega->Telefono), 1, 0, 'C');
            $this->Cell(45, 4, utf8_decode($ubicacion->Departamento. "-" . $ubicacion->Municipio), 1, 0, 'C');
        }else{
            $nombre = "";
            $direccion = "";
            $telefono = "";
            $municipio = "";
            switch (self::$user->Mpio_Afiliado){
                case 'Apartado':
                    $nombre = "SERVICIO FARMACEUTICO COHAN";
                    $direccion = "Cll. 104 # 101 - 44 Sector Nueva Civilizacion";
                    $telefono = "6054949 ext 1";
                    $municipio = "APARTADÓ";
                    break;
                case 'Caldas':
                    $nombre = "E.S.E. HOSPITAL SAN VICENTE DE PAUL";
                    $direccion = "Cll. 135 Sur # 48 - 19";
                    $telefono = "6054949 ext 1";
                    $municipio = "CALDAS";
                    break;
                case 'Carepa':
                    $nombre = "HOSPITAL FRANCISCO LUIS JIMENEZ MARTINEZ";
                    $direccion = "Cll. 70 # 68 - 03 Urbanización Papagayo";
                    $telefono = "6054949 ext 1";
                    $municipio = "CAREPA";
                    break;
                case 'Chigorodo':
                    $nombre = "HOSPITAL MARÍA AUXILIADORA";
                    $direccion = "Cra. 108A # 101A - 57";
                    $telefono = "6054949 ext 1";
                    $municipio = "CHIGORODO";
                    break;
                case 'Ciudad Bolivar':
                    $nombre = "E.S.E. HOSPITAL LA MERCED";
                    $direccion = "Cll. 49 # 36 - 298 Barrio La Carmina";
                    $telefono = "6054949 ext 1";
                    $municipio = "CIUDAD BOLIVAR";
                    break;
                case 'Fredonia':
                    $nombre = "E.S.E. HOSPITAL SANTA LUCÍA";
                    $direccion = "Cll. 96 # 50 - 220 Vereda El Edén";
                    $telefono = "6054949 ext 1";
                    $municipio = "FREDONIA";
                    break;
                case 'Frontino':
                    $nombre = "E.S.E. HOSPITAL MARIA ANTONIA TORO DE ELEJALDE";
                    $direccion = "Cra. 27 # 31 - 38 Barrio Juan XXIII";
                    $telefono = "6054949 ext 1";
                    $municipio = "FRONTINO";
                    break;
                case 'Itagui':
                    $nombre = "SERVICIO FARMACEUTICO COHAN";
                    $direccion = "Cll. 73A # 52B - 25";
                    $telefono = "6054949 ext 1";
                    $municipio = "ITAGÜÍ";
                    break;
                case 'Medellin':
                    $nombre = "SERVICIO FARMACEUTICO COHAN PUNTO ORIENTAL";
                    $direccion = "Cra. 46 # 47 - 66 C.C. Punto de la Oriental - Piso 3 - Local 3050";
                    $telefono = "6054949 ext 1";
                    $municipio = "MEDELLÍN";
                    break;
                case 'Segovia':
                    $nombre = "E.S.E. HOSPITAL SAN JUAN DE DIOS";
                    $direccion = "Cll. Briceño # 47B - 65";
                    $telefono = "6054949 ext 1";
                    $municipio = "SEGOVIA";
                    break;
                case 'Turbo':
                    $nombre = "I.P.S. SALUD DARIÉN";
                    $direccion = "Cll. 51 # 49 - 04";
                    $telefono = "6054949 ext 1";
                    $municipio = "TURBO";
                    break;

            }
            if(self::$tipoMensaje == "F O R M U L A  M E D I C A"){
                $this->Cell(58, 4, utf8_decode($nombre), 1, 0, 'L');
                $this->Cell(55, 4, utf8_decode($direccion), 1, 0, 'C');
                $this->Cell(40, 4, utf8_decode($telefono), 1, 0, 'C');
                $this->Cell(45, 4, utf8_decode($municipio), 1, 0, 'C');
            }else{
                $this->Cell(58, 4, utf8_decode("COHAN"), 1, 0, 'L');
                $this->Cell(55, 4, utf8_decode(""), 1, 0, 'C');
                $this->Cell(40, 4, utf8_decode(""), 1, 0, 'C');
                $this->Cell(45, 4, utf8_decode(""), 1, 0, 'C');
            }
        }
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(25, 4, utf8_decode('Diagnósticos'), 1, 0, 'C', 1);
        $this->SetFont('Arial', '', 7.5);
        $this->Cell(173, 4, "  ".($cie10?implode(', ', array_column($cie10, 'Codigo')):""), 1, 0, 'L');
        $this->Ln();
        $this->SetXY(5, 59);
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(15, 4, utf8_decode('Código'), 1, 0, 'C', 1);
        $this->Cell(52, 4, utf8_decode('Nombre'), 1, 0, 'C', 1);
        $this->Cell(15, 4, utf8_decode('Via Admin'), 1, 0, 'C', 1);
        $this->Cell(30, 4, utf8_decode('Dosificación'), 1, 0, 'C', 1);
        $this->Cell(13, 4, utf8_decode('Duración'), 1, 0, 'C', 1);
        $this->Cell(15, 4, utf8_decode('Dosis Totales'), 1, 0, 'C', 1);
        $this->Cell(23, 4, utf8_decode('No Total a Dispensar'), 1, 0, 'C', 1);
        $this->Cell(35, 4, utf8_decode('Observación'), 1, 0, 'C', 1);
    }
    public function Footer()
    {
        $this->SetFont('Arial','',6);
        $this->Rect(5,102,198,14);
        $this->SetXY(5,103);
        $this->MultiCell(198, 3, utf8_decode("NOTA AUDITORIA: " . (isset(self::$data["medicamentos"][0]['Auth_Nota']) ? self::$data["medicamentos"][0]['Auth_Nota'] : "")), 0, "L", 0);
        $this->SetFont('Arial','B',5);
        if(isset(self::$data["Fecha_estimada"])){
            $this->Rect(5,99.5,198,3);
            $this->Text(32,101.5,utf8_decode('IMPORTANTE: '));
            $this->SetFont('Arial','',4.8);
            $this->Text(45,101.5,utf8_decode('ESTA ORDEN ES VALIDA SOLO HASTA '.self::$data["Fecha_estimada"].', UNA VEZ CUMPLIDO DICHO PLAZO NO HAY RESPOABILIDAD DE SUMIMEDICAL - RED VITAL. (Resolucion 4331 de 2012) .'));
        }
        $this->SetFont('Arial','B',8);
        $this->Text(6,119,utf8_decode('Firma del Medico que Ordena'));
        $this->Text(72,119,utf8_decode('Firma del Usuario'));
        $this->Text(138,119,utf8_decode('Firma de quien Transcribe'));
        $this->Rect(5,116,66,18);
        //$this->Rect(10,121,56,11);
        $this->Rect(71,116,66,18);
        //$this->Rect(75,121,56,11);
        $this->Rect(136.8,116,66.1,18);
        //$this->Rect(143,121,56,11);
        if(self::$citaPaciente->Tipocita_id == 1){
            $this->SetFont('Arial','B',6);
            if(self::$user->entidad_id = 2 && is_numeric(self::$citaPaciente->Medicoordeno)){
                $medicoTranscripcion = User::find(intval(self::$citaPaciente->Medicoordeno));
                if($medicoTranscripcion){
                    $this->Text(6,133,utf8_decode($medicoTranscripcion->name." ".$medicoTranscripcion->apellido."   R.M:".$medicoTranscripcion->cedula." (".$medicoTranscripcion->especialidad_medico.")"));
                    if($medicoTranscripcion->Firma){
                        if (file_exists(storage_path(substr($medicoTranscripcion->Firma, 9)))) {
                            $this->Image(storage_path(substr($medicoTranscripcion->Firma, 9)), 10, 120, 56, 11);
                        }
                    }
                }else{
                    $this->Text(10,131,self::$citaPaciente->Medicoordeno);
                }
            }else{
                $this->Text(10,131,self::$citaPaciente->Medicoordeno);
            }

            $transcriptor = User::find(self::$citaPaciente->Usuario_id);
            if (isset($transcriptor)) {
                $this->Text(143,133,utf8_decode($transcriptor->name." ".$transcriptor->apellido));
                if($transcriptor->Firma){
                    if (file_exists(storage_path(substr($transcriptor->Firma, 9)))) {
                        $this->Image(storage_path(substr($transcriptor->Firma, 9)), 143, 120, 56, 11);
                    }
                }
            }

        }else{
            if (isset(self::$medico)) {
                $this->SetFont('Arial','B',6);
                $this->Text(6,133,utf8_decode(self::$medico->name." ".self::$medico->apellido."   R.M:".self::$medico->cedula." (".self::$medico->especialidad_medico.")"));
                if(self::$medico->Firma){
                    if (file_exists(storage_path(substr(self::$medico->Firma, 9)))) {
                        $this->Image(storage_path(substr(self::$medico->Firma, 9)), 10, 120, 56, 11);
                    }
                }
            }
        }
        if(self::$orden->Estado_id == 17){
            if(self::$orden->firma_orden){
                if (file_exists(storage_path('app/public/ordenes/'.self::$user->Num_Doc.'/'.self::$orden->firma_orden))) {
                    $this->Image(storage_path('app/public/ordenes/'.self::$user->Num_Doc.'/'.self::$orden->firma_orden), 76, 120, 56, 11);
                }
            }
        }elseif(self::$orden->Estado_id == 18){
            $detalleOrden = Detaarticulorden::where('Orden_id',self::$orden->id)->whereNotNull('firma_orden')->first();
            if($detalleOrden){
                if (file_exists(storage_path('app/public/ordenes/'.self::$user->Num_Doc.'/'.$detalleOrden->firma_orden))) {
                    $this->Image(storage_path('app/public/ordenes/'.self::$user->Num_Doc.'/'.$detalleOrden->firma_orden), 76, 120, 56, 11);
                }
            }
        }
        $this->SetFont('Arial','I',8);
        $this->TextWithDirection(206,120,'Funcionario que Imprime:','U');
        $this->TextWithDirection(206, 87, utf8_decode(auth()->user()->name . " " . auth()->user()->apellido), 'U');
        $this->TextWithDirection(209,120,utf8_decode('Fecha Impresión:'),'U');
        $this->TextWithDirection(209, 98, self::$data["Fecha_actual"], 'U');
    }
    public function Body($pdf)
    {
        $Y = 64;
        $X = 2;
        $pdf->SetFont('Arial', '', 6.5);
        $medicamentos = Detaarticulorden::select('c.Codigo','c.Nombre','detaarticulordens.*')
            ->join('codesumis as c','c.id','detaarticulordens.codesumi_id')
            ->where('detaarticulordens.Orden_id',self::$orden->id)
            ->where('detaarticulordens.Estado_id',17)
            ->get();
        foreach ($medicamentos as $codeSumi) {
            if ($Y > 93) {
                $Y = 64;
                $pdf->AddPage();
            }
            $pdf->SetXY(5, $Y);
            $pdf->MultiCell(15, 4,  $codeSumi["Codigo"] , 0, 'C', 0);
            $pdf->SetXY(20, $Y);
            $pdf->MultiCell(52, 4, utf8_decode(strtolower($codeSumi["Nombre"])), 0, 'L', 0);
            $YN = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
            $pdf->SetXY(75, $Y);
            $pdf->SetFont('Arial', '', 5);
            $pdf->MultiCell(15, 4, utf8_decode($codeSumi["Via"]), 0, 'L', 0);
            $pdf->SetFont('Arial', '', 6.5);
            $pdf->SetXY(87, $Y);
            $pdf->SetFont('Arial', '', 4.5);
            $pdf->MultiCell(30, 4, utf8_decode(intval($codeSumi["Cantidadosis"]) . " " . $codeSumi["Unidadmedida"] . " cada " . $codeSumi["Frecuencia"] . " " . strtolower($codeSumi["Unidadtiempo"])), 0, 'L', 0);
            $pdf->SetFont('Arial', '', 6.5);
            $pdf->SetXY(117, $Y);
            $pdf->MultiCell(13, 4, utf8_decode($codeSumi["Duracion"] . " días"), 0, 'L', 0);
            $pdf->SetXY(130, $Y);
            $pdf->MultiCell(15, 4, intval($codeSumi["Cantidadmensual"]), 0, 'C', 0);
            $pdf->SetXY(145, $Y);
            $pdf->MultiCell(23, 4, intval($codeSumi["Cantidadpormedico"]), 0, 'C', 0);
            $pdf->SetXY(168, $Y);
            $pdf->MultiCell(35, 4, utf8_decode(strtolower($codeSumi["Observacion"])), 0, 'L', 0);
            $YO = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
            $pdf->Line(5, ($YO > $YN ? $YO : $YN), 203, ($YO > $YN ? $YO : $YN));
            $YL = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
            $Y = $Y + (($YN > $YL ? $YN : $YL) - $Y);
        }
    }

    public function TextWithDirection($x, $y, $txt, $direction = 'R')
    {
        if ($direction == 'R') {
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 1, 0, 0, 1, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        } elseif ($direction == 'L') {
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', -1, 0, 0, -1, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        } elseif ($direction == 'U') {
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 0, 1, -1, 0, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        } elseif ($direction == 'D') {
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 0, -1, 1, 0, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        } else {
            $s = sprintf('BT %.2F %.2F Td (%s) Tj ET', $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        }
        if ($this->ColorFlag) {
            $s = 'q ' . $this->TextColor . ' ' . $s . ' Q';
        }
        $this->_out($s);
    }
    function RotatedText($x, $y, $txt, $angle)
    {
        //Text rotated around its origin
        $this->Rotate($angle,$x,$y);
        $this->Text($x,$y,$txt);
        $this->Rotate(0);
    }
    function Rotate($angle,$x=-1,$y=-1)
    {
        if($x==-1)
            $x=$this->x;
        if($y==-1)
            $y=$this->y;
        if($this->angle!=0)
            $this->_out('Q');
        $this->angle=$angle;
        if($angle!=0)
        {
            $angle*=M_PI/180;
            $c=cos($angle);
            $s=sin($angle);
            $cx=$x*$this->k;
            $cy=($this->h-$y)*$this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
        }
    }
    function _endpage()
    {
        if($this->angle!=0)
        {
            $this->angle=0;
            $this->_out('Q');
        }
        parent::_endpage();
    }
}
