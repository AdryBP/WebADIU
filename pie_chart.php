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
            $('#pie').highcharts({
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

                        echo json_encode($listA1) . ",\n";
                        echo json_encode($listA2) . ",\n";
                        echo json_encode($listB1) . ",\n";
                        echo json_encode($listB2) . ",\n";
                        echo json_encode($listC1) . ",\n";
                        echo json_encode($listC2) . ",\n";

                        ?>

                    ]
                }]
            });
            <?php
            // echo "console.log(listA1);";
            ?>
        });
    </script>

    <!-- -------------------------------------------------------- COLUMN CHART ------------------------------------------------------- -->
    <?php

    $listaCarreras = [];
    $resCarreras = $conexion->query("SELECT COUNT(id_alumno) as numAlumnos, carrera FROM `alumnos` GROUP BY carrera");
    while ($row = $resCarreras->fetch_array(MYSQLI_BOTH)) {
        $listaCarreras[] = array("name"=>$row["carrera"], "y"=> intval($row["numAlumnos"]));
    }

    ?>

    <script>
        $(function() {
            $('#columns').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Browser market shares. January, 2018'
                },
                subtitle: {
                    text: 'Click the columns to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
                },
                accessibility: {
                    announceNewData: {
                        enabled: true
                    }
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Total percent market share'
                    }

                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
                },

                series: [{
                    name: "Carreras",
                    colorByPoint: true,
                    
                        <?php
                        echo "data:".json_encode($listaCarreras) . "\n,";
                        ?>
                    
                }],
                drilldown: {
                    breadcrumbs: {
                        position: {
                            align: 'right'
                        }
                    },
                    series: [{
                            name: "Chrome",
                            id: "Chrome",
                            data: [
                                [
                                    "v65.0",
                                    0.1
                                ],
                                [
                                    "v64.0",
                                    1.3
                                ],
                                [
                                    "v63.0",
                                    53.02
                                ],
                                [
                                    "v62.0",
                                    1.4
                                ],
                                [
                                    "v61.0",
                                    0.88
                                ],
                                [
                                    "v60.0",
                                    0.56
                                ],
                                [
                                    "v59.0",
                                    0.45
                                ],
                                [
                                    "v58.0",
                                    0.49
                                ],
                                [
                                    "v57.0",
                                    0.32
                                ],
                                [
                                    "v56.0",
                                    0.29
                                ],
                                [
                                    "v55.0",
                                    0.79
                                ],
                                [
                                    "v54.0",
                                    0.18
                                ],
                                [
                                    "v51.0",
                                    0.13
                                ],
                                [
                                    "v49.0",
                                    2.16
                                ],
                                [
                                    "v48.0",
                                    0.13
                                ],
                                [
                                    "v47.0",
                                    0.11
                                ],
                                [
                                    "v43.0",
                                    0.17
                                ],
                                [
                                    "v29.0",
                                    0.26
                                ]
                            ]
                        },
                        {
                            name: "Firefox",
                            id: "Firefox",
                            data: [
                                [
                                    "v58.0",
                                    1.02
                                ],
                                [
                                    "v57.0",
                                    7.36
                                ],
                                [
                                    "v56.0",
                                    0.35
                                ],
                                [
                                    "v55.0",
                                    0.11
                                ],
                                [
                                    "v54.0",
                                    0.1
                                ],
                                [
                                    "v52.0",
                                    0.95
                                ],
                                [
                                    "v51.0",
                                    0.15
                                ],
                                [
                                    "v50.0",
                                    0.1
                                ],
                                [
                                    "v48.0",
                                    0.31
                                ],
                                [
                                    "v47.0",
                                    0.12
                                ]
                            ]
                        },
                        {
                            name: "Internet Explorer",
                            id: "Internet Explorer",
                            data: [
                                [
                                    "v11.0",
                                    6.2
                                ],
                                [
                                    "v10.0",
                                    0.29
                                ],
                                [
                                    "v9.0",
                                    0.27
                                ],
                                [
                                    "v8.0",
                                    0.47
                                ]
                            ]
                        },
                        {
                            name: "Safari",
                            id: "Safari",
                            data: [
                                [
                                    "v11.0",
                                    3.39
                                ],
                                [
                                    "v10.1",
                                    0.96
                                ],
                                [
                                    "v10.0",
                                    0.36
                                ],
                                [
                                    "v9.1",
                                    0.54
                                ],
                                [
                                    "v9.0",
                                    0.13
                                ],
                                [
                                    "v5.1",
                                    0.2
                                ]
                            ]
                        },
                        {
                            name: "Edge",
                            id: "Edge",
                            data: [
                                [
                                    "v16",
                                    2.6
                                ],
                                [
                                    "v15",
                                    0.92
                                ],
                                [
                                    "v14",
                                    0.4
                                ],
                                [
                                    "v13",
                                    0.1
                                ]
                            ]
                        },
                        {
                            name: "Opera",
                            id: "Opera",
                            data: [
                                [
                                    "v50.0",
                                    0.96
                                ],
                                [
                                    "v49.0",
                                    0.82
                                ],
                                [
                                    "v12.1",
                                    0.14
                                ]
                            ]
                        }
                    ]
                }
            });
        });
    </script>

</head>

<body>

    <header>

        <div class="alert alert-info">
            <h2>Gráfica de Pastel con Highcharts desde BD</h2>
        </div>

        <figure class="highcharts-figure">
            <div id="pie"></div>
            <p class="highcharts-description">
                Pie charts are very popular for showing a compact overview of a
                composition or comparison. While they can be harder to read than
                column charts, they remain a popular choice for small datasets.
            </p>
        </figure>

        <figure class="highcharts-figure">
            <div id="columns"></div>
            <p class="highcharts-description">
                Grafico de columnas
            </p>
        </figure>

    </header>

</body>

</html>