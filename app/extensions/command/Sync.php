<?php
/**
 * Lithiumphp: the most rad php framework
 *
 * @copyright     Copyright 2013, brünsicke.com GmbH (http://bruensicke.com)
 */

namespace app\extensions\command;

use app\extensions\data\Sources;

/**
 * Get information about all repositories configured in folder 'sources'.
 */
class Sync extends \lithium\console\Command {

	/**
	 * comma-separated list of sources to skip
	 *
	 * @var string
	 */
	public $skip = '';

	/**
	 * Auto run the sync command.
	 *
	 * @param string $source Name of the source to sync or 'list' to choose from available sources.
	 * @return void
	 */
	public function run($source = null) {
		if (!$source) {
			$this->_syncAll();
			return true;
		}
		if ($source === 'list') {
			return $this->_listSources();
		}

		return $this->_work($source);
	}

	protected function _syncAll() {
		$sources = $this->_getSources();
		foreach ($sources as $source) {
			$this->_fork($source);
		}
	}

	protected function _listSources() {
		$sources = $this->_getSources();
		foreach ($sources as $idx => $source) {
			$this->out(sprintf('%s. %s', ++$idx, $source));
		}
		$options = array(
			'default' => 'q',
		);
		$res = $this->in('which source?', $options);
		if ($res === 'q' || !isset($sources[$res-1])) {
			$this->stop(1);
		}
		$source = $sources[$res-1];
		$this->_fork($source);
	}

	protected function _getSources() {
		return Sources::find();
	}

	protected function _fork($source) {
		$li3 = LITHIUM_LIBRARY_PATH . '/lithium/console/lithium.php';
		$command = strtolower(basename(str_replace('\\', '/', __CLASS__)));
		$cmd = sprintf('php -q %s --app=%s %s %s', $li3, LITHIUM_APP_PATH, $command, $source);
		$output = shell_exec($cmd);
		$this->out($output);
	}

	protected function _work($source) {
		$skip = explode(',', $this->skip);
		$this->out(sprintf('{:heading}%-25s{:end}', $source), false);
		if (in_array($source, $skip)) {
			$this->out('{:yellow}skipped.{:end}', false);
			return true;
		}
		if (!Sources::sync($source)) {
			$this->out('{:error}failed.{:end}', false);
			return false;
		}
		$this->out('{:success}done.{:end}', false);
		return true;
	}
}

?>