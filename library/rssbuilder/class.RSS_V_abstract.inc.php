<?php
require_once 'interface.RSS.inc.php';
require_once 'class.RSSBase.inc.php';
/**
* Class for creating an RSS-feed
* @author Michael Wimmer <flaimo@gmail.com>
* @category flaimo-php
* @copyright Copyright � 2002-2008, Michael Wimmer
* @license GNU General Public License v3
* @link http://code.google.com/p/flaimo-php/
* @package RSS
* @version 2.2.1
*/
abstract class RSS_V_abstract extends RSSBase implements RSS {

	protected $rssdata;
	protected $xml;
	protected $filename;

	function __construct(RSSBuilder &$rssdata) {
		parent::__construct();
		$this->rssdata =& $rssdata;
	} // end constructor

	protected function &getRSSData() {
		return $this->rssdata;
	} // end function

	protected function generateXML() {
		$this->xml = new DomDocument('1.0', $this->rssdata->getEncoding());
		$this->xml->appendChild($this->xml->createComment('RSS generated by Flaimo.com RSS Builder [' .  date('Y-m-d H:i:s')  .']'));
	} // end function

	public function outputRSS($output = TRUE) {
		if (!isset($this->xml)) {
			$this->generateXML();
		} // end if
		header('content-type: text/xml;charset=' . $this->rssdata->getEncoding() . " \r\n");
		header('Content-Disposition: inline; filename=' . $this->rssdata->getFilename());
		echo $this->xml->saveXML();
	} // end function

	public function saveRSS($path = '') {
		if (!isset($this->xml)) {
			$this->generateXML();
		} // end if
		$this->xml->save($path . $this->rssdata->getFilename());
		return (string) $path . $this->rssdata->getFilename();
	} // end function

	public function getRSSOutput() {
		if (!isset($this->xml)) {
			$this->generateXML();
		} // end if
		return $this->xml->saveXML();
	} // function
} // end class
?>