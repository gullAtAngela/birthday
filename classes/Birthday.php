<?php
/**
 * Hash Generator
 *
 * This file is part of the Framie Framework.
 *
 * @link		$HeadURL$
 * @version     $Id$
 *
 * The Framie WAF/CMS is a modern web application framework and content
 * management system  written for  PHP 7.1 or  higher.  It is implemented
 * fully object-oriented and  takes advantage of the latest web standards
 * such as HTML5 and CSS3.  Thanks to the modular design  and the variety
 * of features,  the system can quickly be adapted to given requirements.
 *
 *               Copyright (c) 2019 - 2020 gullDesign
 *                         All rights reserved.
 *
 * THIS SOFTWARE IS PROVIDED  BY THE  COPYRIGHT HOLDERS  AND CONTRIBUTORS
 * "AS IS"  AND ANY  EXPRESS OR  IMPLIED  WARRANTIES,  INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED  WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE  ARE DISCLAIMED.  IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR  CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL,  EXEMPLARY,  OR  CONSEQUENTIAL  DAMAGES  (INCLUDING,  BUT NOT
 * LIMITED TO,  PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION)  HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY,  WHETHER IN CONTRACT,  STRICT LIABILITY,  OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE)  ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE,  EVEN IF ADVISED OF  THE POSSIBILITY OF SUCH DAMAGE.
 *
 *
 * @license		http://gulldesign.ch/license.txt
 * @copyright	Copyright (c) 2019 - 2020 gullDesign
 * @link		https://bitbucket.org/gulldesign/framie
 */

/**
 * Birthday
 *
 */
class Birthday
{

	private $importDir = "import/";
	private $fileMode = 'r';
	private $importFilename = "birthday.csv";
	public $bgImage;

	
	public function __construct()
	{
		$this->setImportPath();
	}

	/**
	 * Gibt das Import Verzeichnis zurück.
	 *
	 * @return 	string
	 *         	Gibt das definierte Import Verzeichnis zurück. Default ist import/.
	 */
	public function getImportDir()
	{
		return $this->importDir;
	}

	/**
	 * Setzt ein neues Import Verzeichnis.
	 *
	 * @param 	string $importDir
	 *         	Das neu definierte Import Verzeichnis.
	 */
	public function setImportDir($importDir)
	{
		$this->importDir = $importDir;
	}

	public function setImportFileName($filename)
	{
		$this->filename = $filename;
	}

	public function getImportFileName()
	{
		return $this->importFilename;
	}

	/**
	 * Holt sich den definierten File Handle Mode.
	 *
	 * @return 	string
	 *         	FileMode für die unterschiedlichen Dateihandler Methoden.
	 *			Default is readable.
	 */
	public function getFileMode()
	{
		return $this->fileMode;
	}

	/**
	 * Damit kann ein neuer File Handle Mode definiert werden. Um festzulegen
	 * wie eine Datei geöffnet werden soll. Lese- oder Schreibmodus.
	 *
	 * @param 	string $mode
	 *         	Definition des entsprechenden File Handle Modus.
	 */
	public function setFileMode($mode)
	{
		$this->fileMode = $mode;
	}

	/**
	 * Gibt den ganzen Import Pfad zurück.
	 *
	 * @return 	string
	 *         	Gibt den definierte Import Pfad zurück.
	 */
	public function getImportPath()
	{
		return $this->importPath;
	}

	/**
	 * Setzt einen neuen Import Pfad basierend auf dem ImportDir und dem 
	 * eingestellten Dateinamen. Die Tiefe kann damit frei definiert werden.
	 *
	 * @param 	string $filename
	 *         	Der enstprechende Dateiname für die Importdatei.
	 *			Default ist birthday.csv.
	 */
	public function setImportPath()
	{
		if ($this->getImportFileName()) {
			$this->importPath = $this->getImportDir() . $this->getImportFileName();
		}
	}

	public function setBackgroundImage($path)
	{
		$this->bgImage = 'img/' . $path . '.jpg';
	}


	public function getBackgroundImage()
	{
		return $this->bgImage;
	}

	private function readFileContent()
	{	
		$file = fopen($this->getImportPath(), $this->getFileMode());
		$content = fread($file, filesize($this->getImportPath()));
		$lines = explode(PHP_EOL, $content);
		return $lines;
	}
	
	private function readCSV()
	{
		$file = fopen($this->getImportPath(), $this->getFileMode());
		
		$datas = array();
		while (($data = fgetcsv($file, 0, ";")) !== FALSE) {
			$datas[] = $data;
		}

		return $datas;
	}

	/**
	 * Arbeitet eine ganze CSV Datei mit den entprechenden Spalten ab. Daraus werden 
	 * 3 Spalten ausgelesen und als Geburtsdatum, Vorname und Nachname hinterlegt.
	 * Die Geburtsdaten werden mit dem heutigen Datum gegengeprüft und bei einer 
	 * übereinstimmung in eine Array aufgenommen.
	 * Wenn kein Eintrag vorhanden ist, wird FALSE zurückgegeben.
	 *
	 * @return 	array $allBirthdays
	 *         	Alle die mit dem heutigen Tag eine übereinstimmung im Geburtsdatum haben.
	 * 			Wenn das Array leer ist, wird es als bool FALSE zurückgegeben.
	 */
	public function getAllBirthdays()
	{
		$lines = $this->readCSV();

		for ($i = 0; $i < count($lines); $i++) {
			if (!empty($lines[$i])) {
				list($firstname, $lastname, $birthdate) = $lines[$i];
				if ($this->compareBirthdayWithToday($birthdate) != FALSE) {
					$allBirthdays[] = $this->listTodaysBirthday($birthdate, $firstname, $lastname); 
				}
			}
		}
	
		$this->setBackgroundImage('geburtstag');

		if (empty($allBirthdays)) {
			$this->setBackgroundImage('nobday');
			$allBirthdays = FALSE;
		}

		return $allBirthdays;
	}

	/**
	 * Die Geburtsdaten werden mit dem heutigen Datum gegengeprüft und bei einer 
	 * übereinstimmung wird true zurückgegeben.
	 * Mit einem Optionalen Parameter kann die unterdrückung des Geburtsdatums unterbunden werden.
	 * Bedeutet, dass dann der Jahrgang auch übergeben wird.
	 *
	 * @return 	string $bday
	 *         	Das aktuelle Geburtsdatum.
	 * 
	 * @return 	bool $strippedMode
	 *         	FALSE bedeutet, dass das Datum mit dem Jahrgang geprüft wird.
	 * 			TRUE bedeutet, dass nur der Tag und der Monat zu Prüfung und Ausgabe
	 * 			herangezogen wird.
	 */
	private function compareBirthdayWithToday($bday, $strippedMode = TRUE)
	{
		$today = date('d.m');

		if ($strippedMode) {
			$bday = substr($bday, 0, 5);
		}

		return ($bday == $today) ? TRUE : FALSE;
	}

	private function listTodaysBirthday($birthdate, $firstname, $lastname)
	{
		$output  = '<span class="birthday"> </span>';
		$output .= '<span class="firstname">' . $firstname . '</span>';
		$output .= '<span class="lastname">' . $lastname . '</span>';

		return $output;
	}

	/**
	 * Rendert die ganze Ausgabe der einzelnen Geburtstagskinder mit einem entsprechenden Hintergrundbild.
	 * Das gleicher geschieht wenn kein Geburtstag vorhanden ist.
	 */
	public function render()
	{
		$result = $this->getAllBirthdays();

		if ($result) {
			//echo "<h3>Herzlichen Glückwunsch!</h3>";
			foreach ($result as $birthday) {
				echo $birthday;
			}
		} else {
			//echo '<span class="nobirthday"> Heute gibt es leider keinen Geburtstag zu feiern.</span>';
		}
	}
}