<?php

namespace app\controllers;

use app\models\Sources as SourcesModel;
use app\extensions\data\Sources;
use lithium\util\Inflector;

class DocsController extends BaseController {

	/**
	 * adds additional view template folders
	 */
	public function _init() {
		parent::_init();
		$this->_render['layout'] = 'docs';
	}

	public function index() {
		$finder = $this->request->finder;
		$sources = SourcesModel::find($finder);
		// var_dump($sources->data());exit;
		return compact('sources');
	}

	public function view($slug = null) {
		$slug = (!is_null($slug))
			? implode('/', func_get_args())
			: 'README.md';

		$library = $this->request->name;
		// echo $library;exit;
		$config = Sources::get($library);
		$source = SourcesModel::load($library);
		if ($config === false) {
			return $this->redirect('/docs');
		}
		// echo $slug;exit;
		$folder = Sources::folder($library, $config['path']);
		$file = sprintf('%s/%s', $folder, $slug);
		$filename = sprintf('%s', $slug);
		$name = Inflector::humanize($slug);
		$content = file_get_contents($file);
		$files = Sources::files($library, array('md', 'markdown'));
		return compact('source', 'library', 'file','files', 'filename', 'name', 'slug', 'content', 'config');
	}
}

?>