<?php
/**
 * Birthday
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

class Birthday
{
	public $filehandler;
	public $bgImage;

	public function __construct()
	{
		$this->filehandler = new Filehandler();
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
		$lines = $this->filehandler->readCSV();
		for ($i = 0; $i < count($lines); $i++) {
			if (!empty($lines[$i])) {
				list($firstname, $lastname, $birthdate) = $lines[$i];
				if ($this->compareBirthdayWithToday($birthdate) != FALSE) {
					$allBirthdays[] = $this->listTodaysBirthday($firstname, $lastname); 
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

	private function listTodaysBirthday($firstname, $lastname)
	{
		$output = '<span class="firstname">' . $firstname . '</span>';
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
			foreach ($result as $birthday) {
				echo $birthday;
			}
		}
	}

	public function getBackgroundImage()
	{
		return $this->bgImage;
	}

	public function setBackgroundImage($path)
	{
		$this->bgImage = 'img/' . $path . '.jpg';
	}
}