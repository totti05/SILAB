<?php

//-------------------------------------------------------------------------
// Archivo: clsGraphPHP.php
// Descripcion: Libreria para el manejo de Graficas en PHP
// Fecha Creación : 29/10/2004
// Versión : 1.1.0
// Autores:  José Guzmán
//           Bianca Ramirez
//-------------------------------------------------------------------------

if (! defined(__FUNCTION__))
    define(__FUNCTION__, '__FUNCTION__ requiere por lo menos PHP 4.3.0.');

define ('MINY', -1);        // Indices en $data (para MostrarXLineaData())
define ('MAXY', -2);

error_reporting(E_ALL);

//-------------------------------------------------------------------------
// Clase: PhpGraph
// Descripcion: Clase para Manejo de Gráficas
//
// Autor:  José Guzmán
//-------------------------------------------------------------------------
class PhpGraph {

 //< MIEMBROS DATOS DE LA CLASE>
	//-------------------------------------------------------------------------
	// Parámetros de Configuración
	// de la clase
	//-------------------------------------------------------------------------
    var $is_inline = FALSE;             // FALSE = Envia Encabezados, TRUE = Envia la data cruda de la Imagen (Stream)
    var $browser_cache = FALSE;         // FALSE = envia encabezados al Visualizador Browser para la imagen no en cache,
                                        // (solo si is_inline = FALSE ademas)

    var $safe_margin = 5;               // Margen extra para varias areas. En Pixeles

    var $x_axis_position = '';          // Sitio para dibujar los axis (plano cartesiano),
    var $y_axis_position = '';          // permitir espacio blanco para que el eje X en 0 0 y el eje Y axis en la Izquierda del gráfico.

    var $xscale_type = 'linear';        // Tipo de Escala para ejes del Plano Caertesiano linear, log
    var $yscale_type = 'linear';


	//-------------------------------------------------------------------------
	// Parámetros de Fuente del Gráfico
	//-------------------------------------------------------------------------

    var $use_ttf  = FALSE;                  // Usar True Type Fuentes?
    var $ttf_path = '.';                    // Ruta para Ubicar las Fuentes TT Fonts.
    var $default_ttfont = 'benjamingothic.ttf'; //Fuente TTF por defecto
    var $line_spacing = 4;                  // Expacio en Pixels entre líneas.

	//-------------------------------------------------------------------------
	// Parámetros de Angulos para Fuentes del Gráfico
	//-------------------------------------------------------------------------

    // Angulos de la Fuente: 0 or 90 grados para fuentes
    var $x_label_angle = 0;                 // Etiquetas sobre el eje X (Marcas and Datas)
    var $y_label_angle = 0;                 // Etiquetas sobre el eje Y (Marcas and Datas)
    var $x_title_angle = 0;                 // Solo Uso Interno de la Clase!
    var $y_title_angle = 90;                // Solo para Uso Interno de la Clase.
    var $title_angle = 0;                   // Angulo de Titulo.

	//-------------------------------------------------------------------------
	// Parámetros de Formato de la Imagen del Gráfico
	//-------------------------------------------------------------------------

    var $file_format = 'png';               // Formato de archivo png, bmp, jpg
    var $output_file = '';                  // Para generar un archivo de Salida en Lugar
                                            // de un StdOut standar
    var $input_file ='';                    // Para Colocar un archivo de Fondo para la
                                            // gráfico

	//-------------------------------------------------------------------------
	// Variables de data del Gráfico
	//-------------------------------------------------------------------------

    var $data_type = 'text-data';           //Tipo de Data para el grafico
                                            // text-data, data-data-error, data-data, text-data-pie

                                            //Tipo de Graficos soportados por la clase
    var $plot_type= 'linepoints';           // bars, lines, linepoints, area, points, pie, thinbarline, squared

    var $label_scale_position = 0.5;        // Cambia de lugar el texto de la data
                                            // en los graficos circulares. 1 = top, 0 = bottom
    var $group_frac_width = 0.7;            // Valores desde 0 a 1 = ancho para grupo de barras
    var $bar_width_adjust = 1;              // 1 = barras de ancho normal, admite valores mayores que 0

    var $y_precision = 1;                   // Precisión para Escala en X y Y
    var $x_precision = 1;

    var $data_units_text = '';              // Unidades para el Texto de la Data Eqtiquetas (i.e: '¤', '$', etc.)

   //-------------------------------------------------------------------------
	// Parámetros de Configuración de Titulos del Gráfico
	//-------------------------------------------------------------------------
                                            // Titulo del Grafico
    var $title_txt = '';

    var $x_title_txt = '';                  //Titulo en el Eje X.
    var $y_title_txt = '';                  //Titulo en el Eje Y.

    var $x_title_pos = 'plotdown';          // Alineación de los titulos del diagrama en el eje X,
                                            // Alineaciones Validas:
                                            // plotdown, plotup, both, none

    var $y_title_pos = 'plotleft';          // Alineación de los titulos del diagrama en el eje Y,
                                            // Alineaciones Validas:
                                            // plotleft, plotright, both, none

    //-------------------------------------------------------------------------
    // Etiquetas
    // Existen 2 Tipos De Etiquetas en la libreria:
    //    Marcas de Etiquetas: Siguen la cuadricula a la lado de los ejes.
    //                         Son dibujdas en el instante que se dibuja la rejilla,
    //                         por _MostrarMarcasEjeX() y _MostrarMarcasEjeY()
    //    Etiquetas de Data : Siguen los puntos de la Data, y pueden ser colocados sobre
    //                        los eje o el grafico (x/y)  (TODO) son dibujados en el
    //                        instante que se dibuja el grafico, por DrawDataLabel(), llamada por
    //                        la rutina MostrarLineas(), etc.
    //                        Draw*DataLabel() tambien dibuja lineas Horizontales y Verticales
    //                        para los puntos de la data dependiendo de el valor de
    //                        draw_*_data_label_line
    //-------------------------------------------------------------------------

    //-------------------------------------------------------------------------
    // Configuración de Marcas de Etiquetas
    //-------------------------------------------------------------------------
    var $x_tick_label_pos = 'plotdown';     // Tipos Soportados, para el Eje X
                                            // plotdown, plotup, both, xaxis, none

    var $y_tick_label_pos = 'plotleft';     // Tipos Soportados, para el Eje Y
                                            // plotleft, plotright, both, yaxis, none

    //-------------------------------------------------------------------------
    // Configuración de Marcas de Data
    //-------------------------------------------------------------------------
    var $x_data_label_pos = 'plotdown';     // Valores Soportados
                                            // plotdown, plotup, both, plot, all, none

    var $y_data_label_pos = 'plotleft';     // Valores Soportados
                                            // plotleft, plotright, both, plot, all, none

    var $draw_x_data_label_lines = FALSE;   // Dibujar lineas de referencias al punto?
    var $draw_y_data_label_lines = FALSE;   // TODO

    //-------------------------------------------------------------------------
    // Tipos de Etiquetas (para Marcas, datas y Etiquetas del Grafico)
    //-------------------------------------------------------------------------

    var $x_label_type = '';                 // data, Hora. Deje el espacio en blanco para ningún formato.
    var $y_label_type = '';                 // data, Hora. Deje el espacio en blanco para ningún formato.
    var $x_time_format = '%H:%m:%s';        // ver http://www.php.net/manual/html/function.strftime.html
    var $y_time_format = '%H:%m:%s';        // SetFormatoTiempoY() tambien...

    //-------------------------------------------------------------------------
    // Etiquetas de Salto o Skipping labels
    //-------------------------------------------------------------------------

    var $x_label_inc = 1;                   // Dibujar una Etiqueta por lo menos (1 = all) (TODO)
    var $y_label_inc = 1;

    //-------------------------------------------------------------------------
    // Legenda
    //-------------------------------------------------------------------------

    var $legend = '';                       // Arreglo con la leyenda de los titulos
    var $legend_x_pos = '';
    var $legend_y_pos = '';

    //-------------------------------------------------------------------------
    // Marcas
    //-------------------------------------------------------------------------
    var $x_tick_length = 5;                 // Longitud en pixel para marcas Superior/Inferior del eje X
    var $y_tick_length = 5;                 // Longitud en pixel para marcas Izquierdo / Derecho del eje Y

    var $x_tick_cross = 3;                  // eje de Intercepcion de las señales x esten muchos pixeles
    var $y_tick_cross = 3;                  // eje de Intercepcion de las señales y esten muchos pixeles

    var $x_tick_pos = 'plotdown';           // Tipo de Orientación de Marcas en X
                                            // plotdown, plotup, both, xaxis, none

                                            // Tipo de Orientación de Marcas en Y
    var $y_tick_pos = 'plotleft';           // plotright, plotleft, both, yaxis, none

    var $num_x_ticks = '';
    var $num_y_ticks = '';

    var $x_tick_increment = '';             // Fije los num_x_ticks o el x_tick_increment, no ambos.
    var $y_tick_increment = '';             //Fije los num_y_ticks o el y_tick_increment, no ambos.
    var $skip_top_tick = FALSE;
    var $skip_bottom_tick = FALSE;
    var $skip_left_tick = FALSE;
    var $skip_right_tick = FALSE;

    //-------------------------------------------------------------------------
    // Formato de Rejilla
    //-------------------------------------------------------------------------

    var $draw_x_grid = FALSE;     // TRUE : Dibuja Lineas en el eje X para el Grafico
                                  // FALSE: No Dibuja Lineas en el eje X para el Grafico

    var $draw_y_grid = TRUE;      // TRUE : Dibuja Lineas en el eje Y para el Grafico
                                  // FALSE: No Dibuja Lineas en el eje Y para el Grafico

    var $dashed_grid = TRUE;      // ACTIVA EL Rayado con un valor en TRUE
                                  // DESACTIVA EL Rayado con un valor en FALSE

    //-------------------------------------------------------------------------
    // Configuracion de Colores y Estilos
    // Nota : Todos los colores pueden ser RGB o un nombre de color
    //-------------------------------------------------------------------------

    var $color_array = 'small';             // Modo de Manejar los colores
                                            //  'small' : Toma los colores definidos por la Rutina
                                            //  'large' : se extraen de la
                                            //   array  : (definir sus propios colores)
                                            //  ver RGB.php y SetArrayRGB()

    var $i_border = array(194, 194, 194);
    var $plot_bg_color = 'white';
    var $bg_color = 'white';
    var $label_color = 'black';             // Color de Etiquetas
    var $text_color = 'black';              // Color de Texto
    var $grid_color = 'black';              // Color de Rejilla o cuadriculas
    var $light_grid_color = 'gray';
    var $tick_color = 'black';              // Color para marcas
    var $title_color = 'black';             // Color de Titulo
    var $data_colors = array('SkyBlue', 'green', 'orange', 'blue', 'orange', 'red', 'violet', 'azure1');
    var $error_bar_colors = array('SkyBlue', 'green', 'orange', 'blue', 'orange', 'red', 'violet', 'azure1');
    var $data_border_colors = array('black'); // Color de Bordes

    var $line_widths = 1;                     // Simple valor o Arreglo
    var $line_styles = array('solid',         // Estilos de Lineas
                             'solid',
                             'dashed');       // Valor Simple o arreglo
    var $dashed_style = '2-4';                // coloreado puntos-transparentes de puntos

    //var $point_size = 5;                    // Tamaño de puntos en pixel
    var $points_sizes=8;                      // Valor simple o arreglo con el tamaño en  pixeles de Puntos
    var $points_shapes=array('diamond');      // Arreglo con la forma de los puntos
    //var $point_shape = 'diamond';           // Forma de Puntos Valores Admisibles:
                                              // rect, circle, diamond, triangle, dot, line, halfline, cross

    var $error_bar_size = 5;                  // Derecho y Izquierdo tamaño de la barra
    var $error_bar_shape = 'tee';             // 'tee' o 'line'
    var $error_bar_line_width = 1;            // Simple valor (o  array TODO)

                                              // Tipos de Bordes
    var $plot_border_type = 'sides';          // left, sides, none, full

                                              // Tipos de Bordes para la Imagen del Grafico
    var $image_border_type = 'none';          // 'raised', 'plain', 'none'

    var $shading = 5;                         // 0 para no aplicar sombra, > 0
                                              // es el tamaño de la sombra en Pixels

    var $draw_plot_area_background = FALSE;   // Para Dibujar el area del grafico si es TRUE

    var $draw_broken_lines = FALSE;           // Para activacion de las lineas faltantes en el eje Y
                                              // FALSE : No dibuja.
                                              // TRUE  : dibuja.


    var $explode_radius =array();              // Radios de Separación de graficos de torta
    var $explode_r=20;                         // Tamaño para radio de separación
    var $explode_all=false;                    // Separar todos los trozos de tortas

  //< FIN DE MIEMBROS DATOS DE LA CLASE>

  //< METODOS DE LA CLASE>

     //-------------------------------------------------------------------------
     // PhpGraph
     // Descripcion: Constructor de la Clase PhpGraph, no es necesario implementar llamado
     //              al destructor de la clase.
     // Parametros:
     //            $which_width        - valor Numerico     - Ancho del Grafico
     //            $which_height       - valor Numerico     - Alto del Grafico
     //            $which_output_file  - Valor String       - Nombre del archivo de Salida
     //            $which_input_file   - Valor String       - Nombre del archivo de Entrada
     //
     // Retorno : <Ninguno>
     //-------------------------------------------------------------------------
     function PhpGraph($which_width=600, $which_height=400, $which_output_file=NULL, $which_input_file=NULL)
     {
        // Registra la función nombrada en PhpGraph para que se ejecute cuando el script procese su finalización.
        // de la instancia de la clase que esta apuntado con la referencia en this
        // Esto simulara de forma automatica la destrucciçon de la imagen
        // para más información consulte : http://ve.php.net/register_shutdown_function
        //
        register_shutdown_function(array(&$this, '_PhpGraph'));

        //Carga el modo de Colores para el Grafico 'small' , 'large' o array
        //
        $this->SetArrayRGB($this->color_array);

        $this->background_done = FALSE;     // Cambiar a TRUE se dibuja primero la imagen
                                            // de Fondo

        if ($which_output_file)
            $this->SetArchivoSalida($which_output_file);

        if ($which_input_file)
            $this->SetArchivoEntrada($which_input_file);
        else {
            $this->image_width = $which_width;
            $this->image_height = $which_height;

            $this->img = ImageCreate($this->image_width, $this->image_height);
            if (! $this->img)
                $this->PrintError('PhpGraph(): No pudo crear el recurso de la Imagen.');

        }

        $this->SetEstilosxDefecto();
        $this->SetFuentesxDefecto();

        $this->SetTitulo('');
        $this->SetXTitulo('');
        $this->SetYTitulo('');

        $this->print_image = TRUE;      // Usada para multiples imagenes por grafico (TODO: automático)
     }

     //-------------------------------------------------------------------------
     // _PhpGraph
     // Descripcion: Destructor de la Clase PhpGraph, Libera los recursos usados
     //              por la imagen donde se generó el gráfico
     // Parametros : <Ninguno>
     // Retorno    : <Ninguno>
     //-------------------------------------------------------------------------

     function _PhpGraph ()
     {
        ImageDestroy($this->img);
        return;
     }

     //-------------------------------------------------------------------------
     // <DEFINICION DE  RUTINAS PARA MANEJO DE COLORES>
     //-------------------------------------------------------------------------

     //-------------------------------------------------------------------------
     // SetIndiceColor
     // Descripcion: Funcion que Devuelve el Indice para el color Espeficicado
     //              Bien sea un String, un Hexadecimal o RGB
     // Parametros : which_color - Variante - pueden ser '#AABBCC', 'Colorname', o array(r,g,b)
     // Retorno    : Indice del Color
     //-------------------------------------------------------------------------
     function SetIndiceColor($which_color)
     {
         list ($r, $g, $b) = $this->SetColorRGB($which_color);  //Translate to RGB
         $index = ImageColorExact($this->img, $r, $g, $b);
         if ($index == -1) {
             return ImageColorResolve($this->img, $r, $g, $b);
         } else {
             return $index;
         }
     }

     //-------------------------------------------------------------------------
     // SetIndiceColorOscuro
     // Descripcion: Retorna un Indice del color levemente más oscuro del que se
     //              esta pidiendo
     // Parametros : which_color - array (R,G,B) - arreglo de colores
     // Retorno    : Color Resultante
     //-------------------------------------------------------------------------

     function SetIndiceColorOscuro($which_color)
     {
         list ($r, $g, $b) = $this->SetColorRGB($which_color);

         $r -= 0x30;     $r = ($r < 0) ? 0 : $r;
         $g -= 0x30;     $g = ($g < 0) ? 0 : $g;
         $b -= 0x30;     $b = ($b < 0) ? 0 : $b;

         $index = ImageColorExact($this->img, $r, $g, $b);
         if ($index == -1) {
             return ImageColorResolve($this->img, $r, $g, $b);
         } else {
             return $index;
         }
     }

     //-------------------------------------------------------------------------
     // SetEstilosxDefecto
     // Descripcion: Escoge o Revierte todos los colores y estilos a sus valores por
     //              defectos, si se fija una sesion se ponen al dia solamente los indices
     //              mientras que se pierden con cada ejecución de la escritura en el otro
     //
     // Parametros : <Ninguno>
     // Retorno    : <Ninguno>
     //-------------------------------------------------------------------------

     function SetEstilosxDefecto()
     {
         // Algunas de las funciones de Set*() utilizan los valores
         // prefijados cuando no consiguen ningún parámetro.

         if (! isset($this->session_set)) {
             // si el uso de sesion  esta activo se mantiene el valor de la variable,
             // para ejecuciones futuras, la tendremos disponible,
             // asi como los nombres de colores (aunque no lo indices, eso porque
             // necesitamos reconstruirla)
             $this->session_set = TRUE;

             // These only need to be set once
             $this->SetAnchoLineas();
             $this->SetEstilosLineas();
             $this->SetDefaultDashedStyle($this->dashed_style);
             $this->SetTamanioPunto($this->points_sizes);
         }

         $this->SetColorBordeImagen($this->i_border);
         $this->SetColorFondoGrafico($this->plot_bg_color);
         $this->SetColorFondo($this->bg_color);
         $this->SetColorEtiqueta($this->label_color);
         $this->SetColorTexto($this->text_color);
         $this->SetColorGrid($this->grid_color);
         $this->SetLightColorGrid($this->light_grid_color);
         $this->SetColorMarca($this->tick_color);
         $this->SetColorTitulo($this->title_color);
         $this->SetColoresData();
         $this->SetColoresBarrasError();
         $this->SetColoresBordesData();
     }

     //-------------------------------------------------------------------------
     // SetColorFondo
     // Descripcion: Seleciona el color de Fondo
     //
     // Parametros : which_color -Variante - pueden ser '#AABBCC', 'Colorname', o array(r,g,b)
     // Retorno    : <Ninguno>
     //-------------------------------------------------------------------------

     function SetColorFondo($which_color)
     {
         $this->bg_color= $which_color;
         $this->ndx_bg_color= $this->SetIndiceColor($this->bg_color);
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetColorFondoGrafico
     // Descripcion: Seleciona el color de Fondo del Grafico
     //
     // Parametros : which_color -Variante - pueden ser '#AABBCC', 'Colorname', o array(r,g,b)
     // Retorno    : Estado - TRUE
     //-------------------------------------------------------------------------
     function SetColorFondoGrafico($which_color)
     {
         $this->plot_bg_color= $which_color;
         $this->ndx_plot_bg_color= $this->SetIndiceColor($this->plot_bg_color);
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetColorTitulo
     // Descripcion: Seleciona el color del Titulo del Grafico
     //
     // Parametros : which_color - Variante - pueden ser '#AABBCC', 'Colorname', o array(r,g,b)
     // Retorno    : Estado - TRUE
     //-------------------------------------------------------------------------
     function SetColorTitulo($which_color)
     {
         $this->title_color= $which_color;
         $this->ndx_title_color= $this->SetIndiceColor($this->title_color);
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetColorMarca
     // Descripcion: Seleciona el color de las Marcas
     //
     // Parametros : which_color - Variante - pueden ser '#AABBCC', 'Colorname', o array(r,g,b)
     // Retorno    : Estado - TRUE
     //-------------------------------------------------------------------------
     function SetColorMarca ($which_color)
     {
         $this->tick_color= $which_color;
         $this->ndx_tick_color= $this->SetIndiceColor($this->tick_color);
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetColorEtiqueta
     // Descripcion: Seleciona el color de las Etiquetas
     //
     // Parametros : which_color - Variante - pueden ser '#AABBCC', 'Colorname', o array(r,g,b)
     // Retorno    : Estado - TRUE
     //-------------------------------------------------------------------------
     function SetColorEtiqueta ($which_color)
     {
         $this->label_color = $which_color;
         $this->ndx_title_color= $this->SetIndiceColor($this->label_color);
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetColorTexto
     // Descripcion: Seleciona el color de Texto
     //
     // Parametros : which_color - Variante - pueden ser '#AABBCC', 'Colorname', o array(r,g,b)
     // Retorno    : Estado - TRUE
     //-------------------------------------------------------------------------
     function SetColorTexto ($which_color)
     {
         $this->text_color= $which_color;
         $this->ndx_text_color= $this->SetIndiceColor($this->text_color);
         return TRUE;
     }


     //-------------------------------------------------------------------------
     // SetLightColorGrid
     // Descripcion: Seleciona el color Ligth de Rejilla
     //
     // Parametros : which_color - Variante - pueden ser '#AABBCC', 'Colorname', o array(r,g,b)
     // Retorno    : Estado - TRUE
     //-------------------------------------------------------------------------
     function SetLightColorGrid ($which_color)
     {
         $this->light_grid_color= $which_color;
         $this->ndx_light_grid_color= $this->SetIndiceColor($this->light_grid_color);
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetColorGrid
     // Descripcion: Seleciona el color de Rejilla
     //
     // Parametros : which_color - Variante - pueden ser '#AABBCC', 'Colorname', o array(r,g,b)
     // Retorno    : Estado - TRUE
     //-------------------------------------------------------------------------
     function SetColorGrid ($which_color)
     {
         $this->grid_color = $which_color;
         $this->ndx_grid_color= $this->SetIndiceColor($this->grid_color);
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetColorBordeImagen
     // Descripcion: Seleciona el color del Borde de la Imagen del Grafico
     //
     // Parametros : which_color - Variante - pueden ser '#AABBCC', 'Colorname', o array(r,g,b)
     // Retorno    : Estado - TRUE
     //-------------------------------------------------------------------------
     function SetColorBordeImagen($which_color)
     {
         $this->i_border = $which_color;
         $this->ndx_i_border = $this->SetIndiceColor($this->i_border);
         $this->ndx_i_border_dark = $this->SetIndiceColorOscuro($this->i_border);
         return TRUE;
     }


     //-------------------------------------------------------------------------
     // SetColorTransparente
     // Descripcion: Seleciona el color de Transparencia de la Imagen del Grafico
     //
     // Parametros : which_color - Variante - pueden ser '#AABBCC', 'Colorname', o array(r,g,b)
     // Retorno    : Estado - TRUE
     //-------------------------------------------------------------------------
     function SetColorTransparente($which_color)
     {
         ImageColorTransparent($this->img, $this->SetIndiceColor($which_color));
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetArrayRGB
     // Descripcion: Seleciona el Arreglo de colores a ser usado. esto permite
     //              que el usuario defina un arreglo pequeño de colores (small),
     //              o Grande Incluyendo la el archivo RGB.php
     //
     // Parametros : which_color_array - Variante - pueden ser un array(r,g,b) o un String
     //              valores admisibles 'small' o 'large'
     // Retorno    : Estado - TRUE
     //-------------------------------------------------------------------------
     function SetArrayRGB ($which_color_array)
     {
         if ( is_array($which_color_array) ) {           // Definido por el Usuario
             $this->rgb_array = $which_color_array;
             return TRUE;
         } elseif ($which_color_array == 'small') {      // 'small' colores por defecto arreglo pequeño
             $this->rgb_array = array(
                 'white'          => array(255, 255, 255),
                 'snow'           => array(255, 250, 250),
                 'PeachPuff'      => array(255, 218, 185),
                 'ivory'          => array(255, 255, 240),
                 'lavender'       => array(230, 230, 250),
                 'black'          => array(  0,   0,   0),
                 'DimGrey'        => array(105, 105, 105),
                 'gray'           => array(190, 190, 190),
                 'grey'           => array(190, 190, 190),
                 'navy'           => array(  0,   0, 128),
                 'SlateBlue'      => array(106,  90, 205),
                 'blue'           => array(  0,   0, 255),
                 'SkyBlue'        => array(135, 206, 235),
                 'cyan'           => array(  0, 255, 255),
                 'DarkGreen'      => array(  0, 100,   0),
                 'green'          => array(  0, 255,   0),
                 'YellowGreen'    => array(154, 205,  50),
                 'yellow'         => array(255, 255,   0),
                 'orange'         => array(255, 165,   0),
                 'gold'           => array(255, 215,   0),
                 'peru'           => array(205, 133,  63),
                 'beige'          => array(245, 245, 220),
                 'wheat'          => array(245, 222, 179),
                 'tan'            => array(210, 180, 140),
                 'brown'          => array(165,  42,  42),
                 'salmon'         => array(250, 128, 114),
                 'red'            => array(255,   0,   0),
                 'pink'           => array(255, 192, 203),
                 'maroon'         => array(176,  48,  96),
                 'magenta'        => array(255,   0, 255),
                 'violet'         => array(238, 130, 238),
                 'plum'           => array(221, 160, 221),
                 'orchid'         => array(218, 112, 214),
                 'purple'         => array(160,  32, 240),
                 'azure1'         => array(240, 255, 255),
                 'aquamarine1'    => array(127, 255, 212)
                 );
             return TRUE;
         } elseif ($which_color_array === 'large')  {    // Arreglos de colores grandes
             include("./RGB.php");
             $this->rgb_array = $RGBArray;
         } else {                                        // por defecto color blanco y negro solamente.
             $this->rgb_array = array('white' => array(255, 255, 255), 'black' => array(0, 0, 0));
         }

         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetColorRGB
     // Descripcion: Funcion que devuelve un arreglo en RGB, con formato de 255 colores
     //
     // Parametros :  color_asked - Variante - pueden ser '#AABBCC', 'Colorname', o array(r,g,b)
     // Retorno    :  Color consultado
     //-------------------------------------------------------------------------
     function SetColorRGB($color_asked)
     {
         if ($color_asked == '') { $color_asked = array(0, 0, 0); };

         if ( count($color_asked) == 3 ) {    // already array of 3 rgb
                $ret_val =  $color_asked;
         } else {                             // asking for a color by string
             if(substr($color_asked, 0, 1) == '#') {         // asking in #FFFFFF format.
                 $ret_val = array(hexdec(substr($color_asked, 1, 2)), hexdec(substr($color_asked, 3, 2)),
                                   hexdec(substr($color_asked, 5, 2)));
             } else {                                        // asking by color name
                 $ret_val = $this->rgb_array[$color_asked];
             }
         }
         return $ret_val;
     }


     //-------------------------------------------------------------------------
     // SetColoresData
     // Descripcion: Asigna el color de los datos
     //
     // Parametros : which_data   - Variante - Color  de la data  puede ser '#AABBCC', 'Colorname', o array(r,g,b)
     //                                        Valor por Defecto NULL se utilizan los colores de data_colors
     //              which_border - Variante - color de los bordes puede ser '#AABBCC', 'Colorname', o array(r,g,b)
     // Retorno    : <Ninguno>
     //-------------------------------------------------------------------------
     function SetColoresData($which_data = NULL, $which_border = NULL)
     {
         if (is_null($which_data) && is_array($this->data_colors)) {
             // Utilizando los colores definidos en data_colors
         } else if (! is_array($which_data)) {
             $this->data_colors = ($which_data) ? array($which_data) : array('blue', 'red', 'green', 'orange');
         } else {
             $this->data_colors = $which_data;
         }

         $i = 0;
         foreach ($this->data_colors as $col) {
             $this->ndx_data_colors[$i] = $this->SetIndiceColor($col);
             $this->ndx_data_dark_colors[$i] = $this->SetIndiceColorOscuro($col);
             $i++;
         }

         // Para la compatibilidad de colores
         $this->SetColoresBordesData($which_border);
     }

     //-------------------------------------------------------------------------
     // SetColoresBordesData
     // Descripcion: Asigna el color de los datos
     //
     // Parametros : which_br   - Variante - Color  de los bordes  puede ser '#AABBCC', 'Colorname', o array(r,g,b)
     // Retorno    : <Ninguno>
     //-------------------------------------------------------------------------

     function SetColoresBordesData($which_br = NULL)
     {
         if (is_null($which_br) && is_array($this->data_border_colors)) {
             // Utilizando los colores definidos en data_colors
         } else if (! is_array($which_br)) {
             // Crea un nuevo arreglo con el color especificado
             $this->data_border_colors = ($which_br) ? array($which_br) : array('black');
         } else {
             $this->data_border_colors = $which_br;
         }

         $i = 0;
         foreach($this->data_border_colors as $col) {
             $this->ndx_data_border_colors[$i] = $this->SetIndiceColor($col);
             $i++;
         }
     }

     //-------------------------------------------------------------------------
     // SetColoresBarrasError
     // Descripcion: Asigna el color de los datos
     //
     // Parametros : which_err   - Variante - Color  de las barras de errores
     //                                       puede ser '#AABBCC', 'Colorname', o array(r,g,b)
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function SetColoresBarrasError($which_err = NULL)
     {
         if (is_null($which_err) && is_array($this->error_bar_colors)) {
             // use already set error_bar_colors
         } else if (! is_array($which_err)) {
             $this->error_bar_colors = ($which_err) ? array($which_err) : array('black');
         } else {
             $this->error_bar_colors = $which_err;
         }

         $i = 0;
         foreach($this->error_bar_colors as $col) {
             $this->ndx_error_bar_colors[$i] = $this->SetIndiceColor($col);
             $i++;
         }
         return TRUE;

     }

     //-------------------------------------------------------------------------
     // SetDefaultDashedStyle
     // Descripcion: Asigna el estilo por defecto de lineas
     //
     // Parametros : which_style   - String - Secuencia que especifica el orden de coloreado
     //                                       y trasparencia de los Puntos, por ejemplo:
     //                                       '4-3' significa 4 Color, 3 Transparencia
     //                                       '2-3-1-2' significa 2 color, 3 transparencias
     //                                       1 color, 2 transparencia
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function SetDefaultDashedStyle($which_style)
     {
         // String: "numcol-numtrans-numcol-numtrans..."
         $asked = explode('-', $which_style);

         if (count($asked) < 2) {
             $this->MostrarError("SetDefaultDashedStyle(): Problema en parámetro '$which_style'.");
             return FALSE;
         }

         // Construye el string para ser evaluado luego por SetDashedStyle()
         //
         $this->default_dashed_style = 'array( ';

         $t = 0;
         foreach($asked as $s) {
             if ($t % 2 == 0) {
                 $this->default_dashed_style .= str_repeat('$which_ndxcol,', $s);
             } else {
                 $this->default_dashed_style .= str_repeat('IMG_COLOR_TRANSPARENT,', $s);
             }
             $t++;
         }

         // Quita la coma que se trae y se cierra con parentesis
         //
         $this->default_dashed_style = substr($this->default_dashed_style, 0, -1);
         $this->default_dashed_style .= ')';

         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetDashedStyle
     // Descripcion: Asigna el estilo antes de dibujar una linea
     //
     // Parametros : which_ndxcol   -  - Parametro con el indice del color a ser usado
     // Retorno    : TRUE si todo se llevó a cabo correctamente, FALSE en caso de fallo.
     //-------------------------------------------------------------------------
     function SetDashedStyle($which_ndxcol)
     {
         // ver SetDefaultDashedStyle() para comprender este codigo.
         eval ("\$style = $this->default_dashed_style;");
         return imagesetstyle($this->img, $style);
     }

     //-------------------------------------------------------------------------
     // SetAnchoLineas
     // Descripcion: Fija el ancho de las líneas
     //
     // Parametros : which_lw   - array - Por defecto el valor NULL permite usar
     //                                   los valores por defecto
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function SetAnchoLineas($which_lw=NULL)
     {
         if (is_null($which_lw)) {
             // No hace nada utiliza el valor por defecto.
         } else if (is_array($which_lw)) {
             // Se Asigna un vector con los anchos de Lineas
             $this->line_widths = $which_lw;
         } else {
             $this->line_widths = array($which_lw);
         }
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetEstilosLineas
     // Descripcion: Fija el Estilo de Lineas
     //
     // Parametros : which_ls   - array - Por defecto el valor NULL permite usar
     //                                   los valores por defecto
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function SetEstilosLineas($which_ls=NULL)
     {
         if (is_null($which_ls)) {
             // No hace nada, usa el valor por defecto.
         } else if (is_array($which_ls)) {
             // Asignar una arreglo con los Estilos?
             $this->line_styles = $which_ls;
         } else {
             $this->line_styles = ($which_ls) ? array($which_ls) : array('solid');
         }
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // <FIN DE DEFINICION DE  RUTINAS PARA MANEJO DE COLORES>
     //-------------------------------------------------------------------------

     //-------------------------------------------------------------------------
     // <DEFINICION DE  RUTINAS PARA FUENTES>
     //-------------------------------------------------------------------------

     //-------------------------------------------------------------------------
     // SetEspaciosLineas
     // Descripcion: Fija el numero de pixeles, entre lineas de un mismo texto
     //
     // Parametros : which_spc   - Entero - numero de pixeles a asignar
     // Retorno    : <Ninguno>
     //-------------------------------------------------------------------------
     function SetEspaciosLineas($which_spc)
     {
         $this->line_spacing = $which_spc;
     }

     //-------------------------------------------------------------------------
     // SetUsarTTF
     // Descripcion: Permite el uso de las fuentes TrueType en el Grafico,
     //              Metodo para inicialización de Fuente depende estó.
     // Parametros : which_spc   - Logico - TRUE Activa el uso de Fuentes TrueType
     //                                      False usa fuente por defecto
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function SetUsarTTF($which_ttf)
     {
         $this->use_ttf = $which_ttf;
         if ($which_ttf)
             $this->SetFuentesxDefecto();
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetRutaFuentesTTF
     // Descripcion: Permite Configurar el directorio donde se encuentran las
     //              fuentes TrueType.
     // Parametros : which_path   - String - Directorio donde se encuentran las fuentes
     // Retorno    : TRUE si el patch es correcto, FALSE Directorio Invalido.
     //-------------------------------------------------------------------------
     function SetRutaFuentesTTF($which_path)
     {
         // Quizas si alguien necesita usar dinamicamente necesitara esto
         // clearstatcache();

         if (is_dir($which_path) && is_readable($which_path)) {
             $this->ttf_path = $which_path;
             return TRUE;
         } else {
             $this->PrintError("SetRutaFuentesTTF(): $which_path no es una ruta valida.");
             return FALSE;
         }
     }

     //-------------------------------------------------------------------------
     // SetTTFontxDefecto
     // Descripcion: Fija la fuente TrueType por defecto y actualiza todas para la misma.
     // Parametros : which_font   - String - Fuente
     // Retorno    : TRUE si el patch es correcto, FALSE Directorio Invalido.
     //-------------------------------------------------------------------------
     function SetTTFontxDefecto($which_font)
     {
         if (is_file($which_font) && is_readable($which_font)) {
             $this->default_ttfont = $which_font;
             return $this->SetFuentesxDefecto();
         } else {
             $this->PrintError("SetTTFontxDefecto(): $which_font no es un archivo valido de fuente.");
             return FALSE;
         }
     }

     //-------------------------------------------------------------------------
     // SetFuentesxDefecto
     // Descripcion: Fija fuentes TrueType a sus valores por defecto.
     // Parametros : <Ninguno>
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------
     function SetFuentesxDefecto()
     {
         // TTF:
         if ($this->use_ttf) {
             //$this->SetRutaFuentesTTF(dirname($_SERVER['PHP_SELF']));
             $this->SetRutaFuentesTTF(getcwd());
             $this->SetFuente('generic', $this->default_ttfont, 8);
             $this->SetFuente('title', $this->default_ttfont, 14);
             $this->SetFuente('legend', $this->default_ttfont, 8);
             $this->SetFuente('x_label', $this->default_ttfont, 6);
             $this->SetFuente('y_label', $this->default_ttfont, 6);
             $this->SetFuente('x_title', $this->default_ttfont, 10);
             $this->SetFuente('y_title', $this->default_ttfont, 10);
         }
         // Fixed:
         else {
             $this->SetFuente('generic', 2);
             $this->SetFuente('title', 5);
             $this->SetFuente('legend', 2);
             $this->SetFuente('x_label', 1);
             $this->SetFuente('y_label', 1);
             $this->SetFuente('x_title', 3);
             $this->SetFuente('y_title', 3);
         }

         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetFuente
     // Descripcion: Fija parámetros de la fuente de Fixed/Truetype.
     // Parametros : which_elem   - String - es el elemento de la fuente que debe
     //                                      ser cambiado. los valores admisibles son:
     //                                      'title', 'legend', 'generic','x_label',
     //                                      'y_label', x_title' or 'y_title'
     //              which_font   - Variante - Puede ser un número (para los tamaños de
     //                                        fuente fijos) o una String con el nombre
     //                                        de fichero al usar TTFonts
     //              which_size   - Entero   - El tamaño del punto (TTF solamente).
     //                                        se calcula y se actualiza el alto y ancho de las variables internas.
     // Retorno    : TRUE si se aplicó de forma correcta, FALSE en caso contrario.
     //-------------------------------------------------------------------------
     function SetFuente($which_elem, $which_font, $which_size = 12)
     {
         // TTF:
         if ($this->use_ttf) {
             $path = $this->ttf_path.'/'.$which_font;

             if (! is_file($path) || ! is_readable($path) ) {
                 $this->MostrarError("SetFuente(): True Type font $path no existe");
                 return FALSE;
             }

             switch ($which_elem) {
             case 'generic':
                 $this->generic_font['font'] = $path;
                 $this->generic_font['size'] = $which_size;
                 break;
             case 'title':
                 $this->title_font['font'] = $path;
                 $this->title_font['size'] = $which_size;
                 break;
             case 'legend':
                 $this->legend_font['font'] = $path;
                 $this->legend_font['size'] = $which_size;
                 break;
             case 'x_label':
                 $this->x_label_font['font'] = $path;
                 $this->x_label_font['size'] = $which_size;
                 break;
             case 'y_label':
                 $this->y_label_font['font'] = $path;
                 $this->y_label_font['size'] = $which_size;
                 break;
             case 'x_title':
                 $this->x_title_font['font'] = $path;
                 $this->x_title_font['size'] = $which_size;
                 break;
             case 'y_title':
                 $this->y_title_font['font'] = $path;
                 $this->y_title_font['size'] = $which_size;
                 break;
             default:
                 $this->MostrarError("SetFuente(): Elemento especificado desconocido '$which_elem'.");
                 return FALSE;
             }
             return TRUE;

         }

         // Fixed fonts:
         if ($which_font > 5 || $which_font < 0) {
             $this->MostrarError('SetFuente(): No es-TTF Fuente el tamaño debe ser 1, 2, 3, 4 or 5');
             return FALSE;
         }

         switch ($which_elem) {
         case 'generic':
             $this->generic_font['font'] = $which_font;
             $this->generic_font['height'] = ImageFontHeight($which_font);
             $this->generic_font['width'] = ImageFontWidth($which_font);
             break;
         case 'title':
            $this->title_font['font'] = $which_font;
            $this->title_font['height'] = ImageFontHeight($which_font);
            $this->title_font['width'] = ImageFontWidth($which_font);
            break;
         case 'legend':
             $this->legend_font['font'] = $which_font;
             $this->legend_font['height'] = ImageFontHeight($which_font);
             $this->legend_font['width'] = ImageFontWidth($which_font);
             break;
         case 'x_label':
             $this->x_label_font['font'] = $which_font;
             $this->x_label_font['height'] = ImageFontHeight($which_font);
             $this->x_label_font['width'] = ImageFontWidth($which_font);
             break;
         case 'y_label':
             $this->y_label_font['font'] = $which_font;
             $this->y_label_font['height'] = ImageFontHeight($which_font);
             $this->y_label_font['width'] = ImageFontWidth($which_font);
             break;
         case 'x_title':
             $this->x_title_font['font'] = $which_font;
             $this->x_title_font['height'] = ImageFontHeight($which_font);
             $this->x_title_font['width'] = ImageFontWidth($which_font);
             break;
         case 'y_title':
             $this->y_title_font['font'] = $which_font;
             $this->y_title_font['height'] = ImageFontHeight($which_font);
             $this->y_title_font['width'] = ImageFontWidth($which_font);
             break;
         default:
             $this->MostrarError("SetFuente(): Elemento espeficifcado desconocido '$which_elem'.");
             return FALSE;
         }
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // TTFBBoxSize
     // Descripcion: Retorna un arreglo con el tamaño alto y ancho para el texto
     //              espeficado, con el angulo, y fuente señalada.
     // Parametros : size   - Numerico - es el tamaño del texto a mostrar
     //              angle  - Real     - es el angulo para calcular la fuente
     //              font   - String   - es el nombre de la fuente
     //              string - String   - es el texto a calcular el ancho y Alto
     // Retorno    : Arreglo con el ancho y el alto para el texto espeficado.
     //-------------------------------------------------------------------------
     function TTFBBoxSize($size, $angle, $font, $string)
     {
         // Primeramente,asume el angulo < 90
         //
         $arr = ImageTTFBBox($size, 0, $font, $string);
         $flat_width  = $arr[2] - $arr[0];
         $flat_height = abs($arr[3] - $arr[5]);

         // Ahora el area limite
         //
         $angle = deg2rad($angle);
         $width  = ceil(abs($flat_width*cos($angle) + $flat_height*sin($angle))); //Must be integer
         $height = ceil(abs($flat_width*sin($angle) + $flat_height*cos($angle))); //Must be integer

         return array($width, $height);
     }

     //-------------------------------------------------------------------------
     // MostrarTexto
     // Descripcion: Dibuja una secuencia de texto. tomando en cuenta la alineacion
     //              Horizontal y vertical para el dibujado. Esto Es: Texto Vertical (90º)
     //              consigue centro a lo largo de y-axis con v_align = 'center',
     //              y Ajuste para la izquierda de el x-axis con h_align = 'right'
     //
     // Parametros : which_font   - String   - Fuente para el Texto
     //              which_angle  - Real     - Angulo para la Fuente
     //              which_xpos   - Entero   - Posicion en X
     //              which_ypos   - Entero   - Posicion en Y
     //              which_color  - Variante - Color para el Texto
     //              which_text   - Texto    - Texto a mostrar
     //              which_halign - String   - Alineación horizontal : 'left', 'rigth'
     //              which_valign - String   - Alineación Vertical   : 'bottom'
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function MostrarTexto($which_font, $which_angle, $which_xpos, $which_ypos,
                       $which_color, $which_text, $which_halign = 'left',
                       $which_valign = 'bottom')
     {
         // TTF:
         if ($this->use_ttf) {
             $size = $this->TTFBBoxSize($which_font['size'], $which_angle, $which_font['font'], $which_text);
             $rads = deg2rad($which_angle);

             if ($which_valign == 'center')
                 $which_ypos += $size[1]/2;

             if ($which_valign == 'bottom')
                 $which_ypos += $size[1];

             if ($which_halign == 'center')
                 $which_xpos -= ($size[0]/2) * cos($rads);

             if ($which_halign == 'left')
                 $which_xpos += $size[0] * sin($rads);

             if ($which_halign == 'right')
                 $which_xpos -= $size[0] * cos($rads);

             ImageTTFText($this->img, $which_font['size'], $which_angle,
                          $which_xpos, $which_ypos, $which_color, $which_font['font'], $which_text);
         }
         //Fuentes Fijas:
         else {
             // Separa el texto por Lineas y lo cuenta
             $which_text = ereg_replace("\r", "", $which_text);
             $str = split("\n", $which_text);
             $nlines = count($str);
             $spacing = $this->line_spacing * ($nlines - 1);

             //  Texto Vertical:
             // (Recordar la alineación para el texto vertical)
             if ($which_angle == 90) {
                 // El texto ira centrado $which_xpos.
                 if ($which_halign == 'center')
                     $which_xpos -= ($nlines * ($which_font['height'] + $spacing))/2;

                 // Alineación a la izquierda no necesita modificacion en $xpos...
                 // Right-align. $which_xpos colocada a la derecha de la coordenada X
                 else if ($which_halign == 'right')
                     $which_xpos += ($nlines * ($which_font['height'] + $spacing));

                 $ypos = $which_ypos;
                 for($i = 0; $i < $nlines; $i++) {
                     // Centra el texto verticalamente alrededor  de $which_ypos (cada linea)
                     if ($which_valign == 'center')
                         $ypos = $which_ypos + (strlen($str[$i]) * $which_font['width']) / 2;
                     // Hacer que el texto verticalmente termine en $which_ypos
                     if ($which_valign == 'bottom')
                         $ypos = $which_ypos + strlen($str[$i]) * $which_font['width'];

                     ImageStringUp($this->img, $which_font['font'],
                                   $i * ($which_font['height'] + $spacing) + $which_xpos,
                                   $ypos, $str[$i], $which_color);
                 }
             }
             // Texto Horizontal:
             else {
                 // El Texto Pasa por encima $which_ypos
                 if ($which_valign == 'top')
                     $which_ypos -= $nlines * ($which_font['height'] + $spacing);
                 // el texto es alineado centralmente en  $which_ypos
                 if ($which_valign == 'center')
                     $which_ypos -= ($nlines * ($which_font['height'] + $spacing))/2;
                 // valign = 'bottom' requiere no modificación

                 $xpos = $which_xpos;
                 for($i = 0; $i < $nlines; $i++) {
                     // El texto es centrado en $which_xpos
                     if ($which_halign == 'center')
                         $xpos = $which_xpos - (strlen($str[$i]) * $which_font['width'])/2;
                     // Hacer que el texto termine exactamente en $which_xpos
                     if ($which_halign == 'right')
                         $xpos = $which_xpos - strlen($str[$i]) * $which_font['width'];

                     ImageString($this->img, $which_font['font'], $xpos,
                                 $i * ($which_font['height'] + $spacing) + $which_ypos,
                                 $str[$i], $which_color);
                 }
             }
         }
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // <FIN DE DEFINICION DE  RUTINAS PARA FUENTES>
     //-------------------------------------------------------------------------

     //-------------------------------------------------------------------------
     // <DEFINICION DE RUTINAS PARA CONTROL DE ENTRADA Y SALIDA>
     //-------------------------------------------------------------------------

     //-------------------------------------------------------------------------
     // SetFormatoArchivo
     // Descripcion: Fija el formato de salida de la imagen, condición en linea, o cache.
     // Parametros : which_file_format   - String   - Formato de Salida, validos :
     //                                               'jpg','png','wbmp'
     // Retorno    : TRUE si el formato es soportado, FALSE en caso contrario.
     //-------------------------------------------------------------------------
     function SetFormatoArchivo($which_file_format)
     {
         $asked = strtolower($which_file_format);
         switch ($asked) {
         case 'jpg':
             if (imagetypes() & IMG_JPG)
                 return TRUE;
             break;
         case 'png':
             if (imagetypes() & IMG_PNG)
                 return TRUE;
             break;
         case 'gif':
             if (imagetypes() & IMG_GIF)
                 return TRUE;
             break;
         case 'wbmp':
             if (imagetypes() & IMG_WBMP)
                 return TRUE;
             break;
         default:
             $this->PrintError("SetFormatoArchivo(): Formato no reconocido '$which_file_format'");
             return FALSE;
         }
         $this->PrintError("SetFormatoArchivo():el formato del archivo '$which_file_format' no es soportado");
         return FALSE;
     }

     //-------------------------------------------------------------------------
     // SetArchivoEntrada
     // Descripcion: Selecciona un archivo de una a imagen para fondo del grafico entero.
     // Parametros : which_input_file   - String   - Nombre del archivo
     //              aBgType            - Entero   - 0: Tamaño de la imagen de fondo
     //                                                   para el grafico
     //                                              1: Tamaño ajustado a el Alto y Ancho
     //                                                   del grafico completo
     //                                              2: Solo al area del gráfico
     //              TruthfulColors     - Logico   - TRUE : Usar color Verdadero, solo
     //                                                     si la librería GD2 esta activa
     //                                              FALSE : Usar transparencia en el fondo
     // Retorno    : TRUE si se logró establecer la imagen, FALSE en caso contrario.
     //-------------------------------------------------------------------------
     function SetArchivoEntrada($which_input_file,$aBgType=0,$TruthfulColors=TRUE)
     {
         $this->input_file = $which_input_file;
    	   $size = GetImageSize($which_input_file);
         $input_type = $size[2];

         switch($input_type) {
         case 1:
             $im = @ImageCreateFromGIF ($which_input_file);
             if (!$im) { // Muestra si falla
                 $this->PrintError("No se pudo abrir $which_input_file como un GIF");
                 return FALSE;
             }
         break;
         case 3:
             $im = @ImageCreateFromPNG ($which_input_file);
             if (!$im) { // Muestra si falla
                 $this->PrintError("No se logró abrir $which_input_file como un PNG");
                 return FALSE;
             }
         break;
         case 2:
   		    $im = @ImageCreateFromJPEG ($which_input_file);
             if (!$im) { // Muestra si falla
                 $this->PrintError("No se logró abrir $which_input_file como un JPG");
                 return FALSE;
             }
         break;
         default:
             $this->PrintError('SetArchivoEntrada(): Por favor seleccione tipos de imágenes en formato gif, jpg, or png !');
             return FALSE;
         break;
         }

         $Width_new = $this->image_width;
         $Height_new = $this->image_height;

         // Fija el Ancho y Alto de la Imagen, de acuerdo al estilo
         //
         switch($aBgType){
            case 0:
               $this->image_width = $size[0];
               $this->image_height = $size[1];
               $Width_new = $size[0];
               $Height_new = $size[1];
            break;
         }

         if ($TruthfulColors && CheckGDVersion()==2){
            $imageAux = imagecreatetruecolor($Width_new, $Height_new);
         }
         else {
            $imageAux = imagecreate    ($Width_new, $Height_new);
         }

         imagecopyresized($imageAux, $im, 0, 0, 0, 0, $Width_new, $Height_new, $size[0], $size[1]);

         // Libera el recurso utilizado
         if ($this->img) {
            imagedestroy($this->img);
    		}
         
         $this->img = $imageAux;
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetArchivoSalida
     // Descripcion: Selecciona un archivo de salida.
     // Parametros : which_output_file   - String   - Nombre del archivo de salida
     // Retorno    : TRUE si se logró establecer la imagen, FALSE en caso contrario.
     //-------------------------------------------------------------------------
     function SetArchivoSalida($which_output_file)
     {
         $this->output_file = $which_output_file;
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetEsEnlinea
     // Descripcion: Selecciona la imagen de salida como 'inline'. No envia
     //              los encabezados del tipo de contenido Content-Type al browser.
     //              Muy útil si usted desea encajar las imágenes
     // Parametros : which_ii   - LOGICO   - TRUE Activa o  FALSE desactiva opcion
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------
     function SetEsEnlinea($which_ii)
     {
         $this->is_inline = $which_ii;
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // PrintImagen
     // Descripcion: Realiza la salida de la imagen actual con el formato espeficicado
     //              en file_format para el gráfico generado y luego destruye
     //              la imagen de recurso usada
     // Parametros : <Ninguno>
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------
     function PrintImagen()
     {
         //
         if ( (! $this->browser_cache) && (! $this->is_inline)) {
             header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
             header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
             header('Cache-Control: no-cache, must-revalidate');
             header('Pragma: no-cache');
         }

         switch($this->file_format) {
         case 'png':
             if (! $this->is_inline) {
                 Header('Content-type: image/png');
             }
             if ($this->is_inline && $this->output_file != '') {
                 ImagePng($this->img, $this->output_file);
             } else {
                 ImagePng($this->img);
             }
             break;
         case 'jpg':
             if (! $this->is_inline) {
                 Header('Content-type: image/jpeg');
             }
             if ($this->is_inline && $this->output_file != '') {
                 ImageJPEG($this->img, $this->output_file);
             } else {
                 ImageJPEG($this->img);
             }
             break;
         case 'gif':
             if (! $this->is_inline) {
                 Header('Content-type: image/gif');
             }
             if ($this->is_inline && $this->output_file != '') {
                 ImageGIF($this->img, $this->output_file);
             } else {
                 ImageGIF($this->img);
             }

             break;
         case 'wbmp':        // Bitmap sin hilos, 2 bit.
             if (! $this->is_inline) {
                 Header('Content-type: image/wbmp');
             }
             if ($this->is_inline && $this->output_file != '') {
                 ImageWBMP($this->img, $this->output_file);
             } else {
                 ImageWBMP($this->img);
             }

             break;
         default:
             $this->PrintError('PrintImagen(): Por favor seleccione un tipo de imagen!');
             break;
         }
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // PrintError
     // Descripcion: Muestra el Mensaje de error y finaliza la ejecución del Script
     // Parametros : error_message   - String   - Texto con el mensaje de error
     // Retorno    : <Ninguno>.
     //-------------------------------------------------------------------------
     function PrintError($error_message)
     {
         echo "<p><b>Fatal error</b>: $error_message<p>";
         die;
     }

     //-------------------------------------------------------------------------
     // MostrarError
     // Descripcion: Imprime un mensaje de error en línea en la imagen generada
     //              y lo dibuja al centro alrededor de los coordenadas dadas
     //              (Por defecto al centro de la imagen)
     // Parametros : error_message   - String   - Texto con el mensaje de error a ser mostrado
     //              where_x         - Entero   - Coordenada en X, por defecto NULL al Centro
     //              where_y         - Entero   - Coordenada en Y, por defecto NULL al Centro
     // Retorno    : <Ninguno>.
     //-------------------------------------------------------------------------
     function MostrarError($error_message, $where_x = NULL, $where_y = NULL)
     {
         if (! $this->img)
             $this->PrintError('_MostrarError(): Warning, no image resource allocated. '.
                               'The message to be written was: '.$error_message);

         $ypos = (! $where_y) ? $this->image_height/2 : $where_y;
         $xpos = (! $where_x) ? $this->image_width/2 : $where_x;
         ImageRectangle($this->img, 0, 0, $this->image_width, $this->image_height,
                        ImageColorAllocate($this->img, 255, 255, 255));

         $this->MostrarTexto($this->generic_font, 0, $xpos, $ypos, ImageColorAllocate($this->img, 0, 0, 0),
                         $error_message, 'center', 'center');

         $this->PrintImagen();
         exit;
     }

     //-------------------------------------------------------------------------
     // <FIN DE DEFINICION DE RUTINAS PARA CONTROL DE ENTRADA Y SALIDA>
     //-------------------------------------------------------------------------

     //-------------------------------------------------------------------------
     // <DEFINICION DE RUTINAS PARA ETIQUETAS>
     //-------------------------------------------------------------------------

     //-------------------------------------------------------------------------
     // SetPosEtiquetasDataX
     // Descripcion: Fija la posición para las etiquetas de X después de puntos de referencias
     // Parametros : which_xdlp      - Entero   - Coordenada en X
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------
     function SetPosEtiquetasDataX($which_xdlp)
     {
         $this->x_data_label_pos = $this->ChequearOpcion($which_xdlp, 'plotdown, plotup, both, xaxis, all, none',
                                                       __FUNCTION__);
         if ($which_xdlp != 'none')
             $this->x_tick_label_pos == 'none';

         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetPosEtiquetasDataY
     // Descripcion: Fija la posición para las etiquetas de Y después de puntos de referencias
     // Parametros : which_ydlp      - Entero   - Coordenada en Y
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------
     function SetPosEtiquetasDataY($which_ydlp)
     {
         $this->y_data_label_pos = $this->ChequearOpcion($which_ydlp, 'plotleft, plotright, both, yaxis, all, none',
                                                       __FUNCTION__);
         if ($which_ydlp != 'none')
             $this->y_tick_label_pos == 'none';

         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetPosEtiquetasMarcasX
     // Descripcion: Fija la posición para las etiquetas de X que siguen las Marcas (por lo tanto líneas de rejilla)
     // Parametros : which_xtlp     - Entero  - Coordenada en X
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------
     function SetPosEtiquetasMarcasX($which_xtlp)
     {
         $this->x_tick_label_pos = $this->ChequearOpcion($which_xtlp, 'plotdown, plotup, both, xaxis, all, none',
                                                       __FUNCTION__);
         if ($which_xtlp != 'none')
             $this->x_data_label_pos == 'none';

         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetPosEtiquetasMarcasY
     // Descripcion: Fija la posición para las etiquetas de Y que siguen las Marcas (por lo tanto líneas de rejilla)
     // Parametros : which_ytlp     - Entero  - Coordenada en Y
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------
     function SetPosEtiquetasMarcasY($which_ytlp)
     {
         $this->y_tick_label_pos = $this->ChequearOpcion($which_ytlp, 'plotleft, plotright, both, yaxis, all, none',
                                                       __FUNCTION__);
         if ($which_ytlp != 'none')
             $this->y_data_label_pos == 'none';

         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetTipoEtiquetaX
     // Descripcion: Fija el tipo de etiquetas para marcas y data sobre el eje X
     // Parametros : which_xlt     - String  - Tipo de Etiquetas: 'data','Time' o 'title'
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------

     function SetTipoEtiquetaX($which_xlt)
     {
         $this->x_label_type = $this->ChequearOpcion($which_xlt, 'data, time, title', __FUNCTION__);
         return TRUE;
     }
     
     //-------------------------------------------------------------------------
     // SetTipoEtiquetaY
     // Descripcion: Fija el tipo de etiquetas para marcas y data sobre el eje Y
     // Parametros : which_ylt    - String  - Tipo de Etiquetas: 'data','Time' o 'title'
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------
     function SetTipoEtiquetaY($which_ylt)
     {
         $this->y_label_type = $this->ChequearOpcion($which_ylt, 'data, time', __FUNCTION__);
         return TRUE;
     }
    
     //-------------------------------------------------------------------------
     // SetFormatoTiempoX
     // Descripcion: Fija el formato de hora para marcas  sobre el eje X
     // Parametros : which_xtf    - String  - Formato Valido PHP
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------    
     function SetFormatoTiempoX($which_xtf)
     {
         $this->x_time_format = $which_xtf;
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetFormatoTiempoY
     // Descripcion: Fija el formato de hora para marcas  sobre el eje Y
     // Parametros : which_ytf    - String  - Formato Valido PHP
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------    
     function SetFormatoTiempoY($which_ytf)
     {
         $this->y_time_format = $which_ytf;
         return TRUE;
     }
    
     //-------------------------------------------------------------------------
     // SetAnguloEtiquetasX
     // Descripcion: Fija el angulo para las etiquetas sobre el eje X
     // Parametros : which_xla   - String  - Formato Valido PHP
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------    
     function SetAnguloEtiquetasX($which_xla)
     {
         $this->x_label_angle = $which_xla;
         return TRUE;
     }
   
     //-------------------------------------------------------------------------
     // SetAnguloEtiquetasY
     // Descripcion: Fija el angulo para las etiquetas sobre el eje Y
     // Parametros : which_yla   - String  - Formato Valido PHP
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------    
     function SetAnguloEtiquetasY($which_yla)
     {
         $this->y_label_angle = $which_yla;
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // <FIN DEFINICION DE RUTINAS PARA ETIQUETAS>
     //-------------------------------------------------------------------------

     //-------------------------------------------------------------------------
     // <DEFINICION DE RUTINAS VARIAS>
     //-------------------------------------------------------------------------

     //-------------------------------------------------------------------------
     // ChequearOpcion
     // Descripcion: Chequea la validez de una opción.
     //              Si verificando con exactitud cada opción en muchas partes
     //              podría hacer más lento el proceso, existen otros métodos
     //              más fiables pero menos confiables, por otro lado es necesario
     //              la macro __FUNCTION__ needs PHP 4.3.0   
     // Parametros : which_opt   - String  - Valor a chequear
     //              which_acc   - String  - String de Valores admitidos
     //              which_func  - String  - Nombre de la funcion que llama la función
     //                                      para mostrar errores 
     // Retorno    : String con la opción si es valida, caso contrario NULL.
     //-------------------------------------------------------------------------    
     function ChequearOpcion($which_opt, $which_acc, $which_func)
     {
        $asked = trim($which_opt);

        // Precaución: esto es para la compatibilidad dirigida hacia atrás, 
        // como la función eregi () falla con los  Strings vacíos.
        //
        if ($asked == '')
            return '';

        if (@ eregi($asked, $which_acc)) {
            return $asked;
        } else {
            $this->MostrarError("$which_func(): '$which_opt' no esta en las opciones permitidas: '$which_acc'.");
            return NULL;
        } 
     }

     //-------------------------------------------------------------------------
     // SetBrowserCache
     // Descripcion: Activa el cache en el browser.
     // Parametros : which_browser_cache   - Boolean  - TRUE para activar, FALSE desactivar
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------    

     function SetBrowserCache($which_browser_cache) 
     {
        $this->browser_cache = $which_browser_cache;
        return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetPrintImagen
     // Descripcion: Permite activar o desactivar que se muestra la ultima Imagen.
     // Parametros : which_pi   - Boolean  - TRUE para activar, FALSE desactivar
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------    
     function SetPrintImagen($which_pi) 
     {
        $this->print_image = $which_pi;
        return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetLeyenda
     // Descripcion: Fija la leyenda del grafico.
     // Parametros : which_leg   - Variante  - Si el valor no es un array, añade el string
     //                                        a la leyenda
     // Retorno    : TRUE si se Fija el valor, FALSO en caso  contrario.
     //-------------------------------------------------------------------------    
     function SetLeyenda($which_leg)
     {
        if (is_array($which_leg)) {             // usa el array
            $this->legend = $which_leg;
            return TRUE;
        } else if (! is_null($which_leg)) {     // Agrega el string
            $this->legend[] = $which_leg;
            return TRUE;
        } else {
            $this->MostrarError("SetLeyenda(): Argumento no debe ser NULL.");
            return FALSE;
        }
     }

     //-------------------------------------------------------------------------
     // SetLeyendaPixels
     // Descripcion: Fija la posición de la leyenda del grafico, especifique la
     //              posición absoluta (relativa para Esquina de la imagen arriba/Izquierda).
     //              de la leyenda superior/ Izquierda   
     // Parametros : which_x    - Entero  - Valor de la coordenada en X
     //              which_y    - Entero  - Valor de la coordenada en Y
     //              which_type - String  - Aun no implementado                          
     // Retorno    : TRUE si se Fija el valor, FALSO en caso  contrario.
     //-------------------------------------------------------------------------         
     function SetLeyendaPixels($which_x, $which_y, $which_type=NULL) 
     { 
        $this->legend_x_pos = $which_x;
        $this->legend_y_pos = $which_y;

        return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetLeyendaWorld
     // Descripcion: Especifica la posición relativa (Para el grafico Original) 
     //              posición de la leyenda es la esquina Superior/Izquierda.
     //              debe llamarse despues que se fijen las escalas superiores.
     // Parametros : which_x    - Entero  - Valor de la coordenada en X
     //              which_y    - Entero  - Valor de la coordenada en Y
     //              which_type - String  - Aun no implementado                          
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------         
     function SetLeyendaWorld($which_x, $which_y, $which_type=NULL)
     { 
        if (! $this->scale_is_set) 
            $this->CalcTranslacion();

        $this->legend_x_pos = $this->xtr($which_x);
        $this->legend_y_pos = $this->ytr($which_y);

        return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetTipoBordeTrama
     // Descripcion: Fija el Tipo de borde de la trama del Gráfico.
     // Parametros : pbt    - String  - Valor con el tipo de borde, los valores 
     //              permitidos son: left, sides, none, full
     // Retorno    : <Ninguno>.
     //-------------------------------------------------------------------------         
     function SetTipoBordeTrama($pbt)
     {
        $this->plot_border_type = $this->ChequearOpcion($pbt, 'left, sides, none, full', __FUNCTION__);
     }

     //-------------------------------------------------------------------------
     // SetTipoBordeImagen
     // Descripcion: Fija el Tipo de borde para la Imagen.
     // Parametros : sibt   - String  - Valor con el tipo de borde, los valores 
     //              permitidos son: raised, plain
     // Retorno    : <Ninguno>.
     //-------------------------------------------------------------------------          
     function SetTipoBordeImagen($sibt)
     {
         $this->image_border_type = $this->ChequearOpcion($sibt, 'raised, plain', __FUNCTION__);
     }

     //-------------------------------------------------------------------------
     // SetMostrarAreaFondoTrama
     // Descripcion: Fija si se dibuja el area de fondo del grafico.
     // Parametros : dpab      - Boolean  - Valor TRUE activa la opción, FALSE 
     //              la desactiva. 
     // Retorno    : <Ninguno>.
     //-------------------------------------------------------------------------          
     function SetMostrarAreaFondoTrama($dpab)
     {
        $this->draw_plot_area_background = (bool)$dpab;
     }

     //-------------------------------------------------------------------------
     // SetMostrarYGrid
     // Descripcion: Establece si se dibuja las  Lineas de la Rejilla en el eje Y.
     // Parametros : dyg    - Boolean  - Valor TRUE activa la opción, FALSE 
     //              la desactiva. 
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------          
     function SetMostrarYGrid($dyg)
     {
        $this->draw_y_grid = (bool)$dyg;
        return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetMostrarXGrid
     // Descripcion: Establece si se dibuja las  Lineas de la Rejilla en el eje Y.
     // Parametros : dxg    - Boolean  - Valor TRUE activa la opción, FALSE 
     //              la desactiva. 
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------          
     function SetMostrarXGrid($dxg)
     {
        $this->draw_x_grid = (bool)$dxg;
        return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetMostrarDashedGrid
     // Descripcion: Establece si se dibuja el rayado del Grafico.
     // Parametros : ddg    - Boolean  - Valor TRUE activa la opción, FALSE 
     //              la desactiva. 
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------          
     function SetMostrarDashedGrid($ddg)
     {
        $this->dashed_grid = (bool)$ddg;
        return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetMostrarLineasEtiquetasDataX
     // Descripcion: Establece si se dibuja las Lineas de los Datos del Eje X.
     // Parametros : dxdl    - Boolean  - Valor TRUE activa la opción, FALSE 
     //              la desactiva. 
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------          
     function SetMostrarLineasEtiquetasDataX($dxdl)
     {
        $this->draw_x_data_label_lines = (bool)$dxdl;
        return TRUE;
     }
  
     //-------------------------------------------------------------------------
     // SetMostrarLineasEtiquetasDataY
     // Descripcion: Establece si se dibuja las Lineas de los Datos del Eje Y.
     // Parametros : dydl    - Boolean  - Valor TRUE activa la opción, FALSE 
     //              la desactiva. 
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------          
     function SetMostrarLineasEtiquetasDataY($dydl)
     {
        $this->draw_y_data_label_lines = $dydl;
        return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetTitulo
     // Descripcion: Establece el titulo del Gráfico.
     // Parametros : which_title    - String  - Titulo del Grafico
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------          
     function SetTitulo($which_title)
     {
        $this->title_txt = $which_title;

        if ($which_title == '') {
            $this->title_height = 0;
            return TRUE;
        }            

        $str = split("\n", $which_title);
        $lines = count($str);
        $spacing = $this->line_spacing * ($lines - 1);

        if ($this->use_ttf) {
            $size = $this->TTFBBoxSize($this->title_font['size'], 0, $this->title_font['font'], $which_title);
            $this->title_height = $size[1] * $lines;
        } else {
            $this->title_height = ($this->title_font['height'] + $spacing) * $lines;
        }   
        return TRUE;
     }
   
     //-------------------------------------------------------------------------
     // SetXTitulo
     // Descripcion: Establece el titulo del Gráfico para el eje X.
     // Parametros : which_title    - String  - Titulo del eje
     //              which_xpos     - String  - Posición para el Titulo
     //                                         valores permitidos : plotleft, plotright, 
     //                                         both, none
     //              
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------          
     function SetXTitulo($which_xtitle, $which_xpos = 'plotdown')
     {
        if ($which_xtitle == '')
            $which_xpos = 'none';

        $this->x_title_pos = $this->ChequearOpcion($which_xpos, 'plotdown, plotup, both, none', __FUNCTION__);

        $this->x_title_txt = $which_xtitle;

        $str = split("\n", $which_xtitle);
        $lines = count($str);
        $spacing = $this->line_spacing * ($lines - 1);

        if ($this->use_ttf) {
            $size = $this->TTFBBoxSize($this->x_title_font['size'], 0, $this->x_title_font['font'], $which_xtitle);
            $this->x_title_height = $size[1] * $lines;
        } else {
            $this->x_title_height = ($this->y_title_font['height'] + $spacing) * $lines;
        }

        return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetYTitulo
     // Descripcion: Establece el titulo del Gráfico para el eje Y.
     // Parametros : which_title    - String  - Titulo del eje
     //              which_ypos     - String  - Posición para el Titulo
     //                                         valores permitidos : plotleft, plotright,
     //                                         both, none
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------
     function SetYTitulo($which_ytitle, $which_ypos = 'plotleft')
     {
        if ($which_ytitle == '')
            $which_ypos = 'none';

        $this->y_title_pos = $this->ChequearOpcion($which_ypos, 'plotleft, plotright, both, none', __FUNCTION__);

        $this->y_title_txt = $which_ytitle;

        $str = split("\n", $which_ytitle);
        $lines = count($str);
        $spacing = $this->line_spacing * ($lines - 1);

        if ($this->use_ttf) {
            $size = $this->TTFBBoxSize($this->y_title_font['size'], 90, $this->y_title_font['font'], 
                                       $which_ytitle);
            $this->y_title_width = $size[0] * $lines;
        } else {
            $this->y_title_width = ($this->y_title_font['height'] + $spacing) * $lines;
        }

        return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetSombreado
     // Descripcion: Fija el tamaño de la sombra para graficos de barras y de torta.
     // Parametros : which_s        - Entero  - Tamaño de la Sombra en pixeles
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------          
     function SetSombreado($which_s)
     { 
        $this->shading = (int)$which_s;
        return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetTipoGrafico
     // Descripcion: Fija el Tipo de Grafica.
     // Parametros : which_pt     - String  - Nombre del tipo de grafico
     //                                       los Tipos de graficos validos son:
     //                                       bars, stackedbars, lines, linepoints, area, points, 
     //                                       pie, thinbarline, squared   
     // Retorno    : <Ninguno>.
     //-------------------------------------------------------------------------          
     function SetTipoGrafico($which_pt)
     {
        $this->plot_type = $this->ChequearOpcion($which_pt, 
                                  'bars, stackedbars, lines, linepoints, area, points, pie, thinbarline, squared', 
                                  __FUNCTION__);
     }

     //-------------------------------------------------------------------------
     // SetPosicionEjeY
     // Descripcion: Fija la posición del eje Y de la Grafica.
     // Parametros : pos     - Entero  - Posición de la coordenada.
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------          
     function SetPosicionEjeY($pos)
     {
        $this->y_axis_position = (int)$pos;
        if (isset($this->scale_is_set)) {
            $this->CalcTranslacion();
        }
        return TRUE;
     }    

     //-------------------------------------------------------------------------
     // SetPosicionEjeX
     // Descripcion: Fija la posición del eje X de la Grafica.
     // Parametros : pos     - Entero  - Posición de la coordenada.
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------          
     function SetPosicionEjeX($pos)
     {
        $this->x_axis_position = (int)$pos;
        if (isset($this->scale_is_set)) {
            $this->CalcTranslacion();
        }
        return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetXTipoScala
     // Descripcion: Fija el tipo de escala para el eje X de la Grafica.
     // Parametros : which_xst     - String  - Tipo de Escala, los Valores Admitidos
     //                                        Son : 'linear, log'.
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------          
     function SetXTipoScala($which_xst)
     { 
        $this->xscale_type = $this->ChequearOpcion($which_xst, 'linear, log', __FUNCTION__);
        return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetYTipoScala
     // Descripcion: Fija el tipo de escala para el eje Y de la Grafica.
     // Parametros : which_yst     - String  - Tipo de Escala, los Valores Admitidos
     //                                        Son : 'linear, log'.
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------          
     function SetYTipoScala($which_yst)
     { 
        $this->yscale_type = $this->ChequearOpcion($which_yst, 'linear, log',  __FUNCTION__);
        return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetPrecisionX
     // Descripcion: Fija valor de precisión para el eje X de la Grafica.
     // Parametros : which_prec     - Real  - Valor con la precision a Fijar
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------          
     function SetPrecisionX($which_prec) 
     {
        $this->x_precision = $which_prec;
        return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetPrecisionY
     // Descripcion: Fija valor de precisión para el eje Y de la Grafica.
     // Parametros : which_prec     - Real  - Valor con la precision a Fijar
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------          
     function SetPrecisionY($which_prec) 
     {
        $this->y_precision = $which_prec;
        return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetErrorBarAnchoLineas
     // Descripcion: Fija el ancho de la lineas de barra con Error.
     // Parametros : which_seblw     - Entero  - Valor con el ancho
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------          
     function SetErrorBarAnchoLineas($which_seblw) 
     {
        $this->error_bar_line_width = $which_seblw;
        return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetPosicionEscalaEtiquetas
     // Descripcion: Fija la escala de la posición de las Etiquetas.
     // Parametros : which_blp     - Entero  - Valor con el ancho, entre 0 y 1
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------          
     function SetPosicionEscalaEtiquetas($which_blp)
     {
        //0 to 1
        $this->label_scale_position = $which_blp;
        return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetErrorTamanioBarras
     // Descripcion: Fija el tamaño de las barras de error.
     // Parametros : which_ebs     - Entero  - Valor con el ancho en pixeles
     // Retorno    : TRUE.
     //-------------------------------------------------------------------------          
     function SetErrorTamanioBarras($which_ebs)
     {
        //in pixels
        $this->error_bar_size = $which_ebs;
        return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetErrorFormaBarras
     // Descripcion: Fija la forma de las barras de error.
     // Parametros : which_ebs     - String  - Valor con la forma, puede ser :'tee, line', 
     // Retorno    : <Ninguno>.
     //-------------------------------------------------------------------------          
     function SetErrorFormaBarras($which_ebs)
     {
        $this->error_bar_shape = $this->ChequearOpcion($which_ebs, 'tee, line', __FUNCTION__);
     }

     //-------------------------------------------------------------------------
     // SetFormaPunto
     // Descripcion: Fija la forma de los puntos del grafico.
     // Parametros : which_pt     - Arreglo  - Arreglo con los valores con la forma para mostrar los puntos,
     //                                       puede ser : 'halfline, line, plus, cross,
     //                                       rect, circle, dot, diamond, triangle, trianglemid',
     // Retorno    : <Ninguno>.
     //-------------------------------------------------------------------------
     function SetFormaPunto($which_pt=NULL)
     {
        /*$this->point_shape = $this->ChequearOpcion($which_pt,
                              'halfline, line, plus, cross, rect, circle, dot, diamond, triangle, trianglemid',
                              __FUNCTION__);*/

        if (is_null($which_pt)) {
             // No hace nada, usa el valor por defecto.
         } else if (is_array($which_pt)) {
             // Asignar una arreglo con los Estilos?
             $this->points_shapes = $which_pt;
         } else {
             $this->points_shapes = ($which_pt) ? array($which_pt) : array('diamond');
         }
     }

     //-------------------------------------------------------------------------
     // SetTamanioPunto
     // Descripcion: Fija el tamaño para los puntos de la Grafica.
     // Parametros : ps     - Array  - Valores con los tamaños en Pixeles de los puntos
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function SetTamanioPunto($ps=NULL)
     {
        /*$this->point_size = $ps;

        if ($this->point_shape == 'diamond' or $this->point_shape == 'triangle') {
            if ($this->point_size % 2 != 0) {
                $this->point_size++;
            }
        } */

        if (is_null( $ps)) {
             // No hace nada utiliza el valor por defecto.
         } else if (is_array($ps)) {
             // Se Asigna un vector con los tamaños de puntos
             $this->points_sizes = $ps;
         } else {
             $this->point_sizes = array($ps);
         }
         
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetMostrarRayadoLineas
     // Descripcion: Determina que no se dibujen lineas para los datos de Y Perdidos.
     //              Solo trabaja con 'lines' y 'squared' de graficas.
     // Parametros : bl     - Boolean  - TRUE Activa para que se dibujen Lineas de
     //                                  de datos perdidos, FALSE desactiva la opción
     // Retorno    : <Ninguno>
     //-------------------------------------------------------------------------
     function SetMostrarRayadoLineas($bl)
     {
        $this->draw_broken_lines = (bool)$bl;
     }

     //-------------------------------------------------------------------------
     // SetTipoData
     // Descripcion: Fija el Tipo de Data para el grafico.
     // Parametros : which_dt     - String  - Especifica el tipo data para el grafico
     //                                       los valores admitidos son:
     //                                       text-data: ('label', y1, y2, y3, ...)
     //                                       text-data-pie: ('label', y1), para graficos de Torta. Ver MostrarGraficoTorta()
     //                                       data-data: ('label', x, y1, y2, y3, ...)
     //                                       data-data-error: ('label', x1, y1, e1+, e2-, y2, e2+, e2-, y3, e3+, e3-, ...)
     //
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function SetTipoData($which_dt)
     {
        //Para compatibilidad.
        //
        if ($which_dt == 'text-linear') { $which_dt = 'text-data'; };
        if ($which_dt == 'linear-linear') { $which_dt = 'data-data'; };
        if ($which_dt == 'linear-linear-error') { $which_dt = 'data-data-error'; };

        $this->data_type = $this->ChequearOpcion($which_dt, 'text-data, text-data-pie, data-data, data-data-error',
                                              __FUNCTION__);
        return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetValoresData
     // Descripcion: Copia el arreglo pasado como valores de la data. Se convierten
     //              los indices numericos, para esto para o mientras haya bucle, algunas
     //              veces son más rapidos. Las mejoras de la actuación varíe de 28% en MostrarLineas ()
     //              a 49% en MostrarArea () para las funciones de dibujo de Grafica.
     // Parametros : which_dv     - Array -
     //
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function SetValoresData(&$which_dv)
     {
        $this->num_data_rows = count($which_dv);
        $this->total_records = 0;               // Realiza algunos calculos utiles.
        $this->records_per_group = 1;
        for ($i = 0, $recs = 0; $i < $this->num_data_rows; $i++) {
            // Copia
            $this->data[$i] = array_values($which_dv[$i]);   // Convierte los indices numericos.

            // Calcula algunos valores
            $recs = count($this->data[$i]);
            $this->total_records += $recs;

            if ($recs > $this->records_per_group)
                $this->records_per_group = $recs;

            $this->num_recs[$i] = $recs;
        }
     }

     //-------------------------------------------------------------------------
     // PadArrays
     // Descripcion: Bloque de estilos de arreglo para el uso más tarde por las funciones
     //              de dibujo del grafico. Esto elimina la necesidad de $max_data_colors, etc. and $color_index = $color_index % $max_data_colors
     //              en MostrarBarras(), MostrarLineas(), etc.
     // Parametros : <Ninguno>
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function PadArrays()
     {
         array_pad_array($this->line_widths, $this->records_per_group);
         array_pad_array($this->line_styles, $this->records_per_group);
         array_pad_array($this->points_sizes, $this->records_per_group);
         array_pad_array($this->points_shapes, $this->records_per_group);

         array_pad_array($this->data_colors, $this->records_per_group);
         array_pad_array($this->data_border_colors, $this->records_per_group);
         array_pad_array($this->error_bar_colors, $this->records_per_group);

         $this->SetColoresData();
         $this->SetColoresBordesData();
         $this->SetColoresBarrasError();

         return TRUE;
     }
     //-------------------------------------------------------------------------
     // <FIN DE DEFINICION DE RUTINAS VARIAS>
     //-------------------------------------------------------------------------

     //-------------------------------------------------------------------------
     // <DEFINICION DE RUTINAS DE ANALISIS DE DATA, ESCALA Y TRASLACIÓN>
     //-------------------------------------------------------------------------

     //-------------------------------------------------------------------------
     // EncontrarLimitesData
     // Descripcion: Analiza los datos y fija el maximo y minimo interiores.
     //              Necesitada por CalcularMargenes().
     //              Text-Data es diferente que data-data para los graficos.
     //              Para ello nosotros tenemos que, en lugar de los  valores de X
     //              , es el # de registros igualmente al espacio en la data.
     //              text-data es pasado dentro como $data[] = (title, y1, y2, y3, y4, ...)
     //              data-data es pasado dentro como $data[] = (title, x, y1, y2, y3, y4, ...)
     // Parametros : <Ninguno>
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function EncontrarLimitesData()
     {
        // Fije algun minimo y maximo valor por defecto antes de dividir los datos
        switch ($this->data_type) {
        case 'text-data':
            $minx = 0;
            $maxx = $this->num_data_rows - 1 ;
            $miny = $this->data[0][1];
            $maxy = $miny;
            break;
        default:  //Sino: data-data, etc, Tomar el primer valor
            $minx = $this->data[0][1];
            $maxx = $minx;
            $miny = $this->data[0][2];
            $maxy = $miny;
            break;
        }

        $mine = 0;  // Valor Maximo para la  - barra de error (aume error de barras siempre >0)
        $maxe = 0;  // Valor Maximo para la  + barra de error (aume error de barras siempre >0)
        $maxt = 0;  // El número máximo de carácteres en las etiquetas del texto
        
        $minminy = $miny;
        $maxmaxy = $maxy;
		
		if ($this->plot_type == 'stackedbars') { $maxmaxy = $minminy = 0; }
		
        // Procesa cada fila de la data
		//
        for ($i=0; $i < $this->num_data_rows; $i++) {
            $j=0;
            // Extract maximum text label length
            $val = @ strlen($this->data[$i][$j++]);
            $maxt = ($val > $maxt) ? $val : $maxt;
			
			if ($this->plot_type == 'stackedbars') { $maxy = $miny = 0; }
			
            switch ($this->data_type) {
            case 'text-data':           //la data se pasa con un titulo de la siguiente forma (title, y1, y2, y3, ...)
            case 'text-data-pie':       // Esto es solo para graficos de torta, ver MostrarGraficoTorta()
                // $numrecs = @ count($this->data[$i]);
                $miny = $maxy = (double)$this->data[$i][$j];
                for (; $j < $this->num_recs[$i]; $j++) {
                    $val = (double)$this->data[$i][$j];
					if ($this->plot_type == 'stackedbars') {
                        $maxy += abs($val);      // Solo valores positivos para el momento
                    } else {
                        $maxy = ($val > $maxy) ? $val : $maxy;
                        $miny = ($val < $miny) ? $val : $miny;
                    }
                }
                break;
            case 'data-data':           // Data es pasada como un (title, x, y, y2, y3, ...)
                // X value:
                $val = (double)$this->data[$i][$j++];
                $maxx = ($val > $maxx) ? $val : $maxx;
                $minx = ($val < $minx) ? $val : $minx;

                $miny = $maxy = (double)$this->data[$i][$j];
                // $numrecs = @ count($this->data[$i]);
                for (; $j < $this->num_recs[$i]; $j++) {
                    $val = (double)$this->data[$i][$j];
                    $maxy = ($val > $maxy) ? $val : $maxy;
                    $miny = ($val < $miny) ? $val : $miny;
                }
                break;
            case 'data-data-error':     // Data es pasada como en (title, x, y, err+, err-, y2, err2+, err2-,...)
                // X value:
                $val = (double)$this->data[$i][$j++];
                $maxx = ($val > $maxx) ? $val : $maxx;
                $minx = ($val < $minx) ? $val : $minx;

                $miny = $maxy = (double)$this->data[$i][$j];
                // $numrecs = @ count($this->data[$i]);
                for (; $j < $this->num_recs[$i];) {
                    // Y value:
                    $val = (double)$this->data[$i][$j++];
                    $maxy = ($val > $maxy) ? $val : $maxy;
                    $miny = ($val < $miny) ? $val : $miny;
                    // Error +:
                    $val = (double)$this->data[$i][$j++];
                    $maxe = ($val > $maxe) ? $val : $maxe;
                    // Error -:
                    $val = (double)$this->data[$i][$j++];
                    $mine = ($val > $mine) ? $val : $mine;
                }
                $maxy = $maxy + $maxe;
                $miny = $miny - $mine;      // Asume que las barras de error son  > 0
                break;
            default:
                $this->PrintError("EncontrarLimitesData(): Tipo de data desconocida '$data_type'.");
            break;
            }
            $this->data[$i][MINY] = $miny;      // Estos registros son los minimos de Y, para MostrarXLineaData()
            $this->data[$i][MAXY] = $maxy;      // Estos registros son los máximos de Y, para MostrarXLineaData()
            $minminy = ($miny < $minminy) ? $miny : $minminy;   // Minimo Global
            $maxmaxy = ($maxy > $maxmaxy) ? $maxy : $maxmaxy;   // Maximo Global
        }

        $this->min_x = $minx;
        $this->max_x = $maxx;
        $this->min_y = $minminy;
        $this->max_y = $maxmaxy;
        $this->max_t = $maxt;

        $this->data_limits_done = TRUE;

        return TRUE;
     }

     //-------------------------------------------------------------------------
     // CalcularMargenes
     // Descripcion: Calcula los margenes de la imagen, las posiciones de los titulos
     //              y tamaños, y la posición y tamaño de las marcas de Etiquetas.
     //              agregue x_tick_label_width y y_tick_label_height y úselos para calcular
     //              el max_x_labels y max_y_labels, a ser usados dibujando las funciones que
     //              evitan solapamiento.
     // Parametros : <Ninguno>
     // Retorno    : <Ninguno>
     //-------------------------------------------------------------------------
     function CalcularMargenes()
     {
        // Las variables temporales para el cálculo de tamaño de etiqueta
        $xlab = $this->FormatoEtiquetas('x', $this->max_x);
        $ylab = $this->FormatoEtiquetas('y', $this->max_y);

        // Calcula X/Y etiqueta eje la  altura máxima y anchura:

        // TTFonts:
        if ($this->use_ttf) {
            // Altura maxima para etiqueta del eje X
            $size = $this->TTFBBoxSize($this->x_label_font['size'], $this->x_label_angle,
                                       $this->x_label_font['font'], $xlab);
            $this->x_tick_label_height = $size[1];

            // Ancho maximo para etiqueta del eje Y
            $size = $this->TTFBBoxSize($this->y_label_font['size'], $this->y_label_angle,
                                        $this->y_label_font['font'], $ylab);
            $this->y_tick_label_width = $size[0];
        }
        // Fixed fonts:
        else {
            // Maximum X axis label height
            if ($this->x_label_angle == 90)
                $this->x_tick_label_height = strlen($xlab) * $this->x_label_font['width'];
            else
                $this->x_tick_label_height = $this->x_label_font['height'];

            // Maximum Y axis label width
            $this->y_tick_label_width = strlen($ylab) * $this->y_label_font['width'];
        }


        //CALCULA MARGENES:

        // Titulo Superior, Marcas y etiquetas de marcas y etiquetas de data:
        $this->y_top_margin = $this->title_height + $this->safe_margin * 2;

        if ($this->x_title_pos == 'plotup' || $this->x_title_pos == 'both')
            $this->y_top_margin += $this->x_title_height + $this->safe_margin;

        if ($this->x_tick_label_pos == 'plotup' || $this->x_tick_label_pos == 'both')
            $this->y_top_margin += $this->x_tick_label_height;

        if ($this->x_tick_pos == 'plotup' || $this->x_tick_pos == 'both')
            $this->y_top_margin += $this->x_tick_length * 2;

        if ($this->x_data_label_pos == 'plotup' || $this->x_data_label_pos == 'both')
            $this->y_top_margin += $this->x_tick_label_height;

        // Titulo Inferior, Marcas y etiquetas de marcas y etiquetas de data:
        $this->y_bot_margin = $this->safe_margin * 2;

        if ($this->x_title_pos == 'plotdown' || $this->x_title_pos == 'both')
            $this->y_bot_margin += $this->x_title_height;

        if ($this->x_tick_pos == 'plotdown' || $this->x_tick_pos == 'both')
            $this->y_bot_margin += $this->x_tick_length * 2;

        if ($this->x_tick_pos == 'xaxis' && ($this->x_axis_position == '' || $this->x_axis_position == 0))
            $this->y_bot_margin += $this->x_tick_length * 2;

        if ($this->x_tick_label_pos == 'plotdown' || $this->x_tick_label_pos == 'both')
            $this->y_bot_margin += $this->x_tick_label_height;

        if ($this->x_tick_label_pos == 'xaxis' && ($this->x_axis_position == '' || $this->x_axis_position == 0))
            $this->y_bot_margin += $this->x_tick_label_height;

        if ($this->x_data_label_pos == 'plotdown' || $this->x_data_label_pos == 'both')
            $this->y_bot_margin += $this->x_tick_label_height;

        // Titulo Izquierdo, Marcas y etiquetas de marcas y etiquetas de data:
        $this->x_left_margin = $this->safe_margin * 2;

        if ($this->y_title_pos == 'plotleft' || $this->y_title_pos == 'both')
            $this->x_left_margin += $this->y_title_width + $this->safe_margin;

        if ($this->y_tick_label_pos == 'plotleft' || $this->y_tick_label_pos == 'both')
            $this->x_left_margin += $this->y_tick_label_width;

        if ($this->y_tick_pos == 'plotleft' || $this->y_tick_pos == 'both')
            $this->x_left_margin += $this->y_tick_length * 2 ;

        //Titulo Derecho, Marcas y etiquetas de marcas y etiquetas de data:
        $this->x_right_margin = $this->safe_margin * 2;

        if ($this->y_title_pos == 'plotright' || $this->y_title_pos == 'both')
            $this->x_right_margin += $this->y_title_width + $this->safe_margin;

        if ($this->y_tick_label_pos == 'plotright' || $this->y_tick_label_pos == 'both')
            $this->x_right_margin += $this->y_tick_label_width;

        if ($this->y_tick_pos == 'plotright' || $this->y_tick_pos == 'both')
            $this->x_right_margin += $this->y_tick_length * 2;


        $this->x_tot_margin = $this->x_left_margin + $this->x_right_margin;
        $this->y_tot_margin = $this->y_top_margin + $this->y_bot_margin;

        return;
     }

     //-------------------------------------------------------------------------
     // SetMargenesPixels
     // Descripcion: Fija los margenes en Pixeles, (left, right, top, bottom)
     // Parametros : which_lm       - Entero - Margen  Izquierdo
     //              which_rm       - Entero - Margen  Derecho
     //              which_tm       - Entero - Margen  Superior
     //              which_bm       - Entero - Margen  Superior
     // Retorno    : <Ninguno>
     //-------------------------------------------------------------------------
     function SetMargenesPixels($which_lm, $which_rm, $which_tm, $which_bm)
     {

         $this->x_left_margin = $which_lm;
         $this->x_right_margin = $which_rm;
         $this->x_tot_margin = $which_lm + $which_rm;

         $this->y_top_margin = $which_tm;
         $this->y_bot_margin = $which_bm;
         $this->y_tot_margin = $which_tm + $which_bm;
         $this->SetAreaGraficoPixels();
         return;
     }

     //-------------------------------------------------------------------------
     // SetAreaGraficoPixels
     // Descripcion: Fija el Limite para el area del Grafico. si Ningún argumento
     //              se proporciona, se usara el valor calculado de la funcion
     //              CalcularMargenes();
     //              Como en GD, (0,0) es superior izquierda
     //              Esto restablece la escala si SetAreaTramasWorld () ya se llamó
     // Parametros : which_lm       - Entero - Margen  Izquierdo
     //              which_rm       - Entero - Margen  Derecho
     //              which_tm       - Entero - Margen  Superior
     //              which_bm       - Entero - Margen  Superior
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function SetAreaGraficoPixels($x1=NULL, $y1=NULL, $x2=NULL, $y2=NULL)
     {
        if ($x2 && $y2) {
            $this->plot_area = array($x1, $y1, $x2, $y2);
        } else {
            if (! isset($this->x_tot_margin))
                $this->CalcularMargenes();

            $this->plot_area = array($this->x_left_margin, $this->y_top_margin,
                                     $this->image_width - $this->x_right_margin,
                                     $this->image_height - $this->y_bot_margin);
        }
        $this->plot_area_width = $this->plot_area[2] - $this->plot_area[0];
        $this->plot_area_height = $this->plot_area[3] - $this->plot_area[1];

        // restablece la escala con la nueva area del grafico.
        if (isset($this->plot_max_x))
            $this->CalcTranslacion();

        return TRUE;

     }

     //-------------------------------------------------------------------------
     // SetAreaTramasWorld
     // Descripcion: Fija el valor minimo y maximo en X y Y para el area del Grafico usando
     //              EncontrarLimitesData() o desde los parametros dados si tienen valor
     //              Como en GD, (0,0) es superior izquierda
     //              Esto restablece la escala si SetAreaGraficoPixels () fue llamada
     // Parametros : xmin           - Entero - Minimo valor para X
     //              ymin           - Entero - Minimo valor para Y
     //              xmax           - Entero - Maximo valor para X
     //              ymax           - Entero - Maximo valor para Y
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function SetAreaTramasWorld($xmin=NULL, $ymin=NULL, $xmax=NULL, $ymax=NULL)
     {
        if ((! $xmin)  && (! $xmax) ) {
            // Para configuración automatica se necesitan los limites de los datos
            if (! isset($this->data_limits_done)) {
                $this->EncontrarLimitesData() ;
            }
            if ($this->data_type == 'text-data') {
                $xmax = $this->max_x + 1 ;  // Valido solo para tipo de graficos de barra
                $xmin = 0 ;                 // Valido solo para tipo de graficos de barra
            } else {
                $xmax = $this->max_x;
                $xmin = $this->min_x;
            }

            $ymax = ceil($this->max_y * 1.1);
            if ($this->min_y < 0) {
                $ymin = floor($this->min_y * 1.1);
            } else {
                $ymin = 0;
            }
        }

        $this->plot_min_x = $xmin;
        $this->plot_max_x = $xmax;

        if ($ymin == $ymax) {
            $ymax += 1;
        }
        if ($this->yscale_type == 'log') {
            //Comprobación del error extra
            if ($ymin <= 0) {
                $ymin = 1;
            }
            if ($ymax <= 0) {
                $this->PrintError('SetAreaTramasWorld(): El registro de la data debe ser mayor a cero');
                return FALSE;
            }
        }

        $this->plot_min_y = $ymin;
        $this->plot_max_y = $ymax;

        if ($ymax <= $ymin) {
            $this->MostrarError('SetAreaTramasWorld(): Error en data - Maximo no debe ser menor que el minimo');
            return FALSE;
        }

        // Reinicia los valores de la escala con los nuevos maximos y minimos
        if (isset($this->plot_area_width)) {
            $this->CalcTranslacion();
        }

        return TRUE;
     }
	 	 
     //-------------------------------------------------------------------------
     // CalcBarWidths
     // Descripcion: Para Graficos de barras que tiene espacios iguales en variables X
     // Parametros : <Ninguno>
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
 
     function CalcBarWidths()
     {
        $group_width = ($this->plot_area[2] - $this->plot_area[0]) /
                      $this->num_data_rows * $this->group_frac_width;
        if ($this->plot_type == 'bars') {
            $this->record_bar_width = $group_width / $this->records_per_group;
        } else if ($this->plot_type == 'stackedbars') {
            $this->record_bar_width = $group_width;
        }            
        $this->data_group_space = $group_width / 2;
        return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetIgualXCoord
     // Descripcion: Para Graficos que tienen igual espacio x Variables y multiples
     //              barras por x-puntos
     // Parametros : <Ninguno>
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function SetIgualXCoord()
     {
        $space = ($this->plot_area[2] - $this->plot_area[0]) /
                 ($this->num_data_rows * 2) * $this->group_frac_width;
        $group_width = $space * 2;
        $bar_width = $group_width / $this->records_per_group;
        // Yo pienso que en el futuro este testamento inconstante espacial se
        // reemplace por sólo graficación en X.
        $this->data_group_space = $space;
        $this->record_bar_width = $bar_width;
        return TRUE;
     }

     //-------------------------------------------------------------------------
     // CalcTranslacion
     // Descripcion: Calcula la escala en x, y la Escala en Y
     // Parametros : <Ninguno>
     // Retorno    : <Ninguno>
     //-------------------------------------------------------------------------
     function CalcTranslacion()
     {
         if ($this->xscale_type == 'log') {
             $this->xscale = ($this->plot_area_width)/(log10($this->plot_max_x) - log10($this->plot_min_x));
         } else {
             $this->xscale = ($this->plot_area_width)/($this->plot_max_x - $this->plot_min_x);
         }
         if ($this->yscale_type == 'log') {
             $this->yscale = ($this->plot_area_height)/(log10($this->plot_max_y) - log10($this->plot_min_y));
         } else {
             $this->yscale = ($this->plot_area_height)/($this->plot_max_y - $this->plot_min_y);
         }

         // GD define x = 0 a la izquierda y y = 0 arriba además -/+ respectivamente
         if ($this->xscale_type == 'log') {
             $this->plot_origin_x = $this->plot_area[0] - ($this->xscale * log10($this->plot_min_x) );
         } else {
             $this->plot_origin_x = $this->plot_area[0] - ($this->xscale * $this->plot_min_x);
         }
         if ($this->yscale_type == 'log') {
             $this->plot_origin_y = $this->plot_area[3] + ($this->yscale * log10($this->plot_min_y));
         } else {
             $this->plot_origin_y = $this->plot_area[3] + ($this->yscale * $this->plot_min_y);
         }

         $this->scale_is_set = TRUE;

         // el usuario proporciona la posición del eje Y?
         if ($this->y_axis_position != '') {
             // Asegúrese que nosotros dibujamos nuestro eje dentro del Grafico
             $this->y_axis_position = ($this->y_axis_position < $this->plot_min_x)
                                      ? $this->plot_min_x : $this->y_axis_position;
             $this->y_axis_position = ($this->y_axis_position > $this->plot_max_x)
                                      ? $this->plot_max_x : $this->y_axis_position;
             $this->y_axis_x_pixels = $this->xtr($this->y_axis_position);
         } else {
             // Tenga como valor predefinido el eje izquierdo
             $this->y_axis_x_pixels = $this->xtr($this->plot_min_x);
         }
         // el usuario proporciona la posición del eje X?
         if ($this->x_axis_position != '') {
             // Make sure we draw our axis inside the plot
             $this->x_axis_position = ($this->x_axis_position < $this->plot_min_y)
                                      ? $this->plot_min_y : $this->x_axis_position;
             $this->x_axis_position = ($this->x_axis_position > $this->plot_max_y)
                                      ? $this->plot_max_y : $this->x_axis_position;
             $this->x_axis_y_pixels = $this->ytr($this->x_axis_position);
         } else {
             if ($this->yscale_type == 'log')
                 $this->x_axis_y_pixels = $this->ytr(1);
             else
                 // Default to axis at 0 or plot_min_y (should be 0 anyway, from SetAreaTramasWorld())
                 $this->x_axis_y_pixels = ($this->plot_min_y <= 0) && (0 <= $this->plot_max_y)
                                          ? $this->ytr(0) : $this->ytr($this->plot_min_y);
         }

     }

     //-------------------------------------------------------------------------
     // xtr
     // Descripcion: Interpreta la coordenada en X dentro de una coordenada en Pixel
     //              Necesita los valores calculados por CalcTranslacion()
     // Parametros : x_world           -  Entero  - Coordenada en X
     // Retorno    : Entero con el Valor en pixels de la coordenada en X
     //-------------------------------------------------------------------------
     function xtr($x_world)
     {
        //$x_pixels =  $this->x_left_margin + ($this->image_width - $this->x_tot_margin)*
        //      (($x_world - $this->plot_min_x) / ($this->plot_max_x - $this->plot_min_x)) ;
        //qué con la aritmetica de se reduce un poco a...
        if ($this->xscale_type == 'log') {
            $x_pixels = $this->plot_origin_x + log10($x_world) * $this->xscale ;
        } else {
            $x_pixels = $this->plot_origin_x + $x_world * $this->xscale ;
        }
        return round($x_pixels);
     }

     //-------------------------------------------------------------------------
     // ytr
     // Descripcion: Interpreta la coordenada en Y dentro de una coordenada en Pixel
     //              Necesita los valores calculados por CalcTranslacion()
     // Parametros : y_world           -  Entero  - Coordenada en Y
     // Retorno    : Entero con el Valor en pixels de la coordenada en Y
     //-------------------------------------------------------------------------
     function ytr($y_world)
     {
         if ($this->yscale_type == 'log') {
             //menos porque en GD y=0
             $y_pixels =  $this->plot_origin_y - log10($y_world) * $this->yscale ;
         } else {
             $y_pixels =  $this->plot_origin_y - $y_world * $this->yscale ;
         }
         return round($y_pixels);
     }

     //-------------------------------------------------------------------------
     // FormatoEtiquetas
     // Descripcion: Formatos en etiquetas de marcas o datas
     // Parametros : which_pos      -  String  - cual posicion  x, plotx, y, ploty,time,
     //              which_lab      -  String  - Formato
     // Retorno    : Entero con el Valor en pixels de la coordenada
     //-------------------------------------------------------------------------
      function FormatoEtiquetas($which_pos, $which_lab)
      {
          switch ($which_pos) {
          case 'x':
          case 'plotx':
              switch ($this->x_label_type) {
              case 'title':
                  $lab = $this->data[$which_lab][0];
                  break;
              case 'data':
                  $lab = number_format($which_lab, $this->x_precision, '.', ', ').$this->data_units_text;
                  break;
              case 'time':
                  $lab = strftime($this->x_time_format, $which_lab);
                  break;
              default:
                  // Inalterable cualquier formato que pase
                  $lab = $which_lab;
              break;
              }
              break;
          case 'y':
          case 'ploty':
              switch ($this->y_label_type) {
              case 'data':
                  $lab = number_format($which_lab, $this->y_precision, '.', ', ').$this->data_units_text;
                  break;
              case 'time':
                  $lab = strftime($this->y_time_format, $which_lab);
                  break;
              default:
                  // No alterable el formato pasado
                  $lab = $which_lab;
                  break;
              }
              break;
          default:
              $this->PrintError("FormatoEtiquetas(): Desconocida tipo de etiqueta $which_type");
              return NULL;
          }
          return $lab;
      }
     //-------------------------------------------------------------------------
     // <FIN DE DEFINICION DE RUTINAS DE ANALISIS DE DATA, ESCALA Y TRASLACIÓN>
     //-------------------------------------------------------------------------

     //-------------------------------------------------------------------------
     // <DEFINICION DE RUTINAS DE MARCAS>
     //-------------------------------------------------------------------------

     //-------------------------------------------------------------------------
     // SetXIncrementoMarcas
     // Descripcion: Use esta rutina o SetNumXMarcas() para Fijar donde colocar las señales de marcas
     // Parametros : which_ti      -  Entero  - Valor de incremento en X
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function SetXIncrementoMarcas($which_ti=NULL)
     {
         if ($which_ti) {
             $this->x_tick_increment = $which_ti;  //Coordenadas
         } else {
             if (! isset($this->data_limits_done)) {
                 $this->EncontrarLimitesData();  //Encuentra la maxima y minima escala
             }
             $this->x_tick_increment =  ($this->plot_max_x  - $this->plot_min_x  )/10;
         }
         $this->num_x_ticks = ''; //use cualquiera de las dos num_x_ticks o x_tick_increment, no ambos
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetYIncrementoMarcas
     // Descripcion: Use esta rutina o SetNumYMarcas() para Fijar donde colocar las señales de marcas
     // Parametros : which_ti      -  Entero  - Valor de incremento en Y
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function SetYIncrementoMarcas($which_ti=NULL)
     {
         if ($which_ti) {
             $this->y_tick_increment = $which_ti;  //Coordenadas
         } else {
             if (! isset($this->data_limits_done)) {
                 $this->EncontrarLimitesData();  //Encuentra la maxima y minima escala
             }
             if (! isset($this->plot_max_y))
                 $this->SetAreaTramasWorld();

             //$this->y_tick_increment = ( ceil($this->max_y * 1.2) - floor($this->min_y * 1.2) )/10;
             $this->y_tick_increment =  ($this->plot_max_y  - $this->plot_min_y  )/10;
         }
         $this->num_y_ticks = ''; //use cualquiera de las dos num_y_ticks o y_tick_increment, no ambos
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetNumXMarcas
     // Descripcion: Use esta rutina o SetNumXMarcas() para Fijar donde colocar las señales de marcas
     // Parametros : which_nt      -  Entero  - Valor de incremento en X
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function SetNumXMarcas($which_nt)
     {
         $this->num_x_ticks = $which_nt;
         $this->x_tick_increment = '';  //Use cualquiera de las dos num_x_ticks o x_tick_increment, no ambos
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetNumYMarcas
     // Descripcion: Use esta rutina o SetNumYMarcas() para Fijar donde colocar las señales de marcas
     // Parametros : which_nt      -  Entero  - Valor de incremento en Y
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function SetNumYMarcas($which_nt)
     {
         $this->num_y_ticks = $which_nt;
         $this->y_tick_increment = '';  //Use cualquiera de las dos num_y_ticks o y_tick_increment, no ambos
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetYPosMarcas
     // Descripcion: Use esta rutina para fijar la posición de las marcas en Y
     // Parametros : which_tp      -  String  - Posicion de las Señales de Marcas:
     //                                         'plotleft, plotright, both, yaxis, none'
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function SetYPosMarcas($which_tp)
     {
         $this->y_tick_pos = $this->ChequearOpcion($which_tp, 'plotleft, plotright, both, yaxis, none', __FUNCTION__);
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetXPosMarcas
     // Descripcion: Use esta rutina para fijar la posición de las marcas en X
     // Parametros : which_tp      -  String  - Posicion de las Señales de Marcas:
     //                                         'plotdown, plotup, both, xaxis, none'
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function SetXPosMarcas($which_tp)
     {
         $this->x_tick_pos = $this->ChequearOpcion($which_tp, 'plotdown, plotup, both, xaxis, none', __FUNCTION__);
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetSaltarMarcasSuperiores
     // Descripcion: Activa o Desactiva Señales de el tope
     // Parametros : skip      -  Boolean  - TRUE Activa, FALSE Desactiva
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function SetSaltarMarcasSuperiores($skip)
     {
         $this->skip_top_tick = (bool)$skip;
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetSaltarMarcasInferiores
     // Descripcion: Activa o Desactiva Señales Inferiores
     // Parametros : skip      -  Boolean  - TRUE Activa, FALSE Desactiva
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function SetSaltarMarcasInferiores($skip)
     {
         $this->skip_bottom_tick = (bool)$skip;
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetXLongitudMarcas
     // Descripcion: Fija el Tamaño de las Marcas en Pixels en el eje X
     // Parametros : which_xln      -  Entero  - Longitud de las Marcas en Pixels
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function SetXLongitudMarcas($which_xln)
     {
         $this->x_tick_length = $which_xln;
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetYLongitudMarcas
     // Descripcion: Fija el Tamaño de las Marcas en Pixels en el eje Y
     // Parametros : which_yln      -  Entero  - Longitud de las Marcas en Pixels
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function SetYLongitudMarcas($which_yln)
     {
         $this->y_tick_length = $which_yln;
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetXMarcasCruzadas
     // Descripcion: Fija el punto de intercepción en el eje X
     // Parametros : which_xc      -  Entero  - Punto de intercepción
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function SetXMarcasCruzadas($which_xc)
     {
         $this->x_tick_cross = $which_xc;
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetYMarcasCruzadas
     // Descripcion: Fija el punto de intercepción en el eje Y
     // Parametros : which_xc      -  Entero  - Punto de intercepción
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function SetYMarcasCruzadas($which_yc)
     {
         $this->y_tick_cross = $which_yc;
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // SetYMarcasCruzadas
     // Descripcion: Fija el punto de intercepción en el eje Y
     // Parametros : aExplodeArr      -  Arreglo  - Valores de los angulos de separación
     // Retorno    : <Ninguno>
     //-------------------------------------------------------------------------
     function SetRadiosSeparacion($aExplodeArr)
     {
        if( !is_array($aExplodeArr) ) {
	       $this->PrintError("SetRadiosSeparacion: Argumento no es un arreglo para la distancia de piezas de grafico de torta.");
        }
        $this->explode_radius = $aExplodeArr;
     }

     //-------------------------------------------------------------------------
     // SepararTodosPedazosTortas
     // Descripcion: Separa todos los pedazos de tortas
     // Parametros : radius      -  Entero  - radio de separación para segmentos
     // Retorno    : <Ninguno>
     //-------------------------------------------------------------------------
     function SepararTodosPiezas($radius=20)
     {
        $this->explode_all=true;
	     $this->explode_r = $radius;
     }

     //-------------------------------------------------------------------------
     // <FIN DE DEFINICION DE RUTINAS DE MARCAS>
     //-------------------------------------------------------------------------

     //-------------------------------------------------------------------------
     // <DEFINICION DE RUTINAS GENERICAS DE DIBUJADO>
     //-------------------------------------------------------------------------

     //-------------------------------------------------------------------------
     // MostrarFondo
     // Descripcion: Rellena el fondo de la imagen con un color solido
     // Parametros : <Ninguno>
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function MostrarFondo()
     {
         if (! $this->background_done) {     // No lo dibuje 2 veces si ya dibujo 2 graficos
                                             // sobre una Imagen

             // Solo para el caso de no haber definido imagen de Fondo
             // para el grafico
             //
             if ($this->input_file=='') {
                ImageFilledRectangle($this->img, 0, 0, $this->image_width, $this->image_height,
                                  $this->ndx_bg_color);
             }
             $this->background_done = TRUE;
         }
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // MostrarBordeImagen
     // Descripcion: Dibuja un aborde alrededor de la imagen Final
     // Parametros : <Ninguno>
     // Retorno    : TRUE Dibujo correctamente el borde, FALSE caso problemas al hacerlo
     //-------------------------------------------------------------------------
     function MostrarBordeImagen()
     {
         switch ($this->image_border_type) {
         case 'raised':
             ImageLine($this->img, 0, 0, $this->image_width-1, 0, $this->ndx_i_border);
             ImageLine($this->img, 1, 1, $this->image_width-2, 1, $this->ndx_i_border);
             ImageLine($this->img, 0, 0, 0, $this->image_height-1, $this->ndx_i_border);
             ImageLine($this->img, 1, 1, 1, $this->image_height-2, $this->ndx_i_border);
             ImageLine($this->img, $this->image_width-1, 0, $this->image_width-1,
                       $this->image_height-1, $this->ndx_i_border_dark);
             ImageLine($this->img, 0, $this->image_height-1, $this->image_width-1,
                       $this->image_height-1, $this->ndx_i_border_dark);
             ImageLine($this->img, $this->image_width-2, 1, $this->image_width-2,
                       $this->image_height-2, $this->ndx_i_border_dark);
             ImageLine($this->img, 1, $this->image_height-2, $this->image_width-2,
                       $this->image_height-2, $this->ndx_i_border_dark);
             break;
         case 'plain':
             ImageLine($this->img, 0, 0, $this->image_width, 0, $this->ndx_i_border_dark);
             ImageLine($this->img, $this->image_width-1, 0, $this->image_width-1,
                       $this->image_height, $this->ndx_i_border_dark);
             ImageLine($this->img, $this->image_width-1, $this->image_height-1, 0, $this->image_height-1,
                       $this->ndx_i_border_dark);
             ImageLine($this->img, 0, 0, 0, $this->image_height, $this->ndx_i_border_dark);
             break;
         case 'none':
             break;
         default:
             $this->MostrarError("MostrarBordeImagen(): Desconocido tipo de Borde de Imagen: '$this->image_border_type'");
             return FALSE;
         }
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // MostrarTitulo
     // Descripcion: Dibuja el Titulo del Grafico
     // Parametros : <Ninguno>
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function MostrarTitulo()
     {
         // Centro del area del grafico
         //$xpos = ($this->plot_area[0] + $this->plot_area_width )/ 2;

         // Centro de la imagen:
         $xpos = $this->image_width / 2;

         // Coloquelo al tope de la imagen
         $ypos = $this->safe_margin;

         $this->MostrarTexto($this->title_font, $this->title_angle, $xpos, $ypos,
                         $this->ndx_title_color, $this->title_txt, 'center', 'bottom');

         return TRUE;
     }

     //-------------------------------------------------------------------------
     // MostrarXTitulo
     // Descripcion: Dibuja el Titulo del Grafico en el Eje X
     // Parametros : <Ninguno>
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function MostrarXTitulo()
     {
         if ($this->x_title_pos == 'none')
             return;

         // Center of the plot
         $xpos = ($this->plot_area[2] + $this->plot_area[0]) / 2;

         // El Titulo Superior
         if ($this->x_title_pos == 'plotup' || $this->x_title_pos == 'both') {
             $ypos = $this->safe_margin + $this->title_height + $this->safe_margin;
             $this->MostrarTexto($this->x_title_font, $this->x_title_angle,
                             $xpos, $ypos, $this->ndx_title_color, $this->x_title_txt, 'center');
         }
         // Titulo Inferior
         if ($this->x_title_pos == 'plotdown' || $this->x_title_pos == 'both') {
             $ypos = $this->image_height - $this->x_title_height - $this->safe_margin;
             $this->MostrarTexto($this->x_title_font, $this->x_title_angle,
                             $xpos, $ypos, $this->ndx_title_color, $this->x_title_txt, 'center');
         }
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // MostrarYTitulo
     // Descripcion: Dibuja el Titulo del Grafico en el Eje Y
     // Parametros : <Ninguno>
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function MostrarYTitulo()
     {
         if ($this->y_title_pos == 'none')
             return;

         // centra el titulo verticalmente en el grafico
         $ypos = ($this->plot_area[3] + $this->plot_area[1]) / 2;

         if ($this->y_title_pos == 'plotleft' || $this->y_title_pos == 'both') {
             $xpos = $this->safe_margin;
             $this->MostrarTexto($this->y_title_font, 90, $xpos, $ypos, $this->ndx_title_color,
                             $this->y_title_txt, 'left', 'center');
         }
         if ($this->y_title_pos == 'plotright' || $this->y_title_pos == 'both') {
             $xpos = $this->image_width - $this->safe_margin - $this->y_title_width - $this->safe_margin;
             $this->MostrarTexto($this->y_title_font, 90, $xpos, $ypos, $this->ndx_title_color,
                             $this->y_title_txt, 'left', 'center');
         }

         return TRUE;
     }

     //-------------------------------------------------------------------------
     // MostrarTramaAreaFondo
     // Descripcion: Rellena el area del grafico con un color solido
     // Parametros : <Ninguno>
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function MostrarTramaAreaFondo()
     {
         ImageFilledRectangle($this->img, $this->plot_area[0], $this->plot_area[1],
                              $this->plot_area[2], $this->plot_area[3],
                              $this->ndx_plot_bg_color);
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // MostrarEjeY
     // Descripcion: Dibuja las líneas del Grid, las lineas horizontales borran
     //              el eje horizontal con el y=0,
     //              así que llame esta primero, luego MostrarEjeX ()
     // Parametros : <Ninguno>
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function MostrarEjeY()
     {
         //Dibuja marcas, etiquetas y grid si estan activos
         $this->MostrarMarcasEjeY();

         // Dibuja el eje Y en X = y_axis_x_pixels
         ImageLine($this->img, $this->y_axis_x_pixels, $this->plot_area[1],
                   $this->y_axis_x_pixels, $this->plot_area[3], $this->ndx_grid_color);

         return TRUE;
     }

     //-------------------------------------------------------------------------
     // MostrarEjeX
     // Descripcion: Dibuja las líneas del Grid, las lineas horizontales borran
     //              en el eje horizontal con el x=0,
     //              así que llame esta primero, luego MostrarEjeY ()
     // Parametros : <Ninguno>
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function MostrarEjeX()
     {
         // Dibuja marcas, etiquetas y grid si estan activos
         $this->MostrarMarcasEjeX();

         //Dibuja marcas y etiquetas para el eje Y
         if (! $this->skip_bottom_tick) {
             $ylab =$this->FormatoEtiquetas('y', $this->x_axis_position);
             $this->MostrarMarcaEjeY($ylab, $this->x_axis_y_pixels);
         }

         //Dibuja el eje X en y = x_axis_y_pixels
         ImageLine($this->img, $this->plot_area[0]+1, $this->x_axis_y_pixels,
                   $this->plot_area[2]-1, $this->x_axis_y_pixels, $this->ndx_grid_color);

         return TRUE;
     }

     //-------------------------------------------------------------------------
     // MostrarMarcaEjeY
     // Descripcion: Dibuja una marca llamada desde MostrarMarcasEjeY() y MostrarEjeX()
     //              TODO? ¿Mueva este MostrarMarcasEjeY interior () y Modifica MostrarEjeX ()?
     // Parametros : which_ylab      -  Entero  -
     //              which_ypix      -  Entero  - Coordena en el eje X
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function MostrarMarcaEjeY($which_ylab, $which_ypix)
     {
         // Marcas sobre el Eje Y
         if ($this->y_tick_pos == 'yaxis') {
             ImageLine($this->img, $this->y_axis_x_pixels - $this->y_tick_length, $which_ypix,
                       $this->y_axis_x_pixels + $this->y_tick_cross, $which_ypix,
                       $this->ndx_tick_color);
         }

         // Etiquetas sobre el Eje Y
         if ($this->y_tick_label_pos == 'yaxis') {
             $this->MostrarTexto($this->y_label_font, $this->y_label_angle,
                             $this->y_axis_x_pixels - $this->y_tick_length * 1.5, $which_ypix,
                             $this->ndx_text_color, $which_ylab, 'right', 'center');
         }

         // Marcas a la Izquierda del area del grafico
         if (($this->y_tick_pos == 'plotleft') || ($this->y_tick_pos == 'both') ) {
             ImageLine($this->img, $this->plot_area[0] - $this->y_tick_length,
                       $which_ypix, $this->plot_area[0] + $this->y_tick_cross,
                       $which_ypix, $this->ndx_tick_color);
         }

         // Marcas a la derecha del area del grafico
         if (($this->y_tick_pos == 'plotright') || ($this->y_tick_pos == 'both') ) {
             ImageLine($this->img, ($this->plot_area[2] + $this->y_tick_length),
                       $which_ypix, $this->plot_area[2] - $this->y_tick_cross,
                       $which_ypix, $this->ndx_tick_color);
         }

         // Etiquetas para el area del grafico a la izquierda
         if ($this->y_tick_label_pos == 'plotleft' || $this->y_tick_label_pos == 'both') {
             $this->MostrarTexto($this->y_label_font, $this->y_label_angle,
                             $this->plot_area[0] - $this->y_tick_length * 1.5, $which_ypix,
                             $this->ndx_text_color, $which_ylab, 'right', 'center');
         }
         // Etiquetas para el area del grafico a la derecha
         if ($this->y_tick_label_pos == 'plotright' || $this->y_tick_label_pos == 'both') {
             $this->MostrarTexto($this->y_label_font, $this->y_label_angle,
                             $this->plot_area[2] + $this->y_tick_length * 1.5, $which_ypix,
                             $this->ndx_text_color, $which_ylab, 'left', 'center');
         }
     }

     //-------------------------------------------------------------------------
     // MostrarMarcasEjeY
     // Descripcion: Dibuja el rejillas, Marcas y señales de Etiquetas a lo largo
     //              del Eje Y, marcas y etiquetas pueden ser a la izquierda del grafico
     //              solamente, o a la derecha del grafico solamente,
     //              ambos en la izquierda y derecha del grafico, o interceptando a un usuario definido el Eje Y
     // Parametros : <Ninguno>
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function MostrarMarcasEjeY()
     {
         // Fija el estilo de linea para IMG_COLOR_STYLED lineas del (grid)
         if ($this->dashed_grid) {
             $this->SetDashedStyle($this->ndx_light_grid_color);
             $style = IMG_COLOR_STYLED;
         } else {
             $style = $this->ndx_light_grid_color;
         }

         // maxy es siempre > miny para que delta_y sea siempre positiva
         if ($this->y_tick_increment) {
             $delta_y = $this->y_tick_increment;
         } elseif ($this->num_y_ticks) {
             $delta_y = ($this->plot_max_y - $this->plot_min_y) / $this->num_y_ticks;
         } else {
             $delta_y = ($this->plot_max_y - $this->plot_min_y) / 10 ;
         }

         // NOTA: se trabaja con punto flotantes, debido a las aproximaciones
         //       cuando se agrega $delta_y, $y_tmp nunca iguala a $y_end
         //       en los ciclos, para que una línea espuria se dibujará donde
         //       sea diferente a $y_end aquí
         $y_tmp = (double)$this->plot_min_y;
         $y_end = (double)$this->plot_max_y - ($delta_y/2);

         if ($this->skip_bottom_tick)
             $y_tmp += $delta_y;

         if ($this->skip_top_tick)
             $y_end -= $delta_y;

         for (;$y_tmp < $y_end; $y_tmp += $delta_y) {
             $ylab = $this->FormatoEtiquetas('y', $y_tmp);
             $y_pixels = $this->ytr($y_tmp);

             // Linea Horizontal de Grid
             if ($this->draw_y_grid) {
                 ImageLine($this->img, $this->plot_area[0]+1, $y_pixels, $this->plot_area[2]-1, $y_pixels, $style);
             }

             // Dibuja marcas
             $this->MostrarMarcaEjeY($ylab, $y_pixels);
         }
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // MostrarMarcasEjeX
     // Descripcion: Dibuja el rejillas, Marcas y señales de Etiquetas a lo largo
     //              del Eje X, marcas y etiquetas pueden ser a la inferiores del grafico
     //              solamente, o superior del grafico solamente,
     //              ambos en la izquierda y derecha del grafico, o interceptando a un usuario definido el Eje X
     // Parametros : <Ninguno>
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function MostrarMarcasEjeX()
     {
         // Fija el Estilo de lineas IMG_COLOR_STYLED  (grid)
         if ($this->dashed_grid) {
             $this->SetDashedStyle($this->ndx_light_grid_color);
             $style = IMG_COLOR_STYLED;
         } else {
             $style = $this->ndx_light_grid_color;
         }

         // Calcula el incremento en x entre marcas
         if ($this->x_tick_increment) {
             $delta_x = $this->x_tick_increment;
         } elseif ($this->num_x_ticks) {
             $delta_x = ($this->plot_max_x - $this->plot_min_x) / $this->num_x_ticks;
         } else {
             $delta_x =($this->plot_max_x - $this->plot_min_x) / 10 ;
         }

         // NOTA: Cuando trabaja con decimales, porque las aproximaciones se suman a $delta_x,
         //       $x_temp nunca iguala x_end en el ciclo for,para que una línea espuria se dibujará donde
         //       sea diferente a $x_end aquí
         $x_tmp = (double)$this->plot_min_x;
         $x_end = (double)$this->plot_max_x - ($delta_x/2);

         // No se dibujan las marcas de la izquierda del eje X
         if ($this->skip_left_tick)
             $x_tmp += $delta_x;

         // No se dibujan las marcas de la derecho del eje X
         if (! $this->skip_right_tick)
             $x_end += $delta_x;

         for (;$x_tmp < $x_end; $x_tmp += $delta_x) {
             $xlab = $this->FormatoEtiquetas('x', $x_tmp);
             $x_pixels = $this->xtr($x_tmp);

             // Lineas verticales del Grid
             if ($this->draw_x_grid) {
                 ImageLine($this->img, $x_pixels, $this->plot_area[1], $x_pixels, $this->plot_area[3], $style);
             }

             //MArcas sobre el Eje X
             if ($this->x_tick_pos == 'xaxis') {
                 ImageLine($this->img, $x_pixels, $this->x_axis_y_pixels - $this->x_tick_cross,
                           $x_pixels, $this->x_axis_y_pixels + $this->x_tick_length, $this->ndx_tick_color);
             }

             // Etiquetas sobre el eje X
             if ($this->x_tick_label_pos == 'xaxis') {
                  $this->MostrarTexto($this->x_label_font, $this->x_label_angle, $x_pixels,
                                 $this->x_axis_y_pixels + $this->x_tick_length*1.5, $this->ndx_text_color,
                                 $xlab, 'center', 'bottom');
             }

             // Marcas superiores del area del grafico
             if ($this->x_tick_pos == 'plotup' || $this->x_tick_pos == 'both') {
                 ImageLine($this->img, $x_pixels, $this->plot_area[1] - $this->x_tick_length,
                           $x_pixels, $this->plot_area[1] + $this->x_tick_cross, $this->ndx_tick_color);
             }
             //  Marcas inferiores del area del grafico
             if ($this->x_tick_pos == 'plotdown' || $this->x_tick_pos == 'both') {
                 ImageLine($this->img, $x_pixels, $this->plot_area[3] + $this->x_tick_length,
                           $x_pixels, $this->plot_area[3] - $this->x_tick_cross, $this->ndx_tick_color);
             }

             // Marcas de etiquetas superiores del area del grafico
             if ($this->x_tick_label_pos == 'plotup' || $this->x_tick_label_pos == 'both') {
                 $this->MostrarTexto($this->x_label_font, $this->x_label_angle, $x_pixels,
                                 $this->plot_area[1] - $this->x_tick_length*1.5, $this->ndx_text_color,
                                 $xlab, 'center', 'top');
             }

             // Marcas de etiquetas inferiores del area del grafico
             if ($this->x_tick_label_pos == 'plotdown' || $this->x_tick_label_pos == 'both') {
                 $this->MostrarTexto($this->x_label_font, $this->x_label_angle, $x_pixels,
                                 $this->plot_area[3] + $this->x_tick_length*1.5, $this->ndx_text_color,
                                 $xlab, 'center', 'bottom');
             }
         }
         return;
     }

     //-------------------------------------------------------------------------
     // MostrarBordeTrama
     // Descripcion: Dibuja los bordes del área del gráfico
     // Parametros : <Ninguno>
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function MostrarBordeTrama()
     {
         switch ($this->plot_border_type) {
         case 'left':    // para la compatibilidad pasada
         case 'plotleft':
             ImageLine($this->img, $this->plot_area[0], $this->ytr($this->plot_min_y),
                       $this->plot_area[0], $this->ytr($this->plot_max_y), $this->ndx_grid_color);
             break;
         case 'right':
         case 'plotright':
             ImageLine($this->img, $this->plot_area[2], $this->ytr($this->plot_min_y),
                       $this->plot_area[2], $this->ytr($this->plot_max_y), $this->ndx_grid_color);
             break;
         case 'both':
         case 'sides':
              ImageLine($this->img, $this->plot_area[0], $this->ytr($this->plot_min_y),
                       $this->plot_area[0], $this->ytr($this->plot_max_y), $this->ndx_grid_color);
             ImageLine($this->img, $this->plot_area[2], $this->ytr($this->plot_min_y),
                       $this->plot_area[2], $this->ytr($this->plot_max_y), $this->ndx_grid_color);
             break;
         case 'none':
             //No dibuja borde
             break;
         case 'full':
         default:
             ImageRectangle($this->img, $this->plot_area[0], $this->ytr($this->plot_min_y),
                            $this->plot_area[2], $this->ytr($this->plot_max_y), $this->ndx_grid_color);
             break;
         }
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // MostrarXEtiquetaData
     // Descripcion: Dibuja la etiqueta de los datos asociada con un punto en el grafico.
     //              Esta es diferente a la x_labels dibujado desde MostrarMarcasEjeX(), y cuidado
     //              debe tomarse para no dibujar ambos, cuando ellos probablemente se solaparían.
     //              Llamando de esta función en MostrarLineas (), el etc se decide
     //              después de que el valor del x_data_label_pos.Omita el último
     //              parámetro, evitar el dibujo de líneas verticales, no importa
     //              lo que la configuración es (para graficas que la necesiten, como MostrarAngulosRectos ())
     // Parametros : xlab      -  String  - con el Nombre de la Etiqueta en el Eje X
     //              xpos      -  Entero  - Posición en el Eje X
     //              row       -  Boolean -
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function MostrarXEtiquetaData($xlab, $xpos, $row=FALSE)
     {
         $xlab = $this->FormatoEtiquetas('x', $xlab);

         // Labels below the plot area
         if ($this->x_data_label_pos == 'plotdown' || $this->x_data_label_pos == 'both')
             $this->MostrarTexto($this->x_label_font, $this->x_label_angle, $xpos,
                             $this->plot_area[3] + $this->x_tick_length,
                             $this->ndx_text_color, $xlab, 'center', 'bottom');

         // Labels above the plot area
         if ($this->x_data_label_pos == 'plotup' || $this->x_data_label_pos == 'both')
             $this->MostrarTexto($this->x_label_font, $this->x_label_angle, $xpos,
                             $this->plot_area[1] - $this->x_tick_length ,
                             $this->ndx_text_color, $xlab, 'center', 'top');

         if ($row && $this->draw_x_data_label_lines)
             $this->MostrarXLineaData($xpos, $row);
     }

     //-------------------------------------------------------------------------
     // MostrarXLineaData
     // Descripcion: Dibuja las líneas Verticales de arriba abajo de los puntos de los datos.
     //              cuales líneas son arrastrado depende del valor de x_data_label_pos,
     //              y si esto se hace en absoluto o no, en el draw_x_data_label_lines
     // Parametros : xpos      -  Entero  - Posición en pixeles de la línea
     //              xpos      -  Entero  - Posición en el Eje X
     //              row       -  Entero  - el índice de la fila a ser dibujado de los datos.
     // Retorno    : <Ninguno>
     //-------------------------------------------------------------------------
     function MostrarXLineaData($xpos, $row)
     {
         // Fija el estilo de la lineas IMG_COLOR_STYLED (grid)
         if($this->dashed_grid) {
             $this->SetDashedStyle($this->ndx_light_grid_color);
             $style = IMG_COLOR_STYLED;
         } else {
             $style = $this->ndx_light_grid_color;
         }

         //Lineas de fondo superiores
         if ($this->x_data_label_pos == 'both') {
             ImageLine($this->img, $xpos, $this->plot_area[3], $xpos, $this->plot_area[1], $style);
         }
         // Lineas que vienen de fondo del grafico
         else if ($this->x_data_label_pos == 'plotdown') {
             // Ver EncontrarLimitesData() para ver porque indice 'MAXY'.
             $ypos = $this->ytr($this->data[$row][MAXY]);
             ImageLine($this->img, $xpos, $ypos, $xpos, $this->plot_area[3], $style);
         }
         // Líneas que vienen de arriba de la grafica
         else if ($this->x_data_label_pos == 'plotup') {
             // Ver EncontrarLimitesData() para ver porque indice 'MINY'.
             $ypos = $this->ytr($this->data[$row][MINY]);
             ImageLine($this->img, $xpos, $this->plot_area[1], $xpos, $ypos, $style);
         }
     }

     //-------------------------------------------------------------------------
     // MostrarLeyenda
     // Descripcion: Dibuja la leyenda del gráfico.
     // debe calcularse la longitud de la etiqueta máxima más con precisión por las TT Fonts
     // Realizando un cálculo de BBox para cada elemento de la leyenda, por ejemplo.
     //              cuales líneas son arrastrado depende del valor de x_data_label_pos,
     //              y si esto se hace en absoluto o no, en el draw_x_data_label_lines
     // Parametros : which_x1      -  Entero  - Posición en pixeles de la línea
     //              which_y1      -  Entero  - Posición en el Eje X
     //              which_boxtype -  String  - el índice de la fila a ser dibujado de los datos.
     // Retorno    : <Ninguno>
     //-------------------------------------------------------------------------
     function MostrarLeyenda($which_x1, $which_y1, $which_boxtype)
     {
         // Encuentra la maxima longitud de las Etiquetas
         $max_len = 0;
         foreach ($this->legend as $leg) {
             $len = strlen($leg);
             $max_len = ($len > $max_len) ? $len : $max_len;
         }
         $max_len += 5;          // Permite establecer un espacio de margenes

         // Calcula el tamaño de las leyendas de las etiquetas
         // TTF:
         if ($this->use_ttf) {
             $size = $this->TTFBBoxSize($this->legend_font['size'], 0,
                                        $this->legend_font['font'], '_');
             $char_w = $size[0];

             $size = $this->TTFBBoxSize($this->legend_font['size'], 0,
                                        $this->legend_font['font'], '|');
             $char_h = $size[1];
         }
         // Establece fuentes:
         else {
             $char_w = $this->legend_font['width'];
             $char_h = $this->legend_font['height'];
         }

         $v_margin = $char_h/2;                         // Entre Bordes verticales y etiquetas
         $dot_height = $char_h + $this->line_spacing;   // La altura de las zonas coloreadas pequeñas
         $width = $char_w * $max_len;

         //Calcula tamaño de las zonas
         // Arriba / Izquierda
         if ( (! $which_x1) || (! $which_y1) ) {
             $box_start_x = $this->plot_area[2] - $width;
             $box_start_y = $this->plot_area[1] + 5;
         } else {
             $box_start_x = $which_x1;
             $box_start_y = $which_y1;
         }

         // Esquina Inferior derecha
         $box_end_y = $box_start_y + $dot_height*(count($this->legend)) + 2*$v_margin;
         $box_end_x = $box_start_x + $width - 5;


         // Dibuja fuera del area
         if ($this->input_file=='') {
            ImageFilledRectangle($this->img, $box_start_x, $box_start_y, $box_end_x, $box_end_y, $this->ndx_bg_color);
         }   
         ImageRectangle($this->img, $box_start_x, $box_start_y, $box_end_x, $box_end_y, $this->ndx_grid_color);

         $color_index = 0;
         $max_color_index = count($this->ndx_data_colors) - 1;

         $dot_left_x = $box_end_x - $char_w * 2;
         $dot_right_x = $box_end_x - $char_w;
         $y_pos = $box_start_y + $v_margin;

         foreach ($this->legend as $leg) {
             // Texto alineado a la derecha de la caja pequeña
             $this->MostrarTexto($this->legend_font, 0, $dot_left_x - $char_w, $y_pos,
                             $this->ndx_text_color, $leg, 'right');
             // Dibuja un area en el color de la data
             ImageFilledRectangle($this->img, $dot_left_x, $y_pos + 1, $dot_right_x,
                                  $y_pos + $dot_height-1, $this->ndx_data_colors[$color_index]);
             // Dibuja un rectangulo alrededor del area
             ImageRectangle($this->img, $dot_left_x, $y_pos + 1, $dot_right_x,
                            $y_pos + $dot_height-1, $this->ndx_text_color);

             $y_pos += $char_h + $this->line_spacing;

             $color_index++;
             if ($color_index > $max_color_index) 
                 $color_index = 0;
         }
     }

     //-------------------------------------------------------------------------
     // MostrarLeyendaEjes
     // Descripcion: Dibuja una grafica debajo del eje del grafico
     // Parametros : <Ninguno>
     // Retorno    : <Ninguno>
     //-------------------------------------------------------------------------
     function MostrarLeyendaEjes()
     {
         // Calcula el area disponible
         // Calcule longitud de todos los items (las areas incluidas)
         // Dibuja.
     }

     //-------------------------------------------------------------------------
     // <FIN DE DEFINICION DE RUTINAS GENERICAS DE DIBUJADO>
     //-------------------------------------------------------------------------

     //-------------------------------------------------------------------------
     // <DEFINICION DE RUTINAS DE DIBUJADO DEL GRAFICO>
     //-------------------------------------------------------------------------

     //-------------------------------------------------------------------------
     // MostrarGraficoTorta
     // Descripcion: Dibuja una grafica de Torta. la data debe ser de tipo
     //              'text-data'. Esta rutina puede trabajar de dos maneras:
     //              El clásico, con una columna para cada sector
     //              (calcula la columna suma y dibuja el grafico de torta con esos valores)
     //              o   Toma cada fila como un sector y usa el primer valor.
     //              la ventaja de usar las etiquetas proporciona con que no es
     //              el caso del método anterior. Esto podría demostrar útil
     //              para los graficos de torta del GRUPO POR las consultas del sql
     // Parametros : <Ninguno>
     // Retorno    : <Ninguno>
     //-------------------------------------------------------------------------

     function MostrarGraficoTorta()
     {
         $xpos = $this->plot_area[0] + $this->plot_area_width/2;
         $ypos = $this->plot_area[1] + $this->plot_area_height/2;
         $diameter = min($this->plot_area_width, $this->plot_area_height);
         $radius = $diameter/2;
         $expscale =1;

         // Consigue la suma de cada columna? Un pedazo de Torta por cada Columna
         if ($this->data_type === 'text-data') {
             for ($i = 0; $i < $this->num_data_rows; $i++) {
                 //La etiqueta ($row[0]) sin uso en éstos graficos de torta
                 for ($j = 1; $j < $this->num_recs[$i]; $j++) {
                     // NOTA!  sum > 0 para hacer pedazos de la torta
                     @ $sumarr[$j] += abs($this->data[$i][$j]);
                 }
             }
         }
         // ¿O sólo una columna por la fila, una rodaja de la torta por la fila?
         else if ($this->data_type == 'text-data-pie') {
             for ($i = 0; $i < $this->num_data_rows; $i++) {
                 //Pone la leyenda de las etiquetas de la columna
                 $legend[$i] = $this->data[$i][0];
                 $sumarr[$i] = $this->data[$i][1];
             }
         }
         else if ($this->data_type == 'data-data') {
             for ($i = 0; $i < $this->num_data_rows; $i++) {
                 for ($j = 2; $j < $this->num_recs[$i]; $j++) {
                     @ $sumarr[$j] += abs($this->data[$i][$j]);
                 }
             }
         }
         else {
             $this->MostrarError("MostrarGraficoTorta(): Tipo de data no soportada.");
             return FALSE;
         }

         $total = array_sum($sumarr);

         if ($total == 0) {
             $this->MostrarError('MostrarGraficoTorta(): Data vacia');
             return FALSE;
         }

         if ($this->shading) {
             $diam2 = $diameter / 2;
         } else {
             $diam2 = $diameter;
         }
         $max_data_colors = count ($this->data_colors);

         // Si se tienen que separar todas las piezas de tortas
         // se le asigna el radio por defecto de la propiedad explode_r
         //
         if( $this->explode_all )
	         for($i=0; $i < $n; ++$i)
         		$this->explode_radius[$i]=$this->explode_r;


         for ($h = $this->shading; $h >= 0; $h--) {
             $color_index = 0;
             $start_angle = 0;
             $end_angle = 0;
             foreach ($sumarr as $val) {
                 // Para los pasteles sombreados: el último uno (a la cima de la pila)
                 //tiene un color más luminoso:
                 if ($h == 0)
                     $slicecol = $this->ndx_data_colors[$color_index];
                 else
                     $slicecol = $this->ndx_data_dark_colors[$color_index];

                 $label_txt = number_format(($val / $total * 100), $this->y_precision, '.', ', ') . '%';
                 $val = 360 * ($val / $total);

                 // La NOTA que el imagefilledarc mide los ángulos
                 // EN EL SENTIDO DE LAS AGUJAS DEL RELOJ (va figurar por qué),
                 // para que el grafico de torta empiece en el sentido de las
                 // agujas del reloj de las 3, podria no ser para la inversión
                 // de salida y ángulos del fin en el imagefilledarc ()
                 $start_angle = $end_angle;
                 $end_angle += $val;
                 $mid_angle = deg2rad($end_angle - ($val / 2));

                 $IndexRadius =$color_index;

                 if( empty($this->explode_radius[$IndexRadius]) )
           		     $this->explode_radius[$IndexRadius]=0;


                 $la = 2*M_PI - (abs((360-$end_angle)-(360-$start_angle))/2.0+(360-$start_angle));

             	  $xcm = $xpos + $this->explode_radius[$IndexRadius]*cos($la)*$expscale;
                 $ycm = ($ypos+$h) - $this->explode_radius[$IndexRadius]*sin($la)*$expscale;
                 
                 // Dibuja una rodaja
                 $xcm = round($xcm); $ycm = round($ycm);
                 ImageFilledArc($this->img, /*$xpos, $ypos+$h,*/$xcm,$ycm, $diameter, $diam2,
                                360-$end_angle, 360-$start_angle,
                                $slicecol, IMG_ARC_PIE);

                 // Sólo dibuje una vez las etiquetas
                 //
                 if ($h == 0) {

                     // Dibuja el contorno
                     if (! $this->shading)
                         ImageFilledArc($this->img, /*$xpos, $ypos+$h*/$xcm,$ycm,$diameter, $diam2,
                                        360-$end_angle, 360-$start_angle,
                                        $this->ndx_grid_color, IMG_ARC_PIE | IMG_ARC_EDGED |IMG_ARC_NOFILL);


                     // El '* 1.2' el truco es sacar las etiquetas así del grafico de
                     // torta hay más  oportunidades que estas pueden verse en los
                     // sectores pequeños.
                     $label_x = /*$xpos*/ $xcm + ($diameter * 1.2 * cos($mid_angle)) * $this->label_scale_position;
                     $label_y = /*$ypos+$h*/$ycm - ($diam2 * 1.2 * sin($mid_angle)) * $this->label_scale_position;

                     $this->MostrarTexto($this->generic_font, 0, $label_x, $label_y, $this->ndx_grid_color,
                                     $label_txt, 'center', 'center');
                 }
                 $color_index++;
                 $color_index = $color_index % $max_data_colors;
             }   // Fin for
         }   // Fin for
     }

     //-------------------------------------------------------------------------
     // MostrarPuntosError
     // Descripcion: Dibuja los errores de puntos, Los Formatos de datos soportados
     //              Son data-data-error, text-data-error (no existe todavia)
     //             ( la data viene dentro de un arreglo como
     //               ("titulo", x, y, error+, error-, y2, error2+, error2-, ...) )
     // Parametros : <Ninguno>
     // Retorno    : <Ninguno>
     //-------------------------------------------------------------------------
     function MostrarPuntosError()
     {
         $this->ChequearOpcion($this->data_type, 'data-data-error', __FUNCTION__);

         for($row = 0, $cnt = 0; $row < $this->num_data_rows; $row++) {
             $record = 1;                                // Salta el registro #0 (titulo)

             // Hace que nosotros tengamos un valor para X
             if ($this->data_type == 'data-data-error')
                 $x_now = $this->data[$row][$record++];  // lee Valor, advanza el indice del registro
             else
                 $x_now = 0.5 + $cnt++;                  // Coloca text-data en X = 0.5, 1.5, 2.5, etc...

             // Dibuja en el eje X las datas de las etiquetas?
             if ($this->x_data_label_pos != 'none')
                 $this->MostrarXEtiquetaData($this->data[$row][0], $x_now_pixels, $row);

             while ($record < $this->num_recs[$row]) {
                     // Y:
                     $y_now = $this->data[$row][$record++];

                     $point_sizetemp=($this->points_shapes[$record] == 'diamond' or $this->points_shapes[$record] == 'triangle')&&
                     $this->points_sizes[$record] % 2 != 0?$this->points_sizes[$record]+1:$this->points_sizes[$record];

                     $this->MostrarPunto($x_now, $y_now,
                     $this->points_shapes[$record],$point_sizetemp, $this->ndx_data_colors[$record]);

                     // Error +
                     $val = $this->data[$row][$record++];
                     $this->MostrarYBarrasError($x_now, $y_now, $val, $this->error_bar_shape,
                                          $this->ndx_error_bar_colors[$record]);
                     // Error -
                     $val = $this->data[$row][$record];
                     $this->MostrarYBarrasError($x_now, $y_now, -$val, $this->error_bar_shape,
                                          $this->ndx_error_bar_colors[$record++]);
             }
         }
     }

     //-------------------------------------------------------------------------
     // MostrarPuntos
     // Descripcion: Dibuja los puntos del grafico, los tipos soportados
     //              - data-data ("titulo", x, y1, y2, y3, ...)
     //              - text-data ("titulo", y1, y2, y3, ...)
     // Parametros : <Ninguno>
     // Retorno    : <Ninguno>
     //-------------------------------------------------------------------------
     function MostrarPuntos()
     {
         $this->ChequearOpcion($this->data_type, 'text-data, data-data', __FUNCTION__);

         for ($row = 0, $cnt = 0; $row < $this->num_data_rows; $row++) {
             $rec = 1;                    // Salta el primer registro #0 (etiqueta de data)

             // ¿Nosotros tenemos el valor por X?
             if ($this->data_type == 'data-data')
                 $x_now = $this->data[$row][$rec++];  // Lee, Incrementa el indice del Registro
             else
                 $x_now = 0.5 + $cnt++;       // Coloca text-data en X = 0.5, 1.5, 2.5, etc...

             $x_now_pixels = $this->xtr($x_now);

             //  Dibuja en el eje X las datas de las etiquetas?
             if ($this->x_data_label_pos != 'none')
                 $this->MostrarXEtiquetaData($this->data[$row][0], $x_now_pixels, $row);

             // Procede con los valores de Y
             for($idx = 0;$rec < $this->num_recs[$row]; $rec++, $idx++) {
                 if (is_numeric($this->data[$row][$rec])) {
                     $point_sizetemp=($this->points_shapes[$idx] == 'diamond' or $this->points_shapes[$idx] == 'triangle')&&
                     $this->points_sizes[$idx] % 2 != 0?$this->points_sizes[$idx]+1:$this->points_sizes[$idx];
                     $this->MostrarPunto($x_now, $this->data[$row][$rec],
                            $this->points_shapes[$idx],
                            $point_sizetemp,$this->ndx_data_colors[$idx]);
                 }
             }
         }
     }
     //-------------------------------------------------------------------------
     // MostrarBarrasDeLineasDelgadas
     // Descripcion: Una Rutina que limpia, rapida para cuando usted quiere trazar
     //              Graficos de Volumen accionarios
     // Parametros : <Ninguno>
     // Retorno    : <Ninguno>
     //-------------------------------------------------------------------------
     function MostrarBarrasDeLineasDelgadas()
     {
         $this->ChequearOpcion($this->data_type, 'text-data, data-data', __FUNCTION__);

         for ($row = 0, $cnt = 0; $row < $this->num_data_rows; $row++) {
             $rec = 1;                    //  Salta el primer registro #0 (etiqueta de data)

             // Hacemos un valor para X?
             if ($this->data_type == 'data-data')
                 $x_now = $this->data[$row][$rec++];  // // Lee, Incrementa el indice del Registro
             else
                 $x_now = 0.5 + $cnt++;       // Coloca text-data en X = 0.5, 1.5, 2.5, etc...

             $x_now_pixels = $this->xtr($x_now);

             //  Dibuja en el eje X las datas de las etiquetas?
             if ($this->x_data_label_pos != 'none')
                 $this->MostrarXEtiquetaData($this->data[$row][0], $x_now_pixels);

             // Procede con los valores de Y
             for($idx = 0;$rec < $this->num_recs[$row]; $rec++, $idx++) {
                 if (is_numeric($this->data[$row][$rec])) {              // Permite verificar datos de Y
                     ImageSetThickness($this->img, $this->line_widths[$idx]);
                     // Dibuja una linea desde una posicion en el eje X, definida por
                     // el usuario para ytr($val)
                     ImageLine($this->img, $x_now_pixels, $this->x_axis_y_pixels, $x_now_pixels,
                               $this->ytr($this->data[$row][$rec]), $this->ndx_data_colors[$idx]);
                 }
             }
         }

         ImageSetThickness($this->img, 1);
     }

     //-------------------------------------------------------------------------
     // MostrarYBarrasError
     // Descripcion: Una Rutina que limpia, rapida para cuando usted quiere trazar
     //              Graficos de Volumen accionarios
     // Parametros : x_world         -  Entero - Posición en X
     //              y_world         -  Entero - Posición en Y
     //              error_height    -  Entero - Altura del Error
     //              error_bar_type  -  Entero - Tipo de barra de error
     //              color           -  Entero - Color
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function MostrarYBarrasError($x_world, $y_world, $error_height, $error_bar_type, $color)
     {

         $x1 = $this->xtr($x_world);
         $y1 = $this->ytr($y_world);
         $y2 = $this->ytr($y_world+$error_height) ;

         ImageSetThickness($this->img, $this->error_bar_line_width);
         ImageLine($this->img, $x1, $y1 , $x1, $y2, $color);

         switch ($error_bar_type) {
         case 'line':
             break;
         case 'tee':
             ImageLine($this->img, $x1-$this->error_bar_size, $y2, $x1+$this->error_bar_size, $y2, $color);
             break;
         default:
             ImageLine($this->img, $x1-$this->error_bar_size, $y2, $x1+$this->error_bar_size, $y2, $color);
             break;
         }

         ImageSetThickness($this->img, 1);
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // MostrarPunto
     // Descripcion: Dibuja un estilo de puntos. Usar coordenadas.
     // Tipos Soportados : 'halfline', 'line', 'plus', 'cross', 'rect', 'circle', 'dot',
     //                    'diamond', 'triangle', 'trianglemid'
     // Parametros : x_world         -  Entero - Posición en X
     //              y_world         -  Entero - Posición en Y
     //              dot_type        -  String - Tipo de Punto
     //              ASize           -  Entero - Tamaño del Punto
     //              color           -  Entero - Color
     // Retorno    : TRUE
     //-------------------------------------------------------------------------
     function MostrarPunto($x_world, $y_world, $dot_type, $ASize,$color)
     {
         $half_point = $ASize / 2;

         $x_mid = $this->xtr($x_world);
         $y_mid = $this->ytr($y_world);

         $x1 = $x_mid - $half_point;
         $x2 = $x_mid + $half_point;
         $y1 = $y_mid - $half_point;
         $y2 = $y_mid + $half_point;

         switch ($dot_type) {
         case 'halfline':
             ImageLine($this->img, $x1, $y_mid, $x_mid, $y_mid, $color);
             break;
         case 'line':
             ImageLine($this->img, $x1, $y_mid, $x2, $y_mid, $color);
             break;
         case 'plus':
             ImageLine($this->img, $x1, $y_mid, $x2, $y_mid, $color);
             ImageLine($this->img, $x_mid, $y1, $x_mid, $y2, $color);
             break;
         case 'cross':
             ImageLine($this->img, $x1, $y1, $x2, $y2, $color);
             ImageLine($this->img, $x1, $y2, $x2, $y1, $color);
             break;
         case 'rect':
             ImageFilledRectangle($this->img, $x1, $y1, $x2, $y2, $color);
             break;
         case 'circle':
             ImageArc($this->img, $x_mid, $y_mid, $ASize,$ASize, 0, 360, $color);
             break;
         case 'dot':
             ImageFilledArc($this->img, $x_mid, $y_mid,$ASize,$ASize, 0, 360,
                            $color, IMG_ARC_PIE);
             break;
         case 'diamond':
             $arrpoints = array( $x1, $y_mid, $x_mid, $y1, $x2, $y_mid, $x_mid, $y2);
             ImageFilledPolygon($this->img, $arrpoints, 4, $color);
             break;
         case 'triangle':
             $arrpoints = array( $x1, $y_mid, $x2, $y_mid, $x_mid, $y2);
             ImageFilledPolygon($this->img, $arrpoints, 3, $color);
             break;
         case 'trianglemid':
             $arrpoints = array( $x1, $y1, $x2, $y1, $x_mid, $y_mid);
             ImageFilledPolygon($this->img, $arrpoints, 3, $color);
             break;
         default:
             ImageFilledRectangle($this->img, $x1, $y1, $x2, $y2, $color);
             break;
         }
         return TRUE;
     }

     //-------------------------------------------------------------------------
     // MostrarArea
     // Descripcion: Dibuja un grafico de area. Tipos de datas soportados:
     //              'text-data'
     //              'data-data'
     //              NOTA: Esta función es usada para agregar primero y últimos valores de los datos
     //                    y establecen los incopletos. Ése no es ahora el comportamiento.
     //                    En cuanto a los datos perdidos en el intervalo,
     //                    hay dos posibilities: reemplazar el punto con uno en el eje de X
     //                    (Forma anterior), o se olvida de él y usa el precediendo y
     //                    siguientes para dibujar el polígono.
     //                    Hay la posibilidad de usar ambos, nosotros apenas necesitamos
     //                    agregar el método para ponerlo. Algo como SetMissingDataBehaviour (),por ejemplo
     // Parametros : <Ninguno>
     // Retorno    : <Ninguno>
     //-------------------------------------------------------------------------
     function MostrarArea()
     {
         $incomplete_data_defaults_to_x_axis = FALSE;        // TODO: Hacer esto configurable

         for ($row = 0, $cnt = 0; $row < $this->num_data_rows; $row++) {
             $rec = 1;                                       // Salta el primer registro #0 (etiqueta de data)

             if ($this->data_type == 'data-data')            // se hace un valor para X?
                 $x_now = $this->data[$row][$rec++];         // lee, Avanza el indice del registro
             else
                 $x_now = 0.5 + $cnt++;                      // lugar text-data en X = 0.5, 1.5, 2.5, etc...

             $x_now_pixels = $this->xtr($x_now);             // Coordenadas absolutas


             if ($this->x_data_label_pos != 'none')          // Dibujar etoquetas del Eje X?
                 $this->MostrarXEtiquetaData($this->data[$row][0], $x_now_pixels);

             // Continua con los valores de Y
             // Create array of points for imagefilledpolygon()
             for($idx = 0; $rec < $this->num_recs[$row]; $rec++, $idx++) {
                 if (is_numeric($this->data[$row][$rec])) {
                     $y_now_pixels = $this->ytr($this->data[$row][$rec]);

                     $posarr[$idx][] = $x_now_pixels;
                     $posarr[$idx][] = $y_now_pixels;

                     $num_points[$idx] = isset($num_points[$idx]) ? $num_points[$idx]+1 : 1;
                 }
                 // Si hay datos perdidos
                 else {
                     if (isset ($incomplete_data_defaults_to_x_axis)) {
                         $posarr[$idx][] = $x_now_pixels;
                         $posarr[$idx][] = $this->x_axis_y_pixels;
                         $num_points[$idx] = isset($num_points[$idx]) ? $num_points[$idx]+1 : 1;
                     }
                 }
             }
         }   // FIN FOR

         $end = count($posarr);
         for ($i = 0; $i < $end; $i++) {
             // Prepara los puntos iniciales. X = primer punto es X, Y = x_axis_y_pixels
             $x = $posarr[$i][0];
             array_unshift($posarr[$i], $x, $this->x_axis_y_pixels);

             // Agrega los puntos finales. X = ultimo punto en X, Y = x_axis_y_pixels
             $x = $posarr[$i][count($posarr[$i])-2];
             array_push($posarr[$i], $x, $this->x_axis_y_pixels);

             $num_points[$i] += 2;

             // Dibuja el poligono
             ImageFilledPolygon($this->img, $posarr[$i], $num_points[$i], $this->ndx_data_colors[$i]);
         }

     }

     //-------------------------------------------------------------------------
     // MostrarLineas
     // Descripcion: Dibuja lineas. Tipos de datas soportados:
     //              'text-data'
     //              'data-data'
     //              NOTA: Por favor vea la nota que considera los datos incompletos
     //                    fijados en MostrarArea ()
     // Parametros : <Ninguno>
     // Retorno    : <Ninguno>
     //-------------------------------------------------------------------------
     function MostrarLineas()
     {
         // Esto nos dirá si las líneas ya han empezado a ser dibujadas
         // es una serie para guardar la información separada para cada línea,
         // con un solo inconstante nosotros a veces haríamos errores y
         // ninguna grafica al desplazamiento" "indefinido...
         // 

         $start_lines = array_fill(0, $this->records_per_group, FALSE);

         if ($this->data_type == 'text-data') {
             $lastx[0] = $this->xtr(0);
             $lasty[0] = $this->xtr(0);
         }

         for ($row = 0, $cnt = 0; $row < $this->num_data_rows; $row++) {
             $record = 1;                                    // Salta el registro #0 (etiqueta de datos)

             if ($this->data_type == 'data-data')            // tenemos un valor X?
                 $x_now = $this->data[$row][$record++];      // lee, incrementa el indice del registro
             else
                 $x_now = 0.5 + $cnt++;                      // Coloca text-data en X = 0.5, 1.5, 2.5, etc...

             $x_now_pixels = $this->xtr($x_now);             // Coordenadas absolutas

             if ($this->x_data_label_pos != 'none')          // Dibujan las etiquetas del eje X?
                 $this->MostrarXEtiquetaData($this->data[$row][0], $x_now_pixels, $row);

             for ($idx = 0; $record < $this->num_recs[$row]; $record++, $idx++) {
                 if (is_numeric($this->data[$row][$record])) {
                     $y_now_pixels = $this->ytr($this->data[$row][$record]);

                     if ($start_lines[$idx] == TRUE) {
                         // Fija el ancho de la linea, revierte esto al final normal
                         ImageSetThickness($this->img, $this->line_widths[$idx]);

                         if ($this->line_styles[$idx] == 'dashed') {
                             $this->SetDashedStyle($this->ndx_data_colors[$idx]);
                             ImageLine($this->img, $x_now_pixels, $y_now_pixels, $lastx[$idx], $lasty[$idx],
                                       IMG_COLOR_STYLED);
                         } else {
                             ImageLine($this->img, $x_now_pixels, $y_now_pixels, $lastx[$idx], $lasty[$idx],
                                       $this->ndx_data_colors[$idx]);
                         }

                     }
                     $lasty[$idx] = $y_now_pixels;
                     $lastx[$idx] = $x_now_pixels;
                     $start_lines[$idx] = TRUE;
                 }
                 // Data de Y faltante... ¿nosotros debemos dejar un espacio en blanco o no?
                 else if ($this->draw_broken_lines) {
                     $start_lines[$idx] = FALSE;
                 }
             }   // FIN for
         }   // FIN for

         // Revierta al estado original para las líneas a ser dibujadas después.
         ImageSetThickness($this->img, 1);
     }

     //-------------------------------------------------------------------------
     // MostrarLineasError
     // Descripcion: Dibuja lineas con las barras de error. la data viene como:
     //              array("Etiqueta", x, y, error+, error-, y2, error2+, error2-, ...);
     // Parametros : <Ninguno>
     // Retorno    : <Ninguno>
     //-------------------------------------------------------------------------
     function MostrarLineasError()
     {
         if ($this->data_type != 'data-data-error') {
             $this->MostrarError("MostrarLineasError(): Tipo de data '$this->data_type' no soportado.");
             return FALSE;
         }

         $start_lines = array_fill(0, $this->records_per_group, FALSE);

         for ($row = 0, $cnt = 0; $row < $this->num_data_rows; $row++) {
             $record = 1;                                    // Salta registro #0 (Etiqueta de datos)

             $x_now = $this->data[$row][$record++];          // Leer el valor de X, Avanza el indice del registro

             $x_now_pixels = $this->xtr($x_now);             // Coordenadas absolutas.


             if ($this->x_data_label_pos != 'none')          // Dibuja etiquetas en el eje X?
                 $this->MostrarXEtiquetaData($this->data[$row][0], $x_now_pixels, $row);

             // Ahora se hara para Y, E+, E-
             for ($idx = 0; $record < $this->num_recs[$row]; $idx++) {
                 // Y
                 $y_now = $this->data[$row][$record++];
                 $y_now_pixels = $this->ytr($y_now);

                 if ($start_lines[$idx] == TRUE) {
                     ImageSetThickness($this->img, $this->line_widths[$idx]);

                     if ($this->line_styles[$idx] == 'dashed') {
                         $this->SetDashedStyle($this->ndx_data_colors[$idx]);
                         ImageLine($this->img, $x_now_pixels, $y_now_pixels, $lastx[$idx], $lasty[$idx],
                                   IMG_COLOR_STYLED);
                     } else {
                         ImageLine($this->img, $x_now_pixels, $y_now_pixels, $lastx[$idx], $lasty[$idx],
                                   $this->ndx_data_colors[$idx]);
                     }
                 }

                 // Error+
                 $val = $this->data[$row][$record++];
                 $this->MostrarYBarrasError($x_now, $y_now, $val, $this->error_bar_shape,
                                      $this->ndx_error_bar_colors[$idx]);

                 // Error-
                 $val = $this->data[$row][$record++];
                 $this->MostrarYBarrasError($x_now, $y_now, -$val, $this->error_bar_shape,
                                      $this->ndx_error_bar_colors[$idx]);

                 // Actualiza los indices:
                 $start_lines[$idx] = TRUE;   // Nos dice si nosotros ya dibujáramos
                                              // la primera columna de puntos,
                                              // teniendo así $el lastx y $los lasty
                                              // preparados para la próxima columna.
                 $lastx[$idx] = $x_now_pixels;
                 $lasty[$idx] = $y_now_pixels;
             }   // end while
         }   // FIN for

         // Revierta al estado original para las líneas a ser dibujadas después.
         ImageSetThickness($this->img, 1);
     }

     //-------------------------------------------------------------------------
     // MostrarAngulosRectos
     // Descripcion: Ésta es una copia no más de MostrarLineas () con una más línea
     //              dibujada para cada punto
     // Parametros : <Ninguno>
     // Retorno    : <Ninguno>
     //-------------------------------------------------------------------------
     function MostrarAngulosRectos()
     {
         // Esto nos dirá si las líneas ya han empezado a ser dibujadas.
         // Es una serie para guardar la información separada para cada línea,
         // para un simple variable nosotros a veces podríamos hacer errores
         // y ninguna grafica al desplazamiento" "indefinido...
         $start_lines = array_fill(0, $this->records_per_group, FALSE);

         if ($this->data_type == 'text-data') {
             $lastx[0] = $this->xtr(0);
             $lasty[0] = $this->xtr(0);
         }

         for ($row = 0, $cnt = 0; $row < $this->num_data_rows; $row++) {
             $record = 1;                                    // Salta el registro #0 (etiqueta de datas)

             if ($this->data_type == 'data-data')            // tenemos un valor para X?
                 $x_now = $this->data[$row][$record++];      // lo leemos, avanza el registro del indice
             else
                 $x_now = 0.5 + $cnt++;                      // Coloca text-data en X = 0.5, 1.5, 2.5, etc...

             $x_now_pixels = $this->xtr($x_now);             // Coordenadas aboslutas

             if ($this->x_data_label_pos != 'none')          // Dibuja las etiquetas del eje X?
                 $this->MostrarXEtiquetaData($this->data[$row][0], $x_now_pixels); // Avertencia no hay ningún parametro

             // Dibuja las lineas
             for ($idx = 0; $record < $this->num_recs[$row]; $record++, $idx++) {
                 if (is_numeric($this->data[$row][$record])) {               // Verificación de Data en Y
                     $y_now_pixels = $this->ytr($this->data[$row][$record]);

                     if ($start_lines[$idx] == TRUE) {
                         // Fija el ancho de lineas
                         ImageSetThickness($this->img, $this->line_widths[$idx]);

                         if ($this->line_styles[$idx] == 'dashed') {
                             $this->SetDashedStyle($this->ndx_data_colors[$idx]);
                             ImageLine($this->img, $lastx[$idx], $lasty[$idx], $x_now_pixels, $lasty[$idx],
                                       IMG_COLOR_STYLED);
                             ImageLine($this->img, $x_now_pixels, $lasty[$idx], $x_now_pixels, $y_now_pixels,
                                       IMG_COLOR_STYLED);
                         } else {
                             ImageLine($this->img, $lastx[$idx], $lasty[$idx], $x_now_pixels, $lasty[$idx],
                                       $this->ndx_data_colors[$idx]);
                             ImageLine($this->img, $x_now_pixels, $lasty[$idx], $x_now_pixels, $y_now_pixels,
                                       $this->ndx_data_colors[$idx]);
                         }
                     }
                     $lastx[$idx] = $x_now_pixels;
                     $lasty[$idx] = $y_now_pixels;
                     $start_lines[$idx] = TRUE;
                 }

                 // Data en Y pèrdida... ¿nosotros debemos dejar un espacio en blanco o no?
                 else if ($this->draw_broken_lines) {
                     $start_lines[$idx] = FALSE;
                 }
             }
         }   // FIN while

         ImageSetThickness($this->img, 1);
     }

     //-------------------------------------------------------------------------
     // MostrarBarras
     // Descripcion: Dibuja graficos de barras.
     //              la data viene como array("title", x, y, y2, y3, ...)
     // Parametros : <Ninguno>
     // Retorno    : <Ninguno>
     //-------------------------------------------------------------------------
     function MostrarBarras()
     {
         if ($this->data_type != 'text-data') {
             $this->MostrarError('MostrarBarras(): Graficos de barra deben ser text-data: usar función SetTipoData("text-data")');
             return FALSE;
         }

         for ($row = 0; $row < $this->num_data_rows; $row++) {
             $record = 1;                                    // Salta el registro #0 (etiqueta de datas)

             $x_now_pixels = $this->xtr(0.5 + $row);         // coloca text-data en X = 0.5, 1.5, 2.5, etc...

             if ($this->x_data_label_pos != 'none')          // Dibuja las etiquetas del eje X?
                 $this->MostrarXEtiquetaData($this->data[$row][0], $x_now_pixels);

             // Dibuja las barras
             for ($idx = 0; $record < $this->num_recs[$row]; $record++, $idx++) {
                 if (is_numeric($this->data[$row][$record])) {
                     $x1 = $x_now_pixels - $this->data_group_space + ($idx * $this->record_bar_width);
                     $x2 = $x1 + ($this->bar_width_adjust * $this->record_bar_width);

                     if ($this->data[$row][$record] < $this->x_axis_position) {
                         $y1 = $this->x_axis_y_pixels;
                         $y2 = $this->ytr($this->data[$row][$record]);
                     } else {
                         $y1 = $this->ytr($this->data[$row][$record]);
                         $y2 = $this->x_axis_y_pixels;
                     }

                     if ($this->shading) {                           // Dibuja la sombra?
                         ImageFilledPolygon($this->img, array($x1, $y1,
                                                        $x1 + $this->shading, $y1 - $this->shading,
                                                        $x2 + $this->shading, $y1 - $this->shading,
                                                        $x2 + $this->shading, $y2 - $this->shading,
                                                        $x2, $y2,
                                                        $x2, $y1),
                                            6, $this->ndx_data_dark_colors[$idx]);
                     }
                     // o dibuja un borde?
                     else {
                         ImageRectangle($this->img, $x1, $y1, $x2,$y2, $this->ndx_data_border_colors[$idx]);
                     }
                     // Dibuja la barra
                     ImageFilledRectangle($this->img, $x1, $y1, $x2, $y2, $this->ndx_data_colors[$idx]);
                 }
             }   // FIN for
         }   // FIN for
     }

     //-------------------------------------------------------------------------
     // DrawStackedBars
     // Descripcion: Dibuja grafico de barras apiladas, la data viene como un arreglo
	 //               array("title", x, y, y2, y3, ...).
     // Parametros : <Ninguno>
     // Retorno    : TRUE si realiza de forma correcta, FALSE en caso contrario
     //-------------------------------------------------------------------------
     function DrawStackedBars()
     {
        if ($this->data_type != 'text-data') {
            $this->DrawError('DrawStackedBars(): Graficas de barras debe ser la data text-data: use SetTipoData("text-data")');
            return FALSE;
        }

        for ($row = 0; $row < $this->num_data_rows; $row++) {
            $record = 1;                                    // Salta registro#0 (etiqueta de datas)

            $x_now_pixels = $this->xtr(0.5 + $row);         // Coloca text-data en X = 0.5, 1.5, 2.5, etc...

            if ($this->x_data_label_pos != 'none')          // Dibujar las etiquetas de data del eje X?
                $this->MostrarXEtiquetaData($this->data[$row][0], $x_now_pixels);

            // Dibuja las barras
            $oldv = 0;
            for ($idx = 0; $record < $this->num_recs[$row]; $record++, $idx++) {
                if (is_numeric($this->data[$row][$record])) {       // Permite filtrar la data del eje Y
                    $x1 = $x_now_pixels - $this->data_group_space;
                    $x2 = $x_now_pixels + $this->data_group_space; 

                    $y1 = $this->ytr(abs($this->data[$row][$record]) + $oldv);
                    $y2 = $this->ytr($this->x_axis_position + $oldv);
                    $oldv += abs($this->data[$row][$record]);

                    if ($this->shading) {                           // Dibuja la sombra?
                        ImageFilledPolygon($this->img, array($x1, $y1, 
                                                       $x1 + $this->shading, $y1 - $this->shading,
                                                       $x2 + $this->shading, $y1 - $this->shading,
                                                       $x2 + $this->shading, $y2 - $this->shading,
                                                       $x2, $y2,
                                                       $x2, $y1),
                                           6, $this->ndx_data_dark_colors[$idx]);
                    } 
                    // o Dibuja un borde?
                    else {
                        ImageRectangle($this->img, $x1, $y1, $x2,$y2, $this->ndx_data_border_colors[$idx]);
                    }
                    // Dibuja la barra
                    ImageFilledRectangle($this->img, $x1, $y1, $x2, $y2, $this->ndx_data_colors[$idx]);
                    
                } 
            }   // FIN for
        }   // FIN for
     }
	 
	 //-------------------------------------------------------------------------
     // DibujarGrafica
     // Descripcion: Dibuja grafico.
     // Parametros : <Ninguno>
     // Retorno    : TRUE si realiza de forma correcta, FALSE en caso contrario
     //-------------------------------------------------------------------------
     function DibujarGrafica()
     {
         if (! $this->img) {
             $this->MostrarError('DibujarGrafica(): Ningún recurso de la imagen se asignó');
             return FALSE;
         }

         if (! is_array($this->data)) {
             $this->MostrarError("DibujarGrafica(): No hay data en array \$data");
             return FALSE;
         }

         if (! isset($this->data_limits_done))
             $this->EncontrarLimitesData();                // Consigue la maxima y minima escala

         if ($this->total_records == 0) {            // Chequea si la data esta vacia
             $this->MostrarError('Conjunto de data vacia');
             return FALSE;
         }

         $this->CalcularMargenes();                       // Calcula margenes

         if (! isset($this->plot_area_width))        //Fija el area del grafico en pixeles (plot_area[])
             $this->SetAreaGraficoPixels();

         if (! isset($this->plot_max_y))             // Fija el area del grafico para valores (plot_max_x, etc.)
             $this->SetAreaTramasWorld();
		
         if ($this->plot_type == 'bars' || $this->plot_type == 'stackedbars') // Calcula el ancho de las barras
            $this->CalcBarWidths();
	 

         if ($this->data_type == 'text-data')
             $this->SetIgualXCoord();

         if ($this->x_data_label_pos != 'none') {    // El valor predeterminado: no dibuja el relleno de la Marca si
             $this->x_tick_label_pos = 'none';       // Hay etiquetas de los datos.
             $this->x_tick_pos = 'none';
         }

         $this->PadArrays();                         // El color del relleno y estilos de series para encajar los registros por el grupo.


         $this->MostrarFondo();

         $this->MostrarBordeImagen();

         if ($this->draw_plot_area_background)
             $this->MostrarTramaAreaFondo();

         $this->MostrarTitulo();
         $this->MostrarXTitulo();
         $this->MostrarYTitulo();

         switch ($this->plot_type) {
         case 'thinbarline':
             $this->MostrarBarrasDeLineasDelgadas();
             break;
         case 'area':
             $this->MostrarArea();
             break;
         case 'squared':
             $this->MostrarAngulosRectos();
             break;
         case 'lines':
             if ( $this->data_type == 'data-data-error') {
                 $this->MostrarLineasError();
             } else {
                 $this->MostrarLineas();
             }
             break;
         case 'linepoints':
              //  MostrarXEtiquetaData se llama en MostrarLineas () y MostrarPuntos ()
             if ( $this->data_type == 'data-data-error') {
                 $this->MostrarLineasError();
                 $this->MostrarPuntosError();
             } else {
                 $this->MostrarLineas();
                 $this->MostrarPuntos();
             }
             break;
         case 'points';
             if ( $this->data_type == 'data-data-error') {
                 $this->MostrarPuntosError();
             } else {
                 $this->MostrarPuntos();
             }
             break;
         case 'pie':
             // Los graficos de torta aumentan al maximo el espacio de la imagen
             $this->SetAreaGraficoPixels($this->safe_margin, $this->title_height,
                                      $this->image_width - $this->safe_margin,
                                      $this->image_height - $this->safe_margin);
             $this->MostrarGraficoTorta();
             break;
 		case 'stackedbars':
            $this->DrawStackedBars();
         break; 	 
         case 'bars':
         default:
             $this->plot_type = 'bars';  // Póngalo si ya no fue puesto.
             $this->MostrarEjeY();     // Nosotros no queremos las rejillas para borrar los mapas de la barra
             $this->MostrarEjeX();     // así que nosotros lo dibujamos primero.
                                     // También, Y debe dibujarse ante X (vea MostrarEjeY ())
             $this->MostrarBarras();
             $this->MostrarBordeTrama();
             break;
         }   // FIN switch

         if ($this->plot_type != 'pie' && $this->plot_type != 'bars') {
             $this->MostrarEjeY();
             $this->MostrarEjeX();
             $this->MostrarBordeTrama();
         }
         if ($this->legend)
             $this->MostrarLeyenda($this->legend_x_pos, $this->legend_y_pos, '');

         if ($this->print_image)
             $this->PrintImagen();

     }

     //-------------------------------------------------------------------------
     // <FIN DE DEFINICION DEFINICION DE RUTINAS DE DIBUJADO DEL GRAFICO>
     //-------------------------------------------------------------------------

     //-------------------------------------------------------------------------
     // SetNuevaAreaPixelsGrafica
     // Descripcion: Fija el area para un nuevo grafico dentro de la imagen de un grafico.
     // Parametros : x1    -  Entero  - Posicion Izquierda en X
     // Parametros : Y1    -  Entero  - Posicion Superior Izquierda
     // Parametros : X2    -  Entero  - Posicion Derecha
     // Parametros : Y2    -  Entero  - Posicion Derecha Inferior
     // Retorno    : TRUE si realiza de forma correcta, FALSE en caso contrario
     //-------------------------------------------------------------------------
     function SetNuevaAreaPixelsGrafica($x1, $y1, $x2, $y2)
     {
        //Como en GD 0, 0 es superior izquierda Fija via pixel las Coordenadas
        $this->plot_area = array($x1, $y1, $x2, $y2);
        $this->plot_area_width = $this->plot_area[2] - $this->plot_area[0];
        $this->plot_area_height = $this->plot_area[3] - $this->plot_area[1];
        $this->y_top_margin = $this->plot_area[1];

        if (isset($this->plot_max_x))
            $this->CalcTranslacion();

        return TRUE;
    }

  //< FIN DE METODOS DE LA CLASE>
}
//<FIN CLASE>


//-------------------------------------------------------------------------
// <RUTINAS VARIAS PARA CLASE>
//-------------------------------------------------------------------------

//-------------------------------------------------------------------------
// array_pad_array
// Descripcion: rellena o asigna una serie con otra o con sí misma.
// Parametros : arr      -  array   - arreglo original (referencia)
//              size     -  int     - Tamaño del arreglo resultante.
//              arr2     -  array   - Si es espeficado, arreglo para usar para rellenar.
//                                    Si no se espeficica, rellena con $arr.
// Retorno    : TRUE si realiza de forma correcta, FALSE en caso contrario
//-------------------------------------------------------------------------
function array_pad_array(&$arr, $size, $arr2=NULL)
{
    if (! is_array($arr2)) {
        $arr2 = $arr;                           // copia el arreglo original
    }
    while (count($arr) < $size)
        $arr = array_merge($arr, $arr2);        // agrega cada elemento hasta que termine
}

//-------------------------------------------------------------------------
// CheckGDVersion
// Descripcion: Devuelve cual de las librerías GD se encuentra instalada
// Parametros : <Ninguno>
// Retorno    : 0 = Libreria no instalada
//              1 = GD1
//              2 = GD2
//-------------------------------------------------------------------------
function CheckGDVersion() {
    $GDfuncList = get_extension_funcs('gd');
    if( !$GDfuncList ) return 0 ;
    else {
	if( in_array('imagegd2',$GDfuncList) &&
	    in_array('imagecreatetruecolor',$GDfuncList))
	    return 2;
	else
	    return 1;
    }
}


//-------------------------------------------------------------------------
// <FIN DE RUTINAS VARIAS PARA CLASE>
//-------------------------------------------------------------------------

?>