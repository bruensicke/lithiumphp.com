<?php

namespace app\controllers;

class SourcesController extends \lithium\action\Controller {

	/**
	 * recieves payload from github to update commits
	 *
	 * @see https://help.github.com/articles/post-receive-hooks
	 * @return void
	 */
	public function github() {
		$data = ($this->request->data['payload'])
			? json_decode($this->request->data['payload'], true)
			: array();
		if(empty($data)) {
			exit;
		}
		file_put_contents(LITHIUM_SUITE_PATH . '/resources/tmp/last_commit.json', json_encode($data));
		$source = $data['repository']['name'];
		Logger::debug(sprintf('recieved commit hook for %s: %s', $source, json_encode($data)));
		Sources::sync($source);
		exit;
	}
}

?>