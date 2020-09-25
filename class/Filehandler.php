<?php

/**
 * Filehandler
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

class Filehandler  
{
	private $importDir = "import/";
	private $fileMode = 'r';
	private $importFilename = "birthday.csv";

	public function __construct()
	{
		$this->setImportPath();
	}

	/**
	 * Öffnet eine Datei und gibt diese als Ressource zurück.
	 *
	 * @return 	ressource	
	 *         	Die übergebene Datei als Resource.
	 */
	private function fileOpen()
	{
		return fopen($this->getImportPath(), $this->getFileMode());
	}

	public function readFileContent()
	{	
		$file = $this->fileOpen();
		$content = fread($file, filesize($this->getImportPath()));
		$lines = explode(PHP_EOL, $content);
		return $lines;
	}

	public function readCSV()
	{
		$file = $this->fileOpen();
		$datas = array();
		while (($data = fgetcsv($file, 0, ";")) !== FALSE) {
			$datas[] = $data;
		}

		return $datas;
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

	/**
	 * Gibt den neu definierten Dateinamen zurück.
	 *
	 * @return 	string
	 *         	Der neu definierte Dateiname.
	 */
	public function getImportFileName()
	{
		return $this->importFilename;
	}

	/**
	 * Setzt einen neuen Import Filename.
	 *
	 * @param 	string $filename
	 *         	Der neu definierte Dateiname.
	 */
	public function setImportFileName($filename)
	{
		$this->filename = $filename;
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
}
