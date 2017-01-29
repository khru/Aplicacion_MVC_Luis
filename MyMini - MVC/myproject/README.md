# myMini
<b>Repositorios de mi máquina mini</b><br/>
Instala una máquina vagrant con las características del proyecto original "panique/mini" y algunas modificaciones añadidas.<br/>
La máqina viene totalmente preparada para trabajar sin necesidad de realizar ninguna operación adicional.<br/>

<b>Para generar la máquina, seguir estos pasos:</b><br/>
<i>Los pasos 0 y 3 son omitibles si ya tienes vagrant instalado y la box Trusty64 instalada, puedes consultar tus box instaladas con el comando "vagrant box list"</i><br/>
0 - Instalar Vagrant<br/>
1 - Descargar los archivos "Vagrantfile" y "Boostrap" que se encuentran en la carpeta _vagrant<br/>
2 - Mover ambos archivos a la carpeta donde queréis crear la máquina<br/>
3 - Instalar la box Trusty64 (o cambiar la box en el archivo Vagrantfile)<br/>
4 - Ejecutar el comando "vagrant up" desde una consola situada en dicha carpeta<br/>
<br/>

<b>Algunas de las modificaciones sobre el proyecto mini original son:</b><br/>
0 - Incluye php 5.6, Composer y los paquetes: Plates, Dice, Kint y Phpmailer<br/>
1 - Utiliza la nomenclatura StudlyCaps en los nombres de los archivos de clases, evitando problemas de autoload en sistemas Linux<br/>
2 - Utiliza, por convención, la nomenclatura camealCase en los nombres del resto de archivos<br/>
3 - El directorio "plates" ha sido suprimido ya que su funcionalidad era meramente educativa, las plantillas cuelgan directamente del directorio "view", aunque puede cambiarse desde core/Application.php <i>Línea:27</i><br/>
4 - Cualquier archivo desactualizado u obsoleto, cuya única razón de existencia era conservar los archivos que se han ido realizando en vez de reemplazarlos por los nuevos (<i>ejemplos: view-old.php, canciones.php</i>) ha sido removido, con el fin de partir de una aplicación limpia.<br/>
5 - Está adaptada hasta la última clase de MVC (incluyendo la inyección de dependencias que se realizó)<br/>
<br/>

Los archivos "Vagrantfile" y "Boostrap" están traducidos (en la medida de lo posible) para que puedan ser<br/>
fácilmente personalizables, algunas características importantes son:<br/>
<br/>
<b>Vagrantfile</b><br/>
0 -  Box a utilizar(Por defecto: ubuntu/trusty64) <i>Línea 10</i><br/>
<br/>
<b>Boostrap</b><br/>
0 - Contraseña de la base de datos(Por defecto: 123) <i>Línea 6</i><br/>
1 - Nombre del archivo .sql con la base de datos(Por defecto: database.sql) <i>Línea 9</i><br/>
2 - Repositorio Git a clonar (podéis poner los repositorios mini originales, pero perdereis Composer y sus paquetes, además de que los nombres de los archivos estarán en minúsculas pudiendo producir errores en Linux) <i>Línea 15</i><br/>

