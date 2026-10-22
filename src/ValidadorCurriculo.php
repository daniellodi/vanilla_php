 <?php
 require_once __DIR__ . '/Curriculo.php';

 /**
  * Valida los datos del formulario de alta de un currículo y, si son
  * válidos, construye con ellos el objeto Curriculo.
  */
 class ValidadorCurriculo
 {
     /**
      * @param array<string, Ciclo> $ciclos Ciclos que ofrece el centro, indexados por su código.
      */
     public function __construct(
         private readonly array $ciclos,
     ) {
     }

     /**
      * @param array<string, mixed> $datos Datos recibidos, normalmente $_POST.
      * @return array<string, string> Errores por campo; vacío si los datos son válidos.
      */
     public function validar(array $datos): array
     {
         $errores = [];

         $alumno = trim($datos['alumno'] ?? '');
         if ($alumno === '') {
             $errores['alumno'] = 'El nombre del alumno es obligatorio.';
         } elseif (mb_strlen($alumno) > 100) {
             $errores['alumno'] = 'El nombre del alumno no puede superar los 100 caracteres.';
         }

         $codCiclo = $datos['ciclo'] ?? '';
         if (!array_key_exists($codCiclo, $this->ciclos)) {
             $errores['ciclo'] = 'Elige uno de los ciclos de la lista.';
         }

         $video = trim($datos['video'] ?? '');
         if ($video !== ''
             && (filter_var($video, FILTER_VALIDATE_URL) === false || !str_starts_with($video, 'https://'))) {
             $errores['video'] = 'El vídeo debe ser una URL que empiece por https://';
         }

         return $errores;
     }

     /**
      * Construye el currículo a partir de datos que ya han pasado validar().
      *
      * @param array<string, mixed> $datos
      */
     public function crearCurriculo(array $datos, int $id): Curriculo
     {
         $video = trim($datos['video'] ?? '');

         return new Curriculo(
             $id,
             trim($datos['alumno']),
             $this->ciclos[$datos['ciclo']],
             $video === '' ? null : $video,
         );
     }
 }