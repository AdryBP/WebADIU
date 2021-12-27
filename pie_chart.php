<?php

$host = "localhost";
$usuario = "root";
$contraseña = "";
$base = "itic";

$conexion = new mysqli($host, $usuario, $contraseña, $base);
if ($conexion->connect_errno) {
    die("Fallo la conexion:(" . $conexion->mysqli_connect_errno() . ")" . $conexion->mysqli_connect_error());
}

// Consultas a la Base de datos

$resTotal = $conexion->query("SELECT * FROM alumnos");
$cnt = $resTotal->num_rows;

$resA1 = $conexion->query("SELECT * FROM alumnos where grupo='A100'");
$cntA1 = $resA1->num_rows;
$totalA1 = $cntA1 * 100 / $cnt; // valor porcentual

$resA2 = $conexion->query("SELECT * FROM alumnos where grupo='A200'");
$cntA2 = $resA2->num_rows;
$totalA2 = $cntA2 * 100 / $cnt; // valor porcentual

$resB1 = $conexion->query("SELECT * FROM alumnos where grupo='B100'");
$cntB1 = $resB1->num_rows;
$totalB1 = $cntB1 * 100 / $cnt; // valor porcentual

$resB2 = $conexion->query("SELECT * FROM alumnos where grupo='B200'");
$cntB2 = $resB2->num_rows;
$totalB2 = $cntB2 * 100 / $cnt; // valor porcentual

$resC1 = $conexion->query("SELECT * FROM alumnos where grupo='C100'");
$cntC1 = $resC1->num_rows;
$totalC1 = $cntC1 * 100 / $cnt; // valor porcentual

$resC2 = $conexion->query("SELECT * FROM alumnos where grupo='C200'");
$cntC2 = $resC2->num_rows;
$totalC2 = $cntC2 * 100 / $cnt; // valor porcentual


$listA1 = array("name" => "A100", "y" => $totalA1);
$listA2 = array("name" => "A200", "y" => $totalA2);
$listB1 = array("name" => "B100", "y" => $totalB1);
$listB2 = array("name" => "B200", "y" => $totalB2);
$listC1 = array("name" => "C100", "y" => $totalC1);
$listC2 = array("name" => "C200", "y" => $totalC2);



?>

<html lang="es">

<head>
    <title>Gráfica de Pastel con Highcharts desde BD</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <link href="estilos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- -----------------------------------------HIGHCHARTS --------------------------------------------- -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script type="text/javascript">
        $(function() {
            $('#container').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Browser market shares in January, 2018'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        }
                    }
                },
                series: [{
                    name: 'Brands',
                    colorByPoint: true,
                    data: [

                        <?php

                        echo json_encode($listA1).",\n";
                        echo json_encode($listA2).",\n";
                        echo json_encode($listB1).",\n";
                        echo json_encode($listB2).",\n";
                        echo json_encode($listC1).",\n";
                        echo json_encode($listC2).",\n";
                        
                        /*
                        echo "var listA2 = []\n";
                        echo "var listB1 = []\n";
                        echo "var listB2 = []\n";
                        echo "var listC1 = []\n";
                        echo "var listC2 = []\n";
                        */

                        // echo $A1;
                        // echo $A2;
                        // echo $B1;
                        // echo $B2;
                        // echo $C1;
                        // echo $C2;

                        ?>
                        

                        /*
                        <?php 
                        while($row = mysqli_fetch_array($con)){
                            echo "['".$row["grupo"]."',".$row["id_alumno"]."],";
                        }
                        ?>
                        */

                        /*
                        {
                            name: 'Chrome',
                            y: 61.41
                        }, {
                            name: 'Internet Explorer',
                            y: 11.84
                        }, {
                            name: 'Firefox',
                            y: 10.85
                        }, {
                            name: 'Edge',
                            y: 4.67
                        }, {
                            name: 'Safari',
                            y: 4.18
                        }, {
                            name: 'Sogou Explorer',
                            y: 1.64
                        }, {
                            name: 'Opera',
                            y: 1.6
                        }, {
                            name: 'QQ',
                            y: 1.2
                        }, {
                            name: 'Other',
                            y: 2.61
                        },
                        */

                    ]
                }]
            });
            <?php
            // echo "console.log(listA1);";
            ?>
        });
    </script>

</head>

<body>

    <header>

        <div class="alert alert-info">
            <h2>Gráfica de Pastel con Highcharts desde BD</h2>
        </div>

        <figure class="highcharts-figure">
            <div id="container"></div>
            <p class="highcharts-description">
                Pie charts are very popular for showing a compact overview of a
                composition or comparison. While they can be harder to read than
                column charts, they remain a popular choice for small datasets.
            </p>
        </figure>

    </header>

</body>

</html>