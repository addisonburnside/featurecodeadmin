<?PHP
//	License for all code of this FreePBX module can be found in the license file inside the module directory
//	Copyright (C) 2014 Schmooze Com Inc.
namespace FreePBX\modules;
class Featurecodeadmin implements \BMO {
	public function __construct($freepbx = null) {
		if ($freepbx == null) {
			throw new Exception("Not given a FreePBX Object");
		}
		$this->FreePBX = $freepbx;
	}
	public function install() {}
	public function uninstall() {}
	public function backup() {}
	public function restore($backup) {}
	public function doConfigPageInit($page) {}
	public function getActionBar($request) {
		$buttons = array();
		switch($request['display']) {
			case 'featurecodeadmin':
				$buttons = array(
					'reset' => array(
						'name' => 'reset',
						'id' => 'reset',
						'value' => _('Reset')
					),
					'submit' => array(
						'name' => 'submit',
						'id' => 'submit',
						'value' => _('Submit')
					)
				);
			break;
		}
		return $buttons;
	}

	public function update($codes=array()) {
		if(!empty($codes)) {
			foreach($codes as $module => $features) {
				foreach($features as $name => $data) {
					$fcc = new \featurecode($module, $name);
					if(!empty($data['enable'])) {
						$fcc->setEnabled(true);
					} else {
						$fcc->setEnabled(false);
					}

					if(empty($data['customize']) || ($data['code'] == $fcc->getDefault())) {
						$fcc->setCode('');
					} else {
						$fcc->setCode($data['code']);
					}
					$fcc->update();
				}
			}
		}
	}

}
